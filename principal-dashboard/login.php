<?php 
  require "./scripts/login-principal-script.php";
 
?>

<html>
    <head>
        <title>Principal Login</title>
        <link rel="stylesheet" href="./styles/login-style.css">
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://fonts.googleapis.com/css?family=DM Sans" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>
     <body>   
  <div class="container">
    <div class="form-box login">
      <form action="" method="POST" class="">
        <h1 class="login">Login</h1>
        <?php if (!empty($error)) : ?>
          <br>
          <div class="w-full h-10 bg-red-300 rounded-sm flex flex-wrap justify-center items-center">
            <p class='text-red-500 w-full flex justify-center items-center'><?php echo $error ?></p>
          </div>
        <?php endif; ?>
        <div class="input-box">
          <input type="email" placeholder="Email" name="email" required>
          <i class='bx bxs-envelope'></i>
        </div>
        <div class="input-box">
          <input type="password" placeholder="Password" name="password" required>
          <i class='bx bxs-lock-alt'></i>
        </div>
        <div class="links ">
          <a href="#" id="forgot-password">Forgot Password?</a>
          <a href="./register.php" id="register" class="md:hidden">Sign Up</a>
        </div>
        <button type="submit" class="btn">Login</button>
        <!-- <p>or login with social platforms</p>
        <div class="social-icons">
          <a href="#"><i class='bx bxl-google'></i></a>
          <a href="#"><i class='bx bxl-facebook'></i></a>
          <a href="#"><i class='bx bxl-github'></i></a>
          <a href="#"><i class='bx bxl-linkedin'></i></a>
        </div> -->
      </form>
    </div>

    <div class="form-box register">
      <form action="#" method="POST">
      <?php if (!empty($error) && $error !== "User not found.") : ?>
          <br>
          <div class="w-full h-10 bg-red-300 rounded-sm flex flex-wrap justify-center items-center">
            <p class='text-red-500 w-full flex justify-center items-center'><?php echo $error ?></p>
          </div>
        <?php endif; ?>
        <h1 class="registration">Registration</h1>
        <div class="input-box">
          <input type="text" placeholder="Full Name" name="full-name" required>
          <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
          <input type="email" placeholder="Email" name="email" required>
          <i class='bx bxs-envelope'></i>
        </div>
        <div class="input-box">
          <input type="text" placeholder="School name" name="school-name" required>
          <i class='bx bxs-school'></i>
        </div>
        <div class="input-box">
          <input type="password" placeholder="Password" name="password" required>
          <i class='bx bxs-lock-alt'></i>
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

    <div class="toggle-box hidden md:block">
      <div class="toggle-panel toggle-left">
        <h1>Hello, Welcome!</h1>
        <p>Don't have an account?</p>
        <button class="btn register-btn">Register</button>
      </div>

      <div class="toggle-panel toggle-right">
        <h1>Welcome Back!</h1>
        <p>Already have an account?</p>
        <button class="btn login-btn">Login</button>
      </div>
    </div>
  </div>

  <script src="./scripts/main.js"></script>
     </body>
</html>