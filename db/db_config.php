<?php
// Connect to the database
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "edutrack_lesotho";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Individual SQL statements
$statements = [
    "CREATE TABLE IF NOT EXISTS users (
        id VARCHAR(50) PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('PRINCIPAL','TEACHER','STUDENT') NOT NULL,
        class_name VARCHAR(50) DEFAULT NULL,
        student_number VARCHAR(50) DEFAULT NULL,
        school_name VARCHAR(50) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB",

    "CREATE TABLE IF NOT EXISTS teacher_subjects (
        teacher_id VARCHAR(50),
        subject VARCHAR(100),
        PRIMARY KEY (teacher_id, subject),
        FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB",

    "CREATE TABLE IF NOT EXISTS subject_marks (
        id            VARCHAR(50) PRIMARY KEY,
        student_id    VARCHAR(50) NOT NULL,
        subject_name  VARCHAR(50) NOT NULL,
        teacher_id    VARCHAR(50) NOT NULL,
        term          varchar(50) NOT NULL,
        year          YEAR NOT NULL,
        mark          TINYINT NOT NULL CHECK (mark BETWEEN 0 AND 100),
        created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB",

    "CREATE TABLE IF NOT EXISTS school_subjects (
        id VARCHAR(50) PRIMARY KEY,
        principal_id VARCHAR(50) NOT NULL,
        school_name VARCHAR(50) NOT NULL,
        subject VARCHAR(100) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (principal_id) REFERENCES users(id) ON DELETE CASCADE,
        UNIQUE KEY uq_principal_subject (principal_id, subject)
    ) ENGINE=InnoDB"
];

// Execute each statement
foreach ($statements as $sql) {
    if (!$conn->query($sql)) {
        echo "Error creating table: " . $conn->error . "<br>";
    }
}

// $conn->close();
?>
