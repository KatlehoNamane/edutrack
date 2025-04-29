<div id="role-STUDENT"
           class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          
        <?php 
        //   $result->data_seek(0);
          while ($row = $result->fetch_assoc()):
            if ($row['role'] !== 'STUDENT') continue;
        ?>
          <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="p-6">
              <div class="flex justify-between">
                <h3 class="text-xl font-medium mb-2">
                  <?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?>
                </h3>
                <a href="../report.php" class="text-blue-500">
                  <button class="text-white bg-blue-500 rounded-md p-2">Create report</button>
                </a>
              </div>
              <p class="text-gray-600 mb-1 mt-6">

                <strong>Student Number:</strong>
                <?= htmlspecialchars($row['student_number'] ?? '—') ?>
              </p>
              <p class="text-gray-600 mb-1">
                <strong>Role:</strong> <?= capitalizeFirst(htmlspecialchars($row['role'])) ?>
              </p>
              <p class="text-gray-600 mb-4">
                <strong>School:</strong> <?= htmlspecialchars($row['school_name']) ?>
              </p>
              <div class="flex space-x-3">
                <a href="edit_user.php?id=<?= urlencode($row['id']) ?>"
                   class="px-4 py-2 bg-orange-500 text-white rounded-lg">
                  Edit
                </a>
                <a href="?delete_id=<?= urlencode($row['id']) ?>"
                   onclick="return confirm('Delete this user?')"
                   class="px-4 py-2 bg-red-500 text-white rounded-lg">
                  Delete
                </a>
                <a href="save_student.php?id=<?= urlencode($row['id']) ?>"
                   class="px-4 py-2 bg-green-500 text-white rounded-lg">
                  See Reports
                </a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>