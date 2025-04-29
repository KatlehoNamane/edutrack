<html>
    <head>
        <title>Student Login</title>
        <link rel="stylesheet" href="../styles/login-style.css">
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://fonts.googleapis.com/css?family=DM Sans" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>
     <body>
      
  <div class="container w-[90%] md:w-[60%] lg:w-[30%]">
    <div class="form-box login">
      <form action="./scripts/login-student-script.php" method="POST">
        <h1 class="login">Login</h1>
        <?php if (!empty($error)) : ?>
          <br>
          <div class="w-full h-10 bg-red-300 rounded-sm flex flex-wrap justify-center items-center">
            <p class='text-red-500 w-full flex justify-center items-center'><?php echo $error ?></p>
          </div>
        <?php endif; ?>
        <div class="input-box">
          <input type="text" placeholder="Student Number" name="student-number" required>
          <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
          <input type="password" placeholder="Password" name="password" required>
          <i class='bx bxs-lock-alt'></i>
        </div>
        <div class="forgot-link">
          <a href="#">Forgot Password?</a>
        </div>
        <button type="submit" class="btn">Login</button>
      </form>
    </div>
  </div>

  

     </body>
</html>