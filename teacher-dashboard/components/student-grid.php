<?php
// session_start();
require_once dirname(__DIR__, 2) . '/db/db_config.php';
?>
<?php
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- get school subjects ---

// Fetch school subjects
$schoolName = $_SESSION['school_name'];
$subjectSql = "SELECT subject FROM school_subjects WHERE school_name = '$schoolName'";
$subjectRes = $conn->query($subjectSql);
$schoolSubjects = [];

if ($subjectRes && $subjectRes->num_rows > 0) {
    while ($row = $subjectRes->fetch_assoc()) {
        $schoolSubjects[] = $row['subject'];
    }
}

$_SESSION['school_subjects'] = $schoolSubjects;

// --- Pagination setup ---
$studentsPerPage = 10; // How many students per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $studentsPerPage;

// Count total number of students
$countResult = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'STUDENT'");
$totalStudents = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalStudents / $studentsPerPage);

// Fetch students for current page
$result = $conn->query("SELECT * FROM users WHERE role = 'STUDENT' LIMIT $studentsPerPage OFFSET $offset");

$subjectsQuery = '';
  if (isset($_SESSION['subjects']) && is_array($_SESSION['subjects'])) {
      foreach ($_SESSION['subjects'] as $subject) {
          $subjectsQuery .= '&subjects[]=' . urlencode($subject);
      }
  }

?>

<div class="overflow-x-auto">
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
      <?php while ($row = $result->fetch_assoc()): ?>
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
            <a href="add-marks.php?student_id=<?= urlencode($row['id']) . $subjectsQuery ?>&student_name=<?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name'])?>"
               class="inline-block bg-blue-500 text-white px-3 py-2 rounded-lg text-sm hover:bg-blue-600">
              Add Marks
            </a>
            <a href="edit-marks.php?student_id=<?= urlencode($row['id']) ?>" 
               class="inline-block bg-orange-500 text-white px-3 py-2 rounded-lg text-sm hover:bg-orange-600">
              Edit Marks
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

<?php 
if (isset($conn)) {
  $conn->close();
}
?>