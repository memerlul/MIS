<?php
include('../class.php');

$db = new global_class();

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['requestType'])) {
        if ($_POST['requestType'] == 'send_chat') {
            

            if (isset($_FILES['file-input']) && $_FILES['file-input']['error'] == 0) {
                $uploadedFile = $_FILES['file-input'];
                $uploadDir = '../../../assets/upload_files/';
                
                // Get the original file extension
                $fileExtension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
                
                // Generate a unique file name using a timestamp and a random unique ID
                $uniqueFileName = uniqid('file_', true) . '.' . $fileExtension;
                $uploadFilePath = $uploadDir . $uniqueFileName;
            
                // Ensure the directory exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
            
                // Move the uploaded file to the target directory
                if (move_uploaded_file($uploadedFile['tmp_name'], $uploadFilePath)) {
                    $fileInput = $uniqueFileName; // Store the unique file name
                } else {
                    $fileInput = null; // File upload failed
                }
            } else {
                $fileInput = null; // No file uploaded
            }
            
            // Collect other form data
            $sender_id = $_POST['sender_id'];
            $reciever_id = $_POST['reciever_id'];
            $messageinput = $_POST['message-input'];
            $systemFrom = $_POST['systemFrom'];
            $systemTo = $_POST['systemTo'];
            
            
            // Insert the car record into the database
            $user = $db->send_chat($sender_id,$reciever_id, $messageinput, $fileInput,$systemFrom,$systemTo);
            
            if ($user) {
                echo "success";
            } else {
                echo "Error Messages .";
            }
        }else if ($_POST['requestType'] == 'AddUser') {

           
            $fullname = $_POST['fullname'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $userType = $_POST['userType'];
          
           $hashed_password = password_hash($password, PASSWORD_DEFAULT);



            // Call the method
            $user = $db->AddUser($fullname, $username, $userType,$hashed_password);

            if ($user === "username_exists") {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'username already exists!'
                ]);
            } elseif ($user) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'User added successfully!',
                    'data' => $user
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'User addition failed!'
                ]);
            }

            
        }else if ($_POST['requestType'] == 'updateUser') {

            $userid = $_POST['userid'];
            $fullname = $_POST['fullname'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $userType = $_POST['userType'];
            
            // Check if password is empty
            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            } else {
                $hashed_password = ""; // Set as empty string
            }
            
            // Call the method
            $user = $db->updateUser($userid, $fullname, $username, $userType, $hashed_password);
            
            if ($user === "username_exists") {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Username already exists!'
                ]);
            } elseif ($user) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'User updated successfully!',
                    'data' => $user
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'User update failed!'
                ]);
            }
            

            
        }else if ($_POST['requestType'] === "DeleteAdmin") {
            $admin_id = $_POST['admin_id'];
    
            if ($db->DeleteAdmin($admin_id)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Admin deleted successfully!'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to delete admin. Please try again!'
                ]);
            }
        }else if ($_POST['requestType'] === "DeleteChat") {
            $chat_id = $_POST['chat_id'];
    
            if ($db->DeleteChat($chat_id)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Chat deleted successfully!'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to delete admin. Please try again!'
                ]);
            }
        }else if ($_POST['requestType'] === "ApproveChat") {
            $chat_id = $_POST['chat_id'];
    
            if ($db->ApproveChat($chat_id)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Chat deleted successfully!'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to delete admin. Please try again!'
                ]);
            }
        } else {
            echo 'requestType NOT FOUND';
        }
        
    } else {
        echo 'Access Denied! No Request Type.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
}
?>