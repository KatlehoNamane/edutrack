<!-- <?php
$host = "localhost"; // your server
$user = "root"; // your db username
$pass = ""; // your db password
$dbname = "school_reports"; // your db name

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql="
CREATE DATABASE IF NOT EXISTS school_reports;

USE school_reports;

CREATE TABLE IF NOT EXISTS students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  gender VARCHAR(10),
  className VARCHAR(100),
  totalMarks FLOAT,
  average FLOAT,
  remark VARCHAR(255),
  subjects TEXT
)";

$conn->query($sql);
?> -->
