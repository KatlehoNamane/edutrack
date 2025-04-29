<?php
include './db/db_config.php';

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'];
$gender = $data['gender'];
$className = $data['className'];
$totalMarks = $data['totalMarks'];
$average = $data['average'];
$remark = $data['remark'];
$subjects = json_encode($data['subjects']); // store subjects as JSON

// Save to database
$stmt = $conn->prepare("INSERT INTO students (name, gender, className, totalMarks, average, remark, subjects) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssddss", $name, $gender, $className, $totalMarks, $average, $remark, $subjects);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "error" => $stmt->error]);
}
?>
