<?php
// TODO: ALWAYS CHECK ON REGISTRATION WHETHER PRINCIPAL OF CERTAIN SCHOOL EXISTS
session_start();
require_once dirname(__DIR__, 2) . '/db/db_config.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- Registration ---
    if (isset($_POST['full-name'])) {
        $fullName   = trim($_POST['full-name']);
        $schoolName = mysqli_real_escape_string($conn, trim($_POST['school-name']));
        $email      = mysqli_real_escape_string($conn, trim($_POST['email']));
        $pass       = $_POST['password'];
        $subjects   = $_POST['subjects'];
        $subjectList = array_map('trim', explode(',', $subjects)); // Convert to array

        $parts      = explode(' ', $fullName, 2);
        $firstName  = mysqli_real_escape_string($conn, $parts[0]);
        $lastName   = isset($parts[1]) ? mysqli_real_escape_string($conn, $parts[1]) : '';

        $hashedPassword = mysqli_real_escape_string($conn, password_hash($pass, PASSWORD_BCRYPT));
        $newId          = uniqid('', true);
        $role           = 'PRINCIPAL';

        // Check if a principal already exists for the provided school
        $checkSql = "
            SELECT id FROM users
            WHERE role = 'PRINCIPAL' AND school_name = '$schoolName'
            LIMIT 1
        ";
        $checkResult = $conn->query($checkSql);

        if ($checkResult && $checkResult->num_rows > 0) {
            $error = "A principal is already registered for '$schoolName'.";
        } else {
            $sql = "
                INSERT INTO users (id, first_name, last_name, email, password, role, school_name)
                VALUES ('$newId', '$firstName', '$lastName', '$email', '$hashedPassword', '$role', '$schoolName')
            ";

            if ($conn->query($sql)) {
                $success = "Registration successful!";
                $_SESSION['user_id'] = $newId;
                $_SESSION['role'] = $role;
                $_SESSION['school_name'] = $schoolName;
                // Now insert each subject into teacher_subjects table
            $insertError = false;
            foreach ($subjectList as $subject) {
                $subjectEscaped = mysqli_real_escape_string($conn, $subject);
                $subjectId = uniqid("", true);
                $subSql = "
                    INSERT INTO school_subjects (id, principal_id, school_name, subject)
                    VALUES ('$subjectId', '$newId', '$schoolName' ,'$subjectEscaped')
                ";
                if (!$conn->query($subSql)) {
                    $insertError = true;
                    $error = "Subject insertion failed: " . $conn->error;
                    break;
                }
            }

            if (!$insertError) {
                $_SESSION['success'] = "Registration successful!";
            } else {
                $_SESSION['error'] = $error;
            }
                $_SESSION['school_subjects'] = $subjects;
                header("Location: ./index.php");
                exit;
            } else {
                $error = "Registration failed: " . $conn->error;
            }
        }
    }

    // --- Login ---
     else {
        $email = mysqli_real_escape_string($conn, trim($_POST['email']));
        $pass  = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $res = $conn->query($sql);

        if ($res && $res->num_rows === 1) {
            $user = $res->fetch_assoc();
            if (password_verify($pass, $user['password'])) {
                if ($user['role'] === 'PRINCIPAL') {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['school_name'] = $user['school_name'];


                    // Fetch school subjects
                    $principalId = $user['id'];
                    $subjectSql = "SELECT subject FROM school_subjects WHERE principal_id = '$principalId'";
                    $subjectRes = $conn->query($subjectSql);
                    $subjects = [];

                    if ($subjectRes && $subjectRes->num_rows > 0) {
                        while ($row = $subjectRes->fetch_assoc()) {
                            $subjects[] = $row['subject'];
                        }
                    }

                    $_SESSION['school_subjects'] = $subjects;
                    header("Location: ./index.php");
                    exit;
                } else {
                    $error = "Access denied: not a principal.";
                }
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "User not found.";
        }
        // echo $error;
    }
}
if (isset($conn)) {
    $conn->close();
}
?>
