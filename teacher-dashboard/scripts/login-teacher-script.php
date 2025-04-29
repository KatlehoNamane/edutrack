<?php
session_start();
require_once dirname(__DIR__, 2) . '/db/db_config.php';

$error = "";
$success = "";

$email = mysqli_real_escape_string($conn, trim($_POST['email']));
$pass  = $_POST['password'];

$sql = "SELECT id, password, role, school_name FROM users WHERE email = '$email' LIMIT 1";
$res = $conn->query($sql);

if ($res && $res->num_rows === 1) {
    $user = $res->fetch_assoc();
    if (password_verify($pass, $user['password'])) {
        if ($user['role'] === 'TEACHER') {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['school_name'] = $user['school_name'];
            header("Location: ../dashboard.php");
            exit;
        } else {
            $error = "Access denied: not a teacher.";
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