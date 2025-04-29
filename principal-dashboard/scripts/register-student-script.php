<?php
require_once dirname(__DIR__, 2) . '/db/db_config.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- Registration ---
    if (isset($_POST['full-name'])) {
        $fullName = trim($_POST['full-name']);
        $schoolName = mysqli_real_escape_string($conn, trim($_POST['school-name']));
        $studentNumber = mysqli_real_escape_string($conn, trim($_POST['student-number']));
        $className = mysqli_real_escape_string($conn, trim($_POST['class-name']));
        $email    = "NO EMAIL-" . $studentNumber;
        $pass     = $_POST['password'];

        $parts     = explode(' ', $fullName, 2);
        $firstName = mysqli_real_escape_string($conn, $parts[0]);
        $lastName  = isset($parts[1]) ? mysqli_real_escape_string($conn, $parts[1]) : '';


        $hashedPassword = mysqli_real_escape_string($conn, password_hash($pass, PASSWORD_BCRYPT));
        $newId    = uniqid('', true);
        $role     = 'STUDENT';


        $sql = "
            INSERT INTO users (id, first_name, last_name, email, password, role, school_name, student_number, class_name)
            VALUES ('$newId', '$firstName', '$lastName', '$email', '$hashedPassword', '$role', '$schoolName', '$studentNumber', '$className')
        ";

        if ($conn->query($sql)) {
            $success = "Registration successful!";
            header("Location: ../index.php");
            exit;
        } else {
            $error = "Registration failed: " . $conn->error;
            header("Location: ../register-student.php");
        }
    }
}
if (isset($conn)) {
    $conn->close();
}
?>