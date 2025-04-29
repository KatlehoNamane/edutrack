<?php
$conn = new mysqli($servername, $username, $password, $database);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$schoolName = $_SESSION["school_name"];
$schoolSubjects = $_SESSION['school_subjects'] ?? [];

// --- Pagination setup ---
$studentsPerPage = 10; // How many students per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $studentsPerPage;

// Count total number of students
$countResult = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'STUDENT' AND school_name = '$schoolName'");
$totalStudents = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalStudents / $studentsPerPage);
?>

<div class=" hidden overflow-x-auto" id="role-STUDENT">
  <table class="min-w-full bg-white rounded-2xl shadow-md overflow-hidden">
    <thead class="bg-gray-100 sticky top-0 z-10">
      <tr>
        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Name</th>
        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Student Number</th>
        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Role</th>
        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Subjects</th>
        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">School</th>
        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Actions</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
      <?php $result->data_seek(0); 
            while ($row = $result->fetch_assoc()):
              if ($row['role'] !== 'STUDENT') continue;
      ?>
        <tr class="hover:bg-gray-50 transition">
          <td class="px-6 py-4 whitespace-nowrap">
            <?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <?= htmlspecialchars($row['student_number'] ?? '—') ?>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <?= capitalizeFirst(htmlspecialchars($row['role'])) ?>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
          <?= htmlspecialchars(implode(', ', $schoolSubjects)) ?>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <?= htmlspecialchars($row['school_name']) ?>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
            <a href="edit-user.php?user_id=<?= urlencode($row['id']) ?>&type=STUDENT"
                   class="px-4 py-2 bg-orange-500 text-white rounded-lg">
                  Edit
                </a>
                <a href="?delete_id=<?= urlencode($row['id']) ?>"
                   onclick="return confirm('Delete this user?')"
                   class="px-4 py-2 bg-red-500 text-white rounded-lg">
                  Delete
                </a>
                <a href="student-report.php?student_id=<?= urlencode($row['id']) ?>"
                   class="px-4 py-2 bg-green-500 text-white rounded-lg">
                  See Report
                </a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <!-- Pagination -->
  <div class="flex justify-center mt-6 space-x-2">
    <?php if ($page > 1): ?>
      <a href="?page=<?= $page - 1 ?>" 
         class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
        Previous
      </a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <a href="?page=<?= $i ?>"
         class="px-4 py-2 <?= $i == $page ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-700' ?> rounded-md hover:bg-blue-400">
         <?= $i ?>
      </a>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
      <a href="?page=<?= $page + 1 ?>" 
         class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
        Next
      </a>
    <?php endif; ?>
  </div>
</div>