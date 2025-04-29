<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="styles.css"/>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link href="https://fonts.googleapis.com/css?family=DM Sans" rel="stylesheet">
  <style>
    #menuButton {
  font-size: 16px;
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
  font-size: 16px;
  color: white;
  transition: color 0.3s ease;
}

.sidebar a:hover {
  color: #000;
}

.closebtn {
  position: absolute;
  top: 10px;
  right:10px;
  font-size: 50px;
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
  <div class="wrapper">
    <div class="navbar w-full justify-center md:w-auto md:justify-start">
      <a href="index.php"><button class="nav-btn md:ml-2">Home</button></a>
      <a href="schools.php"><button class="nav-btn">Schools</button></a>
      <a href="contact.php"><button class="nav-btn">Contact Us</button></a>
      <a href="#"><button class="nav-btn">Login</button></a>
    </div>

    <button id="menuButton">☰ Dashboards</button>

<div id="sidebar" class="sidebar">
  <a href="#" class="closebtn" id="closeButton">&times;</a>
  <a href="./principal-dashboard/login.php">Principal Dashboard</a>
  <a href="./teacher-dashboard/login.php">Teacher Dashboard</a>
  <a href="./student-dashboard/login.php">Student Dashboard</a>
  <a href="#">Contact</a>
</div>

    <!-- <div class="menu hidden md:block">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-align-justify-icon lucide-align-justify"><path d="M3 12h18"/><path d="M3 18h18"/><path d="M3 6h18"/></svg>
       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical-icon lucide-ellipsis-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg> 
    </div> -->
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

<!-- you can use the commented out svg if you want, it's the 3 dotted one -->
<!-- im sorry, i feel like im too involved in the project and sometimes i feel like i force my preferences onto you, im sorry -->
<!-- I love you -->
 <!-- I like the animation on the navbar too -->
