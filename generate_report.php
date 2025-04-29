<?php
include './db/db_config.php';

$result = $conn->query("SELECT * FROM students ORDER BY average DESC");

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

// Assign position
foreach ($students as $index => &$student) {
    $student['position'] = $index + 1;
}

echo json_encode($students);
?>
