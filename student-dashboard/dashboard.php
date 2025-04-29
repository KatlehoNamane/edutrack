<?php

    include "./scripts/dashboard-script.php";
    $row = $result->fetch_assoc();
    $name = $row["first_name"] . " " . $row["last_name"];
    $student_number=$row["student_number"];

?> 
<!DOCTYPE html>
<html>
    <head>
        <title>Student Dashboard</title>
        <link rel="stylesheet" href="./styles/dashboard.css">
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <link href="https://fonts.googleapis.com/css?family=DM Sans" rel="stylesheet">
    </head>
    <body>
    <div class="top">
        <div class="navbar">
        <a href="index.php"><button class="nav-btn md:ml-2">Home</button></a>
        <a href="contact.php"><button class="nav-btn">Contact Us</button></a>
        </div>

        <button id="menuButton">☰ Past Reports</button>

         <div id="sidebar" class="sidebar">
          <a href="#" class="closebtn" id="closeButton">&times;</a>
         </div>
    </div>    

        <p class="heading">Dashboard</p>

       <?php
       echo '<p class="head">Hello' . ($name !== null ? '  ' . $name : '') . '</p>' ;
       echo '<p class="report">Report'.'</p>';
         
       echo json_encode($students);
        ?>
    </body>m#
</html>










