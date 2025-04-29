<?php
// Check if user is logged in and ID is set
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];

// Prepare SQL query to fetch user data
$sql = "SELECT * FROM users WHERE id ='$user_id'";

// Execute the query
$result = $conn->query($sql);

// Check if the query returned a result
// if ($result->num_rows > 0) {
//     // Fetch user data
//     $user_data = $result->fetch_assoc();
//     echo json_encode($user_data);
// } else {
//     echo "No user found.";
// }

// Close the database connection
$conn->close();
?>