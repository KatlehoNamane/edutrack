


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Animated Right Sidebar</title>
  <style>
  body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #fff;
  overflow-x: hidden;
}

#menuButton {
  font-size: 24px;
  padding: 10px 20px;
  cursor: pointer;
  background-color: rgba(250, 118, 23, 0.9);
  color: white;
  border: none;
  margin: 10px;
  border-radius: 5px;
  position: fixed;
  top: 10px;
  right: 10px;
  z-index: 1100;
  transition: background-color 0.3s ease;
}

#menuButton:hover {
  background-color: rgba(250, 118, 23, 1);
}

.sidebar {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1000;
  top: 0;
  right: 0;
  background-color: rgba(250, 118, 23, 0.9);
  overflow-x: hidden;
  transition: width 0.4s ease;
  padding-top: 60px;
}

.sidebar.open {
  width: 250px;
  animation: bounceIn 0.5s ease; /* Add the animation here */
}

.sidebar a {
  padding: 10px 32px;
  display: block;
  text-decoration: none;
  font-size: 20px;
  color: white;
  transition: color 0.3s ease;
}

.sidebar a:hover {
  color: #000;
}

.closebtn {
  position: absolute;
  top: 10px;
  left: 20px;
  font-size: 36px;
  color: white;
  text-decoration: none;
}

/* BOUNCE ANIMATION */
@keyframes bounceIn {
  0% {
    transform: translateX(100%);
  }
  60% {
    transform: translateX(-30px);
  }
  80% {
    transform: translateX(10px);
  }
  100% {
    transform: translateX(0);
  }
}
  </style>
</head>
<body>

  <button id="menuButton">☰ Dashboards</button>

  <div id="sidebar" class="sidebar">
    <a href="#" class="closebtn" id="closeButton">&times;</a>
    <a href="./principal-dashboard/login.php">Principal Dashboard</a>
    <a href="./teacher-dashboard/login.php">Teacher Dashboard</a>
    <a href="./student-dashboard/login.php">Student Dashboard</a>
    <a href="#">Contact</a>
  </div>

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
