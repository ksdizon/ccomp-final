<?php
    include 'connectDb.php';
    
    register();

    function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Collect form data
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            try {
                // Connect to the database
                $database_handler = connect_db();

                // Check if the username already exists
                $check_user_stmt = $database_handler->prepare("SELECT username FROM USERS WHERE username = :username");
                $check_user_stmt->bindParam(':username', $username);
                $check_user_stmt->execute();

                if ($check_user_stmt->rowCount() > 0) {
                    // Username already exists, return an alert
                    echo "<script>alert('Username already exists. Please choose a different username.'); window.history.back();</script>";
                } else {
                    // Prepare the SQL query for inserting the user data
                    $statement_handler = $database_handler->prepare("
                        INSERT INTO USERS (user_id, first_name, last_name, username, email, password, age, gender) 
                        VALUES (0, :firstName, :lastName, :username, :email, :password, :age, :gender)
                    ");

                    // Bind the parameters
                    $statement_handler->bindParam(':firstName', $firstName);
                    $statement_handler->bindParam(':lastName', $lastName);
                    $statement_handler->bindParam(':username', $username);
                    $statement_handler->bindParam(':email', $email);
                    $statement_handler->bindParam(':password', $hashed_password);  // Store the hashed password
                    $statement_handler->bindParam(':age', $age);
                    $statement_handler->bindParam(':gender', $gender);

                    // Execute the statement
                    if ($statement_handler->execute()) {
                        // Successful registration, redirect to index page
                        echo "<script>alert('Registration successful!'); window.location.href = '../index.php';</script>";
                    } else {
                        echo "Error: Could not register the user.";
                    }
                }

            } catch (PDOException $e) {
                // Handle any errors during database connection or query execution
                echo "Error: " . $e->getMessage();
            }
        }
    }
?>
