<?php
require_once dirname(__DIR__, 2) . '/db/db_config.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['full-name'])) {
        $fullName   = trim($_POST['full-name']);
        $schoolName = mysqli_real_escape_string($conn, trim($_POST['school-name']));
        $email      = mysqli_real_escape_string($conn, trim($_POST['email']));
        $pass       = $_POST['password'];
        $subjects   = $_POST['subjects'];
        $subjectList = array_map('trim', explode(',', $subjects)); // Convert to array

        $parts     = explode(' ', $fullName, 2);
        $firstName = mysqli_real_escape_string($conn, $parts[0]);
        $lastName  = isset($parts[1]) ? mysqli_real_escape_string($conn, $parts[1]) : '';

        $hashedPassword = mysqli_real_escape_string($conn, password_hash($pass, PASSWORD_BCRYPT));
        $newId    = uniqid('', true);
        $role     = 'TEACHER';

        // Insert teacher into users table
        $sql = "
            INSERT INTO users (id, first_name, last_name, email, password, role, school_name)
            VALUES ('$newId', '$firstName', '$lastName', '$email', '$hashedPassword', '$role', '$schoolName')
        ";

        if ($conn->query($sql)) {
            // Now insert each subject into teacher_subjects table
            $insertError = false;
            foreach ($subjectList as $subject) {
                $subjectEscaped = mysqli_real_escape_string($conn, $subject);
                $subSql = "
                    INSERT INTO teacher_subjects (teacher_id, subject)
                    VALUES ('$newId', '$subjectEscaped')
                ";
                if (!$conn->query($subSql)) {
                    $insertError = true;
                    $error = "Subject insertion failed: " . $conn->error;
                    break;
                }
            }

            if (!$insertError) {
                $_SESSION['success'] = "Registration successful!";
                header("Location: ../register-teacher.php");
                exit;
            } else {
                // If subject insertion fails, you might consider rolling back the user insert if needed
                $_SESSION['error'] = $error;
                header("Location: ../register-teacher.php");
                exit;
            }
        } else {
            $_SESSION['error'] = "Registration failed: " . $conn->error;
            header("Location: ../register-teacher.php");
            exit;
        }
    }
}

if (isset($conn)) {
    $conn->close();
}
?>
