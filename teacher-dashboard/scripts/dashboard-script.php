<?php
session_start();
require_once dirname(__DIR__, 2) . '/db/db_config.php';

// ── SUGGESTION ──
// On user login, store their school name in the session:
//   $_SESSION['school_name'] = $rowFromDb['school_name'];

// 1. Access control: only principals
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'TEACHER') {
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
        last_name      LIKE '%$term%'
        OR
        student_number LIKE '%$term%'
      )
    ";
    $search = $term;
}

$where  = 'WHERE ' . implode(' AND ', $conditions);
$sql    = "
  SELECT
    id,
    first_name,
    last_name,
    email,
    role,
    class_name,
    school_name,
    student_number 
    FROM users
  $where
  ORDER BY role, first_name
";

// $sql    = "
//   SELECT
//     id,
//     first_name,
//     last_name,
//     email,
//     role,
//     class_name,
//     school_name
//   FROM users
//   ORDER BY role, first_name
// ";

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
