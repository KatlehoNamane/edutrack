<?php
session_start();
require_once dirname(__DIR__, 1) . '/db/db_config.php';

// Connect
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Only principals allowed
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'PRINCIPAL') {
    header('Location: login.php');
    exit;
}

$principalId = $conn->real_escape_string($_SESSION['user_id']);
$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect non-empty subjects[]
    $subjects = [];
    if (!empty($_POST['subjects']) && is_array($_POST['subjects'])) {
        foreach ($_POST['subjects'] as $subj) {
            $s = trim($subj);
            if ($s !== '') {
                $subjects[] = $conn->real_escape_string($s);
            }
        }
    }

    // Delete existing for this principal
    if (! $conn->query("DELETE FROM school_subjects WHERE principal_id = '$principalId'")) {
        $error = "Failed to clear old subjects: ".$conn->error;
    } else {
        // Insert new list
        foreach ($subjects as $s) {
            $id = uniqid('', true);
            $sql = "
                INSERT INTO school_subjects
                  (id, principal_id, school_name, subject)
                VALUES
                  ('$id', '$principalId', '".$_SESSION['school_name']."', '$s')
            ";
            if (! $conn->query($sql)) {
                $error = "Failed to insert '$s': ".$conn->error;
                break;
            }
        }
        if (!$error) {
            $success = "Subjects updated successfully.";
            header("Location: ./index.php");
            // update session cache
            $_SESSION['school_subjects'] = $subjects;
        }
        header("Location: ./index.php");
    }
}

// Fetch current subjects
$current = [];
$res = $conn->query("
    SELECT subject 
      FROM school_subjects 
     WHERE principal_id = '$principalId'
     ORDER BY created_at
");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $current[] = $row['subject'];
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Edit School Subjects</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-lg mx-auto bg-white p-6 rounded-2xl shadow-md">
    <h1 class="text-2xl font-semibold mb-4">Edit Your School’s Subjects</h1>

    <?php if ($success): ?>
      <div class="mb-4 p-3 bg-green-100 text-green-800 rounded"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
      <div class="mb-4 p-3 bg-red-100 text-red-800 rounded"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
      <div id="subjects-container" class="space-y-2 mb-4">
        <?php foreach ($current as $subj): ?>
          <div class="flex items-center space-x-2">
            <input type="text" name="subjects[]" value="<?= htmlspecialchars($subj) ?>"
                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2"
                   placeholder="Subject name">
            <button type="button" onclick="removeSubject(this)"
                    class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">Remove</button>
          </div>
        <?php endforeach; ?>
      </div>
      <button type="button" onclick="addSubject()"
              class="mb-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 cursor-pointer">
        Add New Subject
      </button>

      <div class="flex justify-end space-x-2">
        <a href="index.php" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 cursor-pointer">Cancel</a>
        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 cursor-pointer">
          Save Subjects
        </button>
      </div>
    </form>
  </div>

  <script>
    function addSubject() {
      const cont = document.getElementById('subjects-container');
      const div = document.createElement('div');
      div.className = 'flex items-center space-x-2';
      div.innerHTML = `
        <input type="text" name="subjects[]" placeholder="Subject name"
               class="flex-1 border border-gray-300 rounded-lg px-3 py-2">
        <button type="button" onclick="removeSubject(this)"
                class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 cursor-pointer">
          Remove
        </button>`;
      cont.appendChild(div);
    }
    function removeSubject(btn) {
      btn.parentElement.remove();
    }
  </script>
</body>
</html>
