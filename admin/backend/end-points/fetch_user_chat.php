<?php 

include('../class.php');
session_start();

$db = new global_class();

// Validate session variable
$sender_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
$receiver_id = isset($_POST['receiver_id']) ? $_POST['receiver_id'] : null;

// Check if sender ID exists
if (!$sender_id) {
    echo json_encode(['status' => 'error', 'message' => 'User not authenticated.']);
    exit;
}

// Check if receiver ID is provided
if (!$receiver_id) {
    echo json_encode(['status' => 'error', 'message' => 'Receiver ID is missing.']);
    exit;
}

// Fetch messages
$messages = $db->fetchUserChats($sender_id, $receiver_id);

if (!empty($messages)) {
    echo json_encode(['status' => 'success', 'messages' => $messages]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No messages found.']);
}
?>
