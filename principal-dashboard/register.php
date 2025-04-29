<?php 
  require "./scripts/login-principal-script.php";
 
?>

<!-- used on mobile view -->

<html>
    <head>
        <title>Principal Registration</title>
        <link rel="stylesheet" href="./styles/login-style.css">
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://fonts.googleapis.com/css?family=DM Sans" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    </head>
     <body>
     <div class="container-registration w-[90%] md:w-[60%] lg:w-[30%]">
     <div class="form-box-registration register">
      <form action="#">
        <h1 class="registration">Registration</h1>
        <div class="input-box">
          <input type="text" placeholder="Full Name" required>
          <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
          <input type="email" placeholder="Email" required>
          <i class='bx bxs-envelope'></i>
        </div>
        <div class="input-box">
          <input type="text" placeholder="School name" name="school-name" required>
          <i class='bx bxs-school'></i>
        </div>
        <div>
        <label class="block mb-1 font-medium">School Subjects</label>
        <textarea name="subjects" required placeholder="e.g., Mathematics, English, Science" rows="3" class="w-full bg-[#eee] text-[#333] p-2 rounded-md resize-none"></textarea>
      </div>
        <div class="input-box">
          <input type="password" placeholder="Password" required>
          <i class='bx bxs-lock-alt'></i>
        </div>
        <div class="links">
          <span>
            Already have an account? 
            <a href="./login.php" id="login">Login</a>
          </span>
        </div>
        <button type="submit" class="btn">Register</button>
        <!-- <p>or register with social platforms</p>
        <div class="social-icons">
          <a href="#"><i class='bx bxl-google'></i></a>
          <a href="#"><i class='bx bxl-facebook'></i></a>
          <a href="#"><i class='bx bxl-github'></i></a>
          <a href="#"><i class='bx bxl-linkedin'></i></a>
        </div> -->
      </form>
    </div>
</div>
    </body>
</html>