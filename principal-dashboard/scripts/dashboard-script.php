<?php
session_start();
require_once dirname(__DIR__, 2) . '/db/db_config.php';

// ── SUGGESTION ──
// On user login, store their school name in the session:
//   $_SESSION['school_name'] = $rowFromDb['school_name'];

// 1. Access control: only principals
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'PRINCIPAL') {
    header('Location: login.php');
    exit;
}

$error   = '';
$success = '';

// 3. Deletion (cannot delete self)
if (isset($_GET['delete_id'])) {
    $delId = mysqli_real_escape_string($conn, $_GET['delete_id']);
    if ($delId !== $_SESSION['user_id']) {
        if ($conn->query("DELETE FROM users WHERE id = '$delId'")) {
            $success = "User deleted.";
        } else {
            $error = "Delete failed: " . $conn->error;
        }
    } else {
        $error = "You cannot delete your own account.";
    }
}

// 4. Fetch + filter users (same school, exclude self, optional search)
$search     = '';
$conditions = [
    "school_name = '" . mysqli_real_escape_string($conn, $_SESSION['school_name']) . "'",
    "id != '"          . mysqli_real_escape_string($conn, $_SESSION['user_id'])   . "'"
];

if (!empty($_GET['search'])) {
    $term = mysqli_real_escape_string($conn, trim($_GET['search']));
    $conditions[] = "
      (
        email      LIKE '%$term%'
        OR
        student_number LIKE '%$term%'
      )
    ";
    $search = $term;
}

$principalId = $_SESSION['user_id'];

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
    if (count($current) === 0) {
      // no subjects defined yet — send the principal to the edit page
      header('Location: edit-subjects.php');
      exit;
  }
}

$where  = 'WHERE ' . implode(' AND ', $conditions);
$sql = "
  SELECT
    u.id,
    u.first_name,
    u.last_name,
    u.email,
    u.role,
    u.class_name,
    u.school_name,
    u.student_number,
    GROUP_CONCAT(ts.subject ORDER BY ts.subject SEPARATOR ', ') AS subjects
  FROM users u
  LEFT JOIN teacher_subjects ts ON u.id = ts.teacher_id
  $where
  GROUP BY u.id
  ORDER BY u.role, u.first_name
";

$result = $conn->query($sql);



if (isset($conn)) {
  $conn->close();
}

/**
 * Capitalize first letter (rest lowercase).
 */
function capitalizeFirst($word) {
    return ucfirst(strtolower($word));
}
