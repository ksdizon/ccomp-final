<?php
session_start();

include 'trackData.php';

function login() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $database_handler = connect_db();
        $statement_handler = $database_handler->prepare("SELECT * FROM USERS WHERE username = :username");
        $statement_handler->bindParam(':username', $username);
        $statement_handler->execute();

        $user = $statement_handler->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            // Successful login
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['gender'] = $user['gender'];
            $_SESSION['age'] = $user['age'];
            $_SESSION['user_id'] = $user['user_id'];

            // Check user role from USER_ROLES table
            $role_statement = $database_handler->prepare("SELECT role_id FROM USER_ROLES WHERE user_id = :user_id");
            $role_statement->bindParam(':user_id', $user['user_id']);
            $role_statement->execute();

            $role = $role_statement->fetchColumn(); // Fetch the role of the user

            // Check if user is an admin
            if ($role === 1) {
                $_SESSION['is_admin'] = true;
                header('Location: ../routes/dashboard.php'); // Redirect to the dashboard for admins
            } else {
                collateConnectionInfo();
                header('Location: ../index.php'); // Redirect to the homepage for regular users
            }
            exit(); // Always exit after a header redirect
        } else {
            // Redirect with error message
            header('Location: ../routes/login.php?error=wrong_credentials');
            exit();
        }
    }
}

login();
?>
