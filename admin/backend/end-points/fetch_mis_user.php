<?php
// Set the response header to JSON
header('Content-Type: application/json');

// Include the class
include('../class.php');

session_start();
$sender_id = "";

// Check if session variables exist and assign the sender_id correctly
if (isset($_SESSION['id'])) {
    $sender_id = $_SESSION['id'];
} elseif (isset($_SESSION['user_id'])) {  // Corrected `else if` condition
    $sender_id = $_SESSION['user_id'];
}

// Ensure sender_id is not empty before proceeding
if (!empty($sender_id)) {
    $class = new global_class();
    $data = $class->fetch_mis_user($sender_id); // Fetch data
    echo json_encode($data); // Output JSON-encoded response
} else {
    // Return an error if sender_id is not found
    echo json_encode(["error" => "User not authenticated."]);
}
?>
