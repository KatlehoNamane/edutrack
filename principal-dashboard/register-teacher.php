<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'PRINCIPAL') {
    header('Location: login.php');
    exit;
}

// echo "<pre>" . print_r($_SESSION) . "</pre>";

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
  <title>Register Teacher</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6">
  <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md">
    <h1 class="text-2xl text-orange-500 mb-6 text-center">Register New Teacher</h1>

    <?php if ($error): ?>
      <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
      <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" action="./scripts/register-teacher-script.php" class="space-y-4">
  <div>
    <label class="block mb-1 font-medium">Full Name</label>
    <input type="text" name="full-name" required placeholder="Full Name" class="w-full bg-[#eee] text-[#333] p-2 rounded-md">
  </div>
  <div>
    <label class="block mb-1 font-medium">Email</label>
    <input type="email" name="email" required placeholder="Email" class="w-full bg-[#eee] text-[#333] p-2 rounded-md">
  </div>
  <div>
    <label class="block mb-1 font-medium">School Name</label>
    <input type="text" name="school-name" value="<?= htmlspecialchars($schoolName) ?>" class="w-full bg-[#eee] text-[#333] p-2 rounded-md" readonly>
  </div>
  <div>
    <label class="block mb-1 font-medium">Password</label>
    <input type="password" name="password" required placeholder="Password" class="w-full bg-[#eee] text-[#333] p-2 rounded-md">
  </div>
  <div>
    <label class="block mb-1 font-medium">Subjects Taught</label>
    <textarea name="subjects" required placeholder="e.g., Mathematics, English, Science" rows="3" class="w-full bg-[#eee] text-[#333] p-2 rounded-md resize-none"></textarea>
  </div>
  <div class="flex justify-between items-center">
    <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition cursor-pointer">
      Register Teacher
    </button>
    <a href="index.php" class="text-blue-500 underline">Back to Dashboard</a>
  </div>
</form>
  </div>
</body>
</html>
