<?php
session_start();
require_once dirname(__DIR__, 1) . '/db/db_config.php';

// Database connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is principal
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'PRINCIPAL') {
    header('Location: login.php');
    exit;
}

// Get user id and role type from URL
$userId = isset($_GET['user_id']) ? $conn->real_escape_string($_GET['user_id']) : null;
$type   = isset($_GET['type']) ? strtoupper($conn->real_escape_string($_GET['type'])) : null; // STUDENT or TEACHER
if (!$userId || !in_array($type, ['STUDENT', 'TEACHER'])) {
    die('Invalid user specified.');
}

// Fetch user data
$sql = "SELECT first_name, last_name, email, school_name, role, class_name, student_number
        FROM users WHERE id = '$userId' AND role = '$type'";
$result = $conn->query($sql);
if (!$result || $result->num_rows !== 1) {
    die('User not found.');
}
$user = $result->fetch_assoc();

// Fetch teacher's current subjects
$currentSubjects = [];
if ($type === 'TEACHER') {
    $subSql = "SELECT subject FROM teacher_subjects WHERE teacher_id = '$userId'";
    $subRes = $conn->query($subSql);
    if ($subRes) {
        while ($row = $subRes->fetch_assoc()) {
            $currentSubjects[] = $row['subject'];
        }
    }
}

$success = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $conn->real_escape_string(trim($_POST['first_name']));
    $lastName  = $conn->real_escape_string(trim($_POST['last_name']));
    $email     = $conn->real_escape_string(trim($_POST['email']));
    $school    = $conn->real_escape_string(trim($_POST['school_name']));
    $class     = $type === 'STUDENT' ? $conn->real_escape_string(trim($_POST['class_name'])) : null;
    $studentNo = $type === 'STUDENT' ? $conn->real_escape_string(trim($_POST['student_number'])) : null;
    $subjects  = $type === 'TEACHER' && isset($_POST['subjects']) ? array_filter(array_map('trim', $_POST['subjects'])) : [];

    // Validation
    if (!$firstName || !$lastName || !$email || !$school) {
        $error = 'Please fill in all required fields.';
    } else {
        // Update users table
        $updateSql = "UPDATE users SET 
            first_name = '$firstName', 
            last_name = '$lastName', 
            email = '$email', 
            school_name = '$school'";
        if ($type === 'STUDENT') {
            $updateSql .= ", class_name = '$class', student_number = '$studentNo'";
        }
        $updateSql .= " WHERE id = '$userId' AND role = '$type'";
        if (!$conn->query($updateSql)) {
            $error = 'Error updating user: ' . $conn->error;
        }

        // Update teacher subjects
        if (empty($error) && $type === 'TEACHER') {
            // Delete all existing
            $delSql = "DELETE FROM teacher_subjects WHERE teacher_id = '$userId'";
            if (!$conn->query($delSql)) {
                $error = 'Error deleting subjects: ' . $conn->error;
            }
            // Insert updated list
            if (empty($error)) {
                foreach ($subjects as $subj) {
                    $subEsc = $conn->real_escape_string($subj);
                    $insSql = "INSERT INTO teacher_subjects (teacher_id, subject) 
                               VALUES ('$userId', '$subEsc')";
                    if (!$conn->query($insSql)) {
                        $error = 'Error inserting subject $subEsc: ' . $conn->error;
                        break;
                    }
                }
            }
        }

        if (empty($error)) {
            header("Location: index.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit <?= ucfirst(strtolower($type)) ?> Info</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="p-6 bg-gray-100">
  <div class="max-w-lg mx-auto bg-white p-6 rounded-2xl shadow-md">
    <h1 class="text-2xl font-semibold mb-4">Edit <?= htmlspecialchars(ucfirst(strtolower($type))) ?> Info</h1>
    <?php if (!empty($_GET['success'])): ?>
      <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">Updated successfully.</div>
    <?php elseif ($error): ?>
      <div class="mb-4 p-3 bg-red-100 text-red-800 rounded"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-4">
        <label class="block text-gray-700 mb-1">First Name</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required
               class="w-full border border-gray-300 rounded-lg px-3 py-2">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-1">Last Name</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required
               class="w-full border border-gray-300 rounded-lg px-3 py-2">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-1">Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required
               class="w-full border border-gray-300 rounded-lg px-3 py-2">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-1">School Name</label>
        <input type="text" name="school_name" value="<?= htmlspecialchars($user['school_name']) ?>" required
               class="w-full border border-gray-300 rounded-lg px-3 py-2">
      </div>
      <?php if ($type === 'STUDENT'): ?>
      <div class="mb-4">
        <label class="block text-gray-700 mb-1">Class Name</label>
        <input type="text" name="class_name" value="<?= htmlspecialchars($user['class_name']) ?>"
               class="w-full border border-gray-300 rounded-lg px-3 py-2">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-1">Student Number</label>
        <input type="text" name="student_number" value="<?= htmlspecialchars($user['student_number']) ?>"
               class="w-full border border-gray-300 rounded-lg px-3 py-2">
      </div>
      <?php endif; ?>
      <?php if ($type === 'TEACHER'): ?>
      <div class="mb-4">
        <label class="block text-gray-700 mb-1">Subjects Taught</label>
        <div id="subjects-container" class="space-y-2">
          <?php foreach ($currentSubjects as $subj): ?>
          <div class="flex items-center space-x-2">
            <input type="text" name="subjects[]" value="<?= htmlspecialchars($subj) ?>"
                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2">
            <button type="button" onclick="removeSubject(this)"
                    class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 cursor-pointer">Remove</button>
          </div>
          <?php endforeach; ?>
        </div>
        <button type="button" onclick="addSubject()"
                class="mt-2 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 cursor-pointer">Add Subject</button>
      </div>
      <?php endif; ?>
      <div class="flex justify-end space-x-2">
        <a href="index.php" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancel</a>
        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 cursor-pointer">Save</button>
      </div>
    </form>
  </div>
<script>
function addSubject() {
  const container = document.getElementById('subjects-container');
  const div = document.createElement('div');
  div.className = 'flex items-center space-x-2';
  div.innerHTML = `
    <input type="text" name="subjects[]" placeholder="New subject"
           class="flex-1 border border-gray-300 rounded-lg px-3 py-2">
    <button type="button" onclick="removeSubject(this)"
            class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 cursor-pointer">Remove</button>
  `;
  container.appendChild(div);
}
function removeSubject(btn) {
  btn.parentElement.remove();
}
</script>
</body>
</html>
