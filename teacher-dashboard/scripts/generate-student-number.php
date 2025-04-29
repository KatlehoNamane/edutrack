<?php
header('Content-Type: application/json');

// uniqid() by default prefixes with current time in microseconds.
// if you need strictly 9 chars, you can substr() it:
$id = substr(uniqid('', tr), 0, 9);

echo json_encode(['id' => $id]);
