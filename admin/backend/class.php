<?php
include ('db.php');
date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }

    public function fetchUserChats($sender_id, $receiver_id) {
        $sql = "SELECT * from chat_messages as cm WHERE (cm.sender_id = ? AND cm.receiver_id = ?) 
                   OR (cm.sender_id = ? AND cm.receiver_id = ?)";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiii", $sender_id, $receiver_id, $receiver_id, $sender_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $messages = [];
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
    
        return $messages;
    }



    public function check_account($user_id ) {
        $query = "SELECT * FROM user WHERE id = $user_id";
        $result = $this->conn->query($query);

        $items = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
        }
        return $items; 
    }


        public function send_chat($sender_id,$reciever_id, $messageinput, $fileInput,$systemFrom,$systemTo)
    {
        $user = $this->check_account($sender_id);

        $status = !empty($fileInput) ? 2 : 1;

        if (!empty($user) && $user[0]['type'] === "super admin") {
            $status = 1;
        }

        // Prepare query to insert chat message
        $query = $this->conn->prepare("INSERT INTO `chat_messages` (sender_id, receiver_id, message_text, message_media, systemFrom,systemTo, message_status) VALUES (?, ?, ?, ?, ?, ?,?)");
        
        if ($query === false) {
            return false; 
        }

        $query->bind_param("ssssssi", $sender_id, $reciever_id, $messageinput, $fileInput,$systemFrom,$systemTo, $status);

        return $query->execute();
    }



    public function fetch_mis_user($sender_id){
        $query = $this->conn->prepare("SELECT * FROM `user` WHERE status = ? AND id != ?");
        
        $active_status = 1; // Ensure correct data type (int)
        $query->bind_param("ii", $active_status,$sender_id);
    
        if ($query->execute()) {
            $result = $query->get_result();
            return $result->fetch_all(MYSQLI_ASSOC); // Return as an associative array
        } else {
            return []; // Return an empty array if query fails
        }
    }
   
   



    public function fetch_all_user(){
        $query = $this->conn->prepare("SELECT * FROM `user` where status='1'");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }
    public function fetch_all_logs(){
        $query = $this->conn->prepare("SELECT * FROM `activity_logs`
        LEFT JOIN user ON user.id = activity_logs.log_user_id
        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }


    public function message_approval_list() {
        $query = $this->conn->prepare("
            SELECT chat_messages.*, 
                   sender.name AS sender, 
                   receiver.name AS receiver 
            FROM chat_messages
            LEFT JOIN user AS sender ON sender.id = chat_messages.sender_id
            LEFT JOIN user AS receiver ON receiver.id = chat_messages.receiver_id
            WHERE chat_messages.message_status = '2'
            ORDER BY `chat_id` DESC
        ");
    
        if ($query->execute()) {
            return $query->get_result();
        }
    }
    
    


    public function DeleteAdmin($admin_id) {
        // Update the status of the admin to '0' (effectively disabling the account)
        $query = $this->conn->prepare("UPDATE user SET status = '0' WHERE id = ?");
        $query->bind_param("i", $admin_id); 
    
        if ($query->execute()) {
            // Get the username of the admin to be deleted (disabled)
            $user = $this->check_account($admin_id);  // Assuming this function returns user details in an array
            
            // Ensure that the 'username' is accessed properly
            if ($user && isset($user[0]['username'])) {
                $activity_description = "Deleted user: " . $user[0]['username'];
                
                // Log the activity for the admin performing the action
                $this->AddLog($admin_id, $activity_description);  // Use $admin_id for the user performing the action
    
                return true; 
            } else {
                return false;  // Return false if user details are not found
            }
        } else {
            return false;  // Return false if the update query fails
        }
    }
    
    


    public function DeleteChat($chat_id) {
        $query = $this->conn->prepare("UPDATE chat_messages SET message_status = '0' WHERE chat_id  = ?");
        $query->bind_param("i", $chat_id); 
    
        if ($query->execute()) {
            return true; 
        } else {
            return false; 
        }
    }
    
    public function ApproveChat($chat_id) {
        $query = $this->conn->prepare("UPDATE chat_messages SET message_status = '1' WHERE chat_id  = ?");
        $query->bind_param("i", $chat_id); 
    
        if ($query->execute()) {
            return true; 
        } else {
            return false; 
        }
    }
    

    public function AddLog($userId, $description) {
        // Prepare the insert query for activity logs
        $log_query = $this->conn->prepare("INSERT INTO activity_logs (log_user_id, log_description) VALUES (?, ?)");
        $log_query->bind_param("is", $userId, $description);
        
        // Execute the activity log query
        return $log_query->execute();
    }
    


    public function AddUser($fullname, $username, $userType, $hashed_password) {
        // Check if username already exists
        $check_query = $this->conn->prepare("SELECT id FROM user WHERE username = ?");
        $check_query->bind_param("s", $username);
        $check_query->execute();
        $check_query->store_result();
    
        if ($check_query->num_rows > 0) {
            return "username_exists";  // Return a flag indicating username already exists
        }
    
        // Insert new user if username does not exist
        $query = $this->conn->prepare("INSERT INTO user (`name`, `username`, `password`, `type`) VALUES (?, ?, ?, ?)");
        $query->bind_param("ssss", $fullname, $username, $hashed_password, $userType);
    
        if ($query->execute()) {
            // Get last inserted ID for user
            $userId = $this->conn->insert_id;
            
            // Log the activity
            $activity_description = "Added new user: $fullname ($username) position ($userType)";
            $this->AddLog($userId, $activity_description);
    
            return [
                'id' => $userId,  // Get last inserted ID
                'fullname' => $fullname,
                'username' => $username,
                'hashed_password' => $hashed_password,
                'userType' => $userType
            ];
        } else {
            return false;  // Return false if insertion failed
        }
    }
    











    public function updateUser($userid, $fullname, $username, $userType, $hashed_password) {
        // Check if username already exists for another user
        $check_query = $this->conn->prepare("SELECT id FROM user WHERE username = ? AND id != ?");
        $check_query->bind_param("si", $username, $userid);
        $check_query->execute();
        $check_query->store_result();
    
        if ($check_query->num_rows > 0) {
            return "username_exists";  // Return a flag indicating username already exists
        }
    
        // Build the UPDATE query dynamically
        $query_str = "UPDATE user SET `name` = ?, `username` = ?, `type` = ?";
        $params = [$fullname, $username, $userType];
        $types = "sss";
    
        // Add password if provided
        if (!empty($hashed_password)) {
            $query_str .= ", `password` = ?";
            $params[] = $hashed_password;
            $types .= "s";
        }
    
        // Complete the query
        $query_str .= " WHERE id = ?";
        $params[] = $userid;
        $types .= "i";
    
        // Prepare and bind parameters
        $query = $this->conn->prepare($query_str);
        $query->bind_param($types, ...$params);
    
        if ($query->execute()) {
            // Log the activity
            $activity_description = "Updated user: $fullname ($username) to position: $userType";
            $this->AddLog($userid, $activity_description);  // Use $userid for the user performing the action
    
            return [
                'id' => $userid,
                'fullname' => $fullname,
                'username' => $username,
                'userType' => $userType,
                'hashed_password' => !empty($hashed_password) ? $hashed_password : "not_updated"
            ];
        } else {
            return false;  // Return false if update failed
        }
    }
    
    
    


    
}