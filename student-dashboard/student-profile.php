
<?php
session_start();
require_once dirname(__DIR__, 1) . '/db/db_config.php';
include "./scripts/get-profile-script.php";


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Profile Sidebar</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="relative bg-gray-100 min-h-screen">

  <?php
        $row = $result->fetch_assoc();
        // echo print_r($result);
        
        $fullName = $row["first_name"] . " " . $row["last_name"];
        $schoolName = $row["school_name"];
        $studentNumber =$row["student_number"];
        $className = $row["class_name"];
        $email    = $row["email"];
        $pass     = $row["password"];
        $role     = $row["role"];
        $className = $row["class_name"];

        $firstName = $row["first_name"];
        $lastName  = $row["last_name"];
        echo $firstName;


  ?>
  <!-- JavaScript
  <script>
    function openSidebar() {
      document.getElementById('sidebar').classList.remove('translate-x-full');
      document.getElementById('overlay').classList.remove('hidden');
    }

    function closeSidebar() {
      document.getElementById('sidebar').classList.add('translate-x-full');
    //   document.getElementById('overlay').classList.add('hidden');
    } -->
  </script>
</body>
</html>

<div id="sidebar" class="sidebar">
<?php
        $row = $result->fetch_assoc();
        // echo print_r($result);
        
        $fullName = $row["first_name"] . " " . $row["last_name"];
        $schoolName = $row["school_name"];
        $studentNumber =$row["student_number"];
        $className = $row["class_name"];
        $email    = $row["email"];
        $pass     = $row["password"];
        $role     = $row["role"];
        $className = $row["class_name"];

        $firstName = $row["first_name"];
        $lastName  = $row["last_name"];
        echo $firstName;


  ?>


  <!-- Overlay -->
  <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" onclick="closeSidebar()"></div>

  <!-- Sidebar -->
  <div id="sidebar" class="fixed top-0 right-0 w-80 h-full bg-white shadow-lg z-50 transform translate-x-full transition-transform duration-300">
    <div class="flex items-center justify-between p-4 border-b">
      <h2 class="text-xl font-semibold">Student Profile</h2>
      <button onclick="closeSidebar()" class="text-gray-500 hover:text-gray-700">&times;</button>
    </div>
    <div class="p-4 space-y-4">
      <div>
        <h3 class="text-sm text-gray-600">Name</h3>
        <p class="font-medium"><?= $fullName ?></p>
      </div>
      <div>
        <h3 class="text-sm text-gray-600">Role</h3>
        <p class="font-medium"><?= $role ?></p>
      </div>
      
      <div>
        <h3 class="text-sm text-gray-600">Class</h3>
        <p class="font-medium"><?= $className ?></p>
      </div>
      <div>
        <h3 class="text-sm text-gray-600">School</h3>
        <p class="font-medium"><?= $schoolName ?></p>
      </div>
      <div>
        <h3 class="text-sm text-gray-600">Student Number</h3>
        <p class="font-medium"><?= $studentNumber ?></p>
      </div>
      <div>
        <h3 class="text-sm text-gray-600">Email</h3>
        <p class="font-medium"><?= $email ?></p>
      </div>
    </div>
  </div>
</div>

</div>
  <script src="script.js"></script>
  <script>
   const menuButton = document.getElementById('menuButton');
const sidebar = document.getElementById('sidebar');
const closeButton = document.getElementById('closeButton');

menuButton.addEventListener('click', () => {
  sidebar.classList.add('open');
  menuButton.style.display = 'none'; // Hide menu button
});

closeButton.addEventListener('click', () => {
  sidebar.classList.remove('open');
  menuButton.style.display = 'block'; // Show menu button
});
  </script>

</body>
</html>
