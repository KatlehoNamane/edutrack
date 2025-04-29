<?php
header('Content-Type: application/json');

// Generate a 9-digit unique student number (pseudo-random)
$randomNumber = random_int(100000000, 999999999);

// Return it as JSON
echo json_encode(['id' => $randomNumber]);
