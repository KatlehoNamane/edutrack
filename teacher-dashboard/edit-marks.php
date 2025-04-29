<?php
session_start();
require_once dirname(__DIR__, 1) . '/db/db_config.php';

// Database connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'TEACHER') {
    header('Location: ../login.php');
    exit;
}

// Get student ID from URL
$studentId = isset($_GET['student_id']) ? $conn->real_escape_string($_GET['student_id']) : null;
if (!$studentId) {
    die('No student specified.');
}

$teacherId = $conn->real_escape_string($_SESSION['user_id']);

// Fetch subjects taught by teacher
$subjectSql = "SELECT subject FROM teacher_subjects WHERE teacher_id = '$teacherId'";
$subjectRes = $conn->query($subjectSql);
if (!$subjectRes || $subjectRes->num_rows === 0) {
    die('No subjects found for this teacher.');
}
$subjects = [];
while ($row = $subjectRes->fetch_assoc()) {
    $subjects[] = $row['subject'];
}

// Initialize
$success = '';
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['marks'], $_POST['term'])) {
    $marks = $_POST['marks']; // array: subject => mark
    // sanitize term
    $term = $conn->real_escape_string(trim($_POST['term']));
    $year = date('Y');

    foreach ($marks as $subjectName => $markValue) {
        // sanitize
        $subjectNameEsc = $conn->real_escape_string($subjectName);
        $markValue = (int)$markValue;
        if ($markValue < 0 || $markValue > 100) continue;

        // Check existing entry
        $checkSql = "SELECT id FROM subject_marks
                     WHERE student_id = '$studentId'
                       AND subject_name = '$subjectNameEsc'
                       AND teacher_id = '$teacherId'
                       AND year = '$year'
                       AND term = '$term'
                     LIMIT 1";
        $checkRes = $conn->query($checkSql);
        if ($checkRes && $checkRes->num_rows > 0) {
            // Update
            $markId = $checkRes->fetch_assoc()['id'];
            $updateSql = "UPDATE subject_marks
                          SET mark = $markValue, updated_at = CURRENT_TIMESTAMP
                          WHERE id = '$markId'";
            $conn->query($updateSql);
        } else {
            // Insert
            $id = uniqid('', true);
            $insertSql = "INSERT INTO subject_marks
                          (id, student_id, subject_name, teacher_id, term, year, mark)
                          VALUES
                          ('$id', '$studentId', '$subjectNameEsc', '$teacherId', '$term', '$year', $markValue)";
            $conn->query($insertSql);
        }
    }
    $success = "Marks for term '$term' updated successfully.";
    header("Location: dashboard.php");
}

// Fetch latest marks for each subject (for the selected or default term)
$marksData = [];
// Determine term: use POSTed term or default blank
$currentTerm = isset($term) ? $term : '';
foreach ($subjects as $subject) {
    $subjectEsc = $conn->real_escape_string($subject);
    $markSql = "SELECT mark FROM subject_marks
                WHERE student_id = '$studentId'
                  AND subject_name = '$subjectEsc'
                  AND teacher_id = '$teacherId'";
    if ($currentTerm) {
        $termEsc = $conn->real_escape_string($currentTerm);
        $markSql .= " AND term = '$termEsc'";
    }
    $markSql .= " ORDER BY created_at DESC LIMIT 1";
    $markRes = $conn->query($markSql);
    $marksData[$subject] = ($markRes && $markRes->num_rows > 0) ? $markRes->fetch_assoc()['mark'] : '';
}

// Fetch student name
$studentSql = "SELECT first_name, last_name FROM users WHERE id = '$studentId' LIMIT 1";
$studentRes = $conn->query($studentSql);
$student = $studentRes->fetch_assoc() ?: ['first_name' => '', 'last_name' => ''];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Marks for <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="p-6 bg-gray-100">
  <div class="max-w-xl mx-auto bg-white p-6 rounded-2xl shadow-md">
    <h1 class="text-2xl font-semibold mb-4">Edit Marks for <span class="text-orange-500"><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></span></h1>
    <?php if (!empty($success)): ?>
      <div class="mb-4 p-3 bg-green-100 text-green-800 rounded"><?= $success ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-4 flex items-center space-x-4">
        <label for="term" class="w-1/3 text-gray-700 font-medium">Term:</label>
        <input
          type="text"
          name="term"
          id="term"
          placeholder="e.g., Jan - March"
          required
          class="w-2/3 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
          value="<?= htmlspecialchars($currentTerm) ?>"
        >
      </div>
      <?php foreach ($marksData as $subjectName => $markValue): ?>
        <div class="mb-4">
          <label class="block text-gray-700 mb-1" for="mark_<?= htmlspecialchars($subjectName) ?>"><?= htmlspecialchars($subjectName) ?></label>
          <input type="number"
                 id="mark_<?= htmlspecialchars($subjectName) ?>"
                 name="marks[<?= htmlspecialchars($subjectName) ?>]"
                 min="0" max="100"
                 value="<?= htmlspecialchars($markValue) ?>"
                 class="w-full border border-gray-300 rounded-lg px-3 py-2">
        </div>
      <?php endforeach; ?>
      <div class="flex justify-end space-x-2">
        <a href="dashboard.php" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancel</a>
        <button type="submit" class="px-4 py-2 bg-orange-500 cursor-pointer text-white rounded hover:bg-orange-600">Save Changes</button>
      </div>
    </form>
  </div>
</body>
</html>
<?php $conn->close(); ?>
