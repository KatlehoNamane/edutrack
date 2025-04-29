<?php
include "navbar.php"
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Edutrack Lesotho</title>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="footer.css">
    <link href="https://fonts.googleapis.com/css?family=DM Sans" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  </head>
  <body>
    <div class="hero-section flex-col gap-10 lg:flex-row lg:gap-1 mb-8">
      <div>
      <div class="introduction">
       <p class="intro">Hello, </p>
       <div class="intro2">
        <p class="normal-intro">Welcome to</p>
        <p class="colored-intro">Edutrack Lesotho</p>
       </div>
      </div>
      
      <div class="first-div">
        <p class="description">Simplify school reporting with ease! Our intuitive platform helps educators create professional, accurate and customized reports, while ensuring consistency across your school, in minutes-no stress, no fuss, just results.</p>
        </div>

        <p class="suggest">Are you a principal or teacher at your school? Don't hesitate to join the team!</p>
      
      <div class="paragraph">
        <a href="#"><button class="register-btn">Register my school</button></a>
        <a href="once.php"><button class="once-btn ">Once-off use</button></a>
      </div>
      </div>
      <div class="picture flex justify-center w-[90%] md:w-full lg:justify-start">
          <img src="assets/hero_section.jpg" alt="hero section image" width="500" height="300" class="shadow-2xl rounded-md"/>
      </div>
    </div>

    <?php
    include "footer.php"
    ?>
  </body>

</html>
