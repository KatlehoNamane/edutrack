<?php
  include "./scripts/dashboard-script.php";
  $row = $result->fetch_assoc();
  $name = $row["first_name"] . " " . $row["last_name"];
  $student_number = $row["student_number"];
  $class = $row["class"] ?? "Grade 10 - A";
  $email = $row["email"] ?? "student@example.com";
  $age = $row["age"] ?? "16";
?> 
<!DOCTYPE html>
<html>
  <head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="./styles/dashboard.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css?family=DM Sans" rel="stylesheet">
  </head>
  <body class="relative bg-gray-100">

    <!-- Top Bar -->
    <div class="top">
      <div class="navbar">
        <!-- Updated: trigger sidebar instead of link -->
        <button class="nav-btn" onclick="openProfileSidebar()">My Profile</button>
        <a href="../index.php"><button class="nav-btn md:ml-2">Home</button></a>
        <a href="../contact.php"><button class="nav-btn">Contact Us</button></a>
      </div>


      <div id="sidebar" class="sidebar">
        <a href="#" class="closebtn" id="closeButton">&times;</a>
      </div>
    </div>    

    <!-- Greeting -->
    <p class="heading">Hello,<br></p> 
    <?php
      echo '<p class="head">' . ($name !== null ? '  ' . $name : '') . '</p>' ;
    ?>

    <div class="flex w-full justify-center items-center mt-4">
      <?php
    include "./components/report.php";
    ?>
    </div>

    <!-- Profile Sidebar (left) -->
    <div id="profileOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" onclick="closeProfileSidebar()"></div>

    <div id="profileSidebar" class="fixed top-0 left-0 w-80 h-full bg-white shadow-lg z-50 transform -translate-x-full transition-transform duration-300">
      <div class="flex items-center justify-between p-4 border-b bg-gray-100">
        <h2 class="text-lg font-semibold text-gray-800">My Profile</h2>
        <button onclick="closeProfileSidebar()" class="text-gray-600 text-2xl leading-none">&times;</button>
      </div>
      <div class="p-4 space-y-4 text-gray-700">
        <div>
          <h3 class="text-sm text-gray-500">Name</h3>
          <p class="font-medium"><?= htmlspecialchars($name) ?></p>
        </div>
        <div>
          <h3 class="text-sm text-gray-500">Student Number</h3>
          <p class="font-medium"><?= htmlspecialchars($student_number) ?></p>
        </div>
        <div>
          <h3 class="text-sm text-gray-500">Class</h3>
          <p class="font-medium"><?= htmlspecialchars($class) ?></p>
        </div>
        <div>
          <h3 class="text-sm text-gray-500">Age</h3>
          <p class="font-medium"><?= htmlspecialchars($age) ?></p>
        </div>
        <div>
          <h3 class="text-sm text-gray-500">Email</h3>
          <p class="font-medium"><?= htmlspecialchars($email) ?></p>
        </div>
      </div>
    </div>

    <!-- JS: Sidebar Toggle -->
    <script>
      function openProfileSidebar() {
        document.getElementById('profileSidebar').classList.remove('-translate-x-full');
        document.getElementById('profileOverlay').classList.remove('hidden');
      }

      function closeProfileSidebar() {
        document.getElementById('profileSidebar').classList.add('-translate-x-full');
        document.getElementById('profileOverlay').classList.add('hidden');
      }
    </script>
  </body>
</html>
