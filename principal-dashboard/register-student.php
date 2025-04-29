<!-- TODO: ADD STUDENT NUMBER COLUMN IN DATABASE -->
<!-- TODO: REPLACE EMAIL FIELD WITH STUDENT NUMBER FIELD -->
<!-- NOTE: YOU CAN SET EMAIL TO EMPTY STRING ON REGISTRATION for STUDENT -->

<?php
session_start();
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['PRINCIPAL','TEACHER'])) {
    header('Location: login.php');
    exit;
}

$schoolName = $_SESSION["school_name"] ?? 'school';
$error   = $_SESSION['error']   ?? '';
$success = $_SESSION['success'] ?? '';
unset($_SESSION['error'], $_SESSION['success']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register Student</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6">
  <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md">
    <h1 class="text-2xl text-orange-500 text-center mb-6">Register New Student</h1>

    <?php if ($error): ?>
      <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
      <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" action="./scripts/register-student-script.php" class="space-y-4">
    <div>
        <label class="block mb-1 font-medium">Full Name</label>
        <input type="text" name="full-name" required placeholder="Full Name"class="w-full bg-[#eee] text-[#333] p-2 rounded-md">
      </div>
      <div>
        <label class="block mb-1 font-medium">Student Number</label>
        <input type="text" name="student-number" required placeholder="Student Number"class="w-full bg-[#eee] text-[#333] p-2 rounded-md">
      </div>
      <div>
        <label class="block mb-1 font-medium">School Name</label>
        <input type="text" name="school-name" value="<?= htmlspecialchars($schoolName) ?>"  class="w-full bg-[#eee] text-[#333] p-2 rounded-md" readonly>
      </div>
      <div>
        <label class="block mb-1 font-medium">Password</label>
        <input type="password" name="password" required placeholder="Password" class="w-full bg-[#eee] text-[#333] p-2 rounded-md">
      </div>
      <div>
        <label class="block mb-1 font-medium">Class Name</label>
        <input type="text" name="class-name" placeholder="e.g. Grade 10A" class="w-full bg-[#eee] text-[#333] p-2 rounded-md">
      </div>
      <div class="flex justify-between items-center">
        <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition cursor-pointer">
          Register Student
        </button>
        <?php if ($_SESSION['role'] === 'PRINCIPAL'): ?>
          <a href="index.php"
             class="text-blue-500 underline">Back to Dashboard</a>
        <?php else: /* TEACHER */ ?>
          <a href="teacher_dashboard.php"
             class="text-blue-500 underline">Back to Dashboard</a>
        <?php endif; ?>
      </div>
    </form>
  </div>
</body>
</html>
