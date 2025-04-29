
<?php
// Connect to the database
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "edutrack_lesotho";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    // echo("connection failed");
    die("Connection failed: " . $conn->connect_error);
}

// 1. users table (stores principals, teachers, students)
$sql = "
CREATE TABLE IF NOT EXISTS users (
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
) ENGINE=InnoDB;
";
$conn->query($sql);

// Remove UNIQUE index on school_n/................................................./.....................................................................................................................ame if it exists
// $checkIndex = $conn->query("SHOW INDEXES FROM users WHERE Column_name = 'school_name' AND Non_unique = 0");
// if ($checkIndex && $checkIndex->num_rows > 0) {
//     $index = $checkIndex->fetch_assoc();
//     $indexName = $index['Key_name'];
//     $conn->query("ALTER TABLE users DROP INDEX `$indexName`");
// }

// 3. Add new column to users table
// $sql = "ALTER TABLE users ADD COLUMN student_number VARCHAR(50) DEFAULT NULL;";
// $conn->query($sql);


// 2. marks table (stores each student’s mark and the subject name)

// echo "schema tables have been created successfully.";

// $conn->close();


/* $sql="

CREATE TABLE IF NOT EXISTS students (
  id VARCHAR(50) PRIMARY KEY,
  student_id VARCHAR(50) NOT NULL,
  name VARCHAR(255) NOT NULL,
  gender VARCHAR(10),
  className VARCHAR(100),
  totalMarks FLOAT,
  average FLOAT,
  remark VARCHAR(255),
  subjects TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   FOREIGN KEY (student_id) REFERENCES users(id)
      ON DELETE CASCADE
)"; 

$conn->query($sql);*/
?>
