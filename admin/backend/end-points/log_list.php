<?php 

$fetch_all_user = $db->fetch_all_logs();

if ($fetch_all_user->num_rows>0): ?>
    <?php foreach ($fetch_all_user as $user):
        ?>
       <tr>
            <td class="p-2"><?php echo htmlspecialchars($user['log_date']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($user['log_description']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($user['username']); ?></td>
            
        </tr>

    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="p-2">No record found.</td>
    </tr>
<?php endif; ?>