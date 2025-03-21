<?php
include('../class.php');

$db = new global_class();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['requestType'])) {

        
        if ($_POST['requestType'] == 'Login') {
            $username = $_POST['username'];
            $password = $_POST['password'];
        
            // Fetch user data based on username
            $response = $db->Login($username);
        
            if ($response) {
                $hashedPassword = $response['password']; // Get stored hashed password
        
                // Verify password
                if (password_verify($password, $hashedPassword)) {
                    // Start session and store user ID
                    session_start();
                    $_SESSION['id'] = $response['id'];
                    $_SESSION['username'] = $response['username'];
        
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Login successful',
                        'data' => $response
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Invalid username or password'
                    ]);
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid username or password'
                ]);
            }
        }
        
        













    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Access Denied! No Request Type.'
        ]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode([
        'status' => 'error',
        'message' => 'GET requests are not supported for login.'
    ]);
}
?>