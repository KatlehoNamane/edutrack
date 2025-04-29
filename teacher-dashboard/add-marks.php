<?php
session_start();
require_once dirname(__DIR__, 1) . '/db/db_config.php';
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Auth check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'TEACHER') {
    header('Location: login.php');
    exit;
}

$subjects    = $_SESSION['subjects'] ?? [];
$studentId   = $_GET['student_id']   ?? null;
$studentName = $_GET['student_name'] ?? 'Unknown';

if (!$studentId) {
    die("Missing student ID.");
}

$teacherId = $_SESSION['user_id'];
$year      = date('Y');
$messages  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo print_r($_POST);
    $term  = trim($_POST['term'] ?? '');
    $marks = $_POST['marks'] ?? [];

    // Basic term validation
    if ($term === '') {
        $messages[] = "<span class='text-red-500'>Please enter a term.</span>";
    } else {
        foreach ($marks as $subject => $mark) {
            $mark = intval($mark);

            if ($mark < 0 || $mark > 100) {
                $messages[] = "<span class='text-red-500'>Invalid mark for {$subject}. Must be between 0 and 100.</span>";
            } else {
                $id           = uniqid('', true);
                $subjectSafe  = $conn->real_escape_string($subject);
                $termSafe     = $conn->real_escape_string($term);

                $sql = "INSERT INTO subject_marks
                        (id, student_id, subject_name, teacher_id, term, year, mark)
                        VALUES
                        ('$id', '$studentId', '$subjectSafe', '$teacherId', '$termSafe', '$year', $mark)";

                if ($conn->query($sql) === TRUE) {
                    $messages[] = "<span class='text-green-600'>Saved: {$subject} – {$mark}</span>";
                    header("Location: ./dashboard.php");
                } else {
                    $messages[] = "<span class='text-red-500'>Error saving {$subject}: "
                                . htmlspecialchars($conn->error)
                                . "</span>";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student Marks</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

  <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">
      Enter Marks for <span class="text-orange-500"><?= htmlspecialchars($studentName) ?></span>
    </h1>

    <?php if (!empty($messages)): ?>
      <div class="mb-4 space-y-1">
        <?php foreach ($messages as $msg): ?>
          <div><?= $msg ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if (empty($subjects)): ?>
      <p class="text-gray-600">You are not assigned to any subjects yet.</p>
    <?php else: ?>
      <form method="POST" action="" class="space-y-6">

        <!-- Free-text term input -->
        <div class="flex items-center space-x-4">
          <label for="term" class="w-1/2 text-gray-700 font-medium">Term:</label>
          <input
            type="text"
            name="term"
            id="term"
            placeholder="e.g., Jan - March"
            required
            class="w-1/2 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
            value="<?= isset($term) ? htmlspecialchars($term) : '' ?>"
          >
        </div>

        <!-- Subject & mark inputs -->
        <?php foreach ($subjects as $subject): ?>
          <div class="flex items-center space-x-4">
            <input
              type="text"
              name="subject_display[]"
              value="<?= htmlspecialchars($subject) ?>"
              readonly
              class="w-1/2 p-2 bg-gray-100 border border-gray-300 rounded-md text-gray-700"
            >
            <input
              type="number"
              name="marks[<?= htmlspecialchars($subject) ?>]"
              min="0"
              max="100"
              required
              class="w-1/2 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
            >
          </div>
        <?php endforeach; ?>

        <div class="pt-4 flex justify-between items-center">
          <button
            type="submit"
            class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-2 rounded-md transition duration-200 cursor-pointer"
          >
            Submit Marks
          </button>
          <a href="./dashboard.php" class="text-blue-500 underline">Back to Dashboard</a>
        </div>
      </form>
    <?php endif; ?>

  </div>

</body>
</html>
