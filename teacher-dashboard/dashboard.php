<?php
  // dashboard.php
  include "./scripts/dashboard-script.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Teacher Dashboard</title>
  <link href="https://fonts.googleapis.com/css?family=DM+Sans" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <style>
    body {
      font-family: "DM Sans", sans-serif;
      background-color: #eee;
    }
  </style>
</head>
<body class="p-6">

  <div class="w-full flex flex-col md:flex-row gap-2 justify-between mb-5">
    <h1 class="text-2xl font-bold">Teacher Dashboard</h1>
  </div>

  <!-- Messages -->
  <?php if ($error): ?>
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?= htmlspecialchars($error) ?></div>
  <?php elseif ($success): ?>
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <!-- Search Users -->
  <section class="mb-4 w-full flex justify-start md:justify-center">
    <form method="GET" class="flex space-x-2 w-[50%]">
      <input
        type="text"
        name="search"
        value="<?= htmlspecialchars($search) ?>"
        placeholder="Search by student number or last name"
        class="bg-gray-300 p-2 flex-grow rounded-md pl-5"
      >
      <button type="submit"
              class="bg-orange-500 text-white px-4 py-4 rounded-full cursor-pointer">
        <!-- search icon -->
        <svg xmlns="http://www.w3.org/2000/svg"  width="24" height="24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="lucide lucide-search-icon">
          <circle cx="11" cy="11" r="8"/>
          <path d="m21 21-4.3-4.3"/>
        </svg>
      </button>
    </form>
  </section>

  <!-- Mobile Add Buttons -->
  <div class="flex md:hidden w-fit mb-4">
    <a href="register-student.php" class="bg-orange-500 text-white px-4 py-2 rounded-md flex gap-2 items-center">
      <svg xmlns="http://www.w3.org/2000/svg"  width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus-icon lucide-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg> 
      Student
    </a>
  </div>

  <!-- User Lists -->
  <section class="py-8">
    <div class="max-w-6xl mx-auto px-4">

      <!-- Students Grid -->
      <?php if ($result->num_rows == 0): ?>
          <div class="text-red-500 text-center p-3 rounded mb-4">No students found!</div>
      <?php else: ?>
        <?php include "./components/student-grid.php" ?>
      <?php endif; ?>

    </div>
  </section>

</body>
</html>
