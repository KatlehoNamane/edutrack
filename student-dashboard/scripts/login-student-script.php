<?php
session_start();
require_once dirname(__DIR__, 2) . '/db/db_config.php';

$error = "";
$success = "";

$studentNumber = mysqli_real_escape_string($conn, trim($_POST['student-number']));
$pass  = $_POST['password'];

$sql = "SELECT id, password, role, school_name, student_number FROM users WHERE student_number = '$studentNumber' LIMIT 1";
$res = $conn->query($sql);

if ($res && $res->num_rows === 1) {
    $user = $res->fetch_assoc();
    if (password_verify($pass, $user['password'])) {
        if ($user['role'] === 'STUDENT') {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['school_name'] = $user['school_name'];
            $_SESSION['student_number'] = $user['student_number'];

            // Fetch school subjects
            $schoolName = $user['school_name'];
            $subjectSql = "SELECT subject FROM school_subjects WHERE school_name = '$schoolName'";
            $subjectRes = $conn->query($subjectSql);
            $subjects = [];

            if ($subjectRes && $subjectRes->num_rows > 0) {
                while ($row = $subjectRes->fetch_assoc()) {
                    $subjects[] = $row['subject'];
                }
            }

            $_SESSION['school_subjects'] = $subjects;
            header("Location: ../dashboard.php");
            exit;
        } else {
            $error = "Access denied: not a student.";
            header("Location: ../login.php");
        }
    } else {
        $error = "Invalid password.";
    }
} else {
    $error = "User not found.";
}

if (isset($conn)) {
    $conn->close();
}