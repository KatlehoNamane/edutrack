<div id="role-TEACHER"
           class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php if ($result && $result->num_rows === 0): ?>
            <div class="text-red-500 text-center p-3 rounded mb-4">No teachers found!</div>
          <?php endif; ?>
        <?php 
          $result->data_seek(0);
          while ($row = $result->fetch_assoc()):
            if ($row['role'] !== 'TEACHER') continue;
        ?>
          <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="p-6">
              <h3 class="text-xl font-medium mb-2">
                <?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?>
              </h3>
              <p class="text-gray-600 mb-1">
                <strong>Email:</strong> <?= htmlspecialchars($row['email']) ?>
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
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>

     