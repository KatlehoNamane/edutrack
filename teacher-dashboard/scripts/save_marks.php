<?php
// Database connection settings
$servername = "localhost"; // Change if different
$username = "root";         // Your DB username
$password = "";             // Your DB password
$database = "edutrack_lesotho";       // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the data from the form
$student_id = $_POST['student_id'];
$subject = $_POST['subject_name'];
$mark = $_POST['mark'];

// Insert into database
$sql = "INSERT INTO marks (student_id, subject_name, mark)
        VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $student_name, $subject, $marks);

if ($stmt->execute()) {
    echo "Marks saved successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>


