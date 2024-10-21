<?php
    include dirname(__FILE__) . '/../config/config.php';
    
    function connect_db() {
        // Create 
        try {
            $database_handle = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME .';', DB_USERNAME, DB_PASSWORD);
        } catch (PDOException $e){
            echo 'error connecting with db';
        }

        return $database_handle;
    }
?>