<?php
include "navbar.php"
?>


<!DOCTYPE html>
<html>
  <head>
    <title>Schools Partnered with us</title>
    <link href="https://fonts.googleapis.com/css?family=DM Sans" rel="stylesheet">
    <link rel="stylesheet" href="./styles/schools.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="footer.css">
  </head>
  <body>
  <p class="heading">Schools Partnered With Us</p>
 
  <div class="first-div flex items-center flex-col gap-10 lg:flex-row lg:gap-1 mb-8">
    <div class="mt-10 ml-10 hero-section-para">
      <p>
        We have over <span class="colored-intro">60</span> schools that have trusted our innovative platform, and our<br>

        intention to take some load off of their hands.<br>

        Together, we have been able to create over

        <span class="colored-intro">10,000</span>

        school reports for students,<br>

        in a significantly less amount of time, with the best accuracy!
      </p>
    </div>

     <div class="picture flex justify-center w-[90%] md:w-[50%] lg:justify-center">
          <img  src="https://th.bing.com/th/id/OIP.GGClFyPjUMMwnuxrOPJi2AAAAA?rs=1&pid=ImgDetMain" alt="hero section image" width="250" height="100" class="shadow-2xl rounded-md"/>
      </div> 
   </div>

   <div class="register-btn">
    <a href="./principal-dashboard/login.php"><button>Join Us Now</button></a>
   </div>

  
  </body>
</html>
<?php
include "footer.php";
?>
