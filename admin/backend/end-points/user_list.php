<?php 

$fetch_all_user = $db->fetch_all_user();

if ($fetch_all_user->num_rows>0): ?>
    <?php foreach ($fetch_all_user as $user):
        ?>
       <tr>
            <td class="p-2"><?php echo htmlspecialchars($user['name']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($user['username']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($user['type']); ?></td>
            <td class="p-2 flex space-x-2">
                <button class="showUpdateModal TogglerUpdateUser px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600"
                data-id="<?= $user['id']; ?>"
                data-name="<?= $user['name']; ?>"
                data-username="<?= $user['username']; ?>"
                data-type="<?= $user['type']; ?>"
                >
                Update</button>
                <button class="TogglerDeleteUser px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                data-id=<?= $user['id']; ?>>
                Delete
                </a>
            </td>
        </tr>

    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="p-2">No record found.</td>
    </tr>
<?php endif; ?>