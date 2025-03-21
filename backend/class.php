<?php
include ('db.php');
date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }


        public function Login($username)
    {
        // Prepare the SQL query to fetch user by username
        $query = $this->conn->prepare("SELECT * FROM `user` WHERE `username` = ? AND `status` = '1'");

        // Bind username parameter
        $query->bind_param("s", $username);

        // Execute the query
        if ($query->execute()) {
            $result = $query->get_result();
            if ($result->num_rows > 0) {
                return $result->fetch_assoc(); // Return user data
            }
        }

        return false;  // User not found
    }

    
}