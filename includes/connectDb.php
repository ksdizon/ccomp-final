<?php
    include dirname(__FILE__) . '/../config/config.php';

    function connect_db() {
        // Create connection
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Return connection so that it can be used later
        return $conn;
    }
?>