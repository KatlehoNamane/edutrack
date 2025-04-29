<?php
require_once dirname(__DIR__, 2) . '/db/db_config.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- Registration ---
    if (isset($_POST['full-name'])) {
        $fullName = trim($_POST['full-name']);
        $schoolName = mysqli_real_escape_string($conn, trim($_POST['school-name']));
        $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
        $pass     = $_POST['password'];

        $parts     = explode(' ', $fullName, 2);
        $firstName = mysqli_real_escape_string($conn, $parts[0]);
        $lastName  = isset($parts[1]) ? mysqli_real_escape_string($conn, $parts[1]) : '';


        $hashedPassword = mysqli_real_escape_string($conn, password_hash($pass, PASSWORD_BCRYPT));
        $newId    = uniqid('', true);
        $role     = 'TEACHER';


        $sql = "
            INSERT INTO users (id, first_name, last_name, email, password, role, school_name)
            VALUES ('$newId', '$firstName', '$lastName', '$email', '$hashedPassword', '$role', '$schoolName')
        ";

        if ($conn->query($sql)) {
            $success = "Registration successful!";
            header("Location: ../index.php");
            exit;
        } else {
            $error = "Registration failed: " . $conn->error;
            header("Location: ../register-teacher.php");
        }
    }
}
if (isset($conn)) {
    $conn->close();
}
?>