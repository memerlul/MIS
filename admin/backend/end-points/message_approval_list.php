<?php 
date_default_timezone_set('Asia/Manila');
$message_approval_list = $db->message_approval_list();

if ($message_approval_list->num_rows > 0): ?>
    <?php foreach ($message_approval_list as $message): ?>
        <tr>
            <td class="p-2"><?php echo htmlspecialchars($message['sender_id']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($message['receiver_id']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($message['systemFrom']); ?></td>
          
            <td class="p-2">
                <?= isset($message['date_sent']) 
                    ? date("F d, Y h:i A", strtotime($message['date_sent'])) 
                    : 'N/A'; ?>
            </td>

            <td class="p-2 flex space-x-2">
                <!-- Download Button -->
                <a href="../assets/upload_files/<?= htmlspecialchars($message['message_media']); ?>" 
                   target="_blank" download="<?= htmlspecialchars($message['message_media']); ?>"
                   class="px-3 py-1 bg-gray-500 text-white rounded hover:bg-blue-600 flex items-center gap-2">
                    <span class="material-icons text-white">attach_file</span>
                    Download
                </a>
                    <!-- Delete Button -->
                <button class="TogglerAcceptChat px-3 py-1 bg-blue-500 text-white rounded hover:bg-red-600"
                        data-id="<?= $message['chat_id']; ?>">
                    Approve
                </button>
                <!-- Delete Button -->
                <button class="TogglerDeleteChat px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                        data-id="<?= $message['chat_id']; ?>">
                    Delete
                </button>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="p-2">No record found.</td>
    </tr>
<?php endif; ?>
