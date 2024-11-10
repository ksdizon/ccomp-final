<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/login-styles.css" />
    <title>Login Page</title>
</head>
<body>
    <div class="overlay"></div>
    <div class="container">
        <h2>Login to The Imperium</h2>

        <?php
        // Check if an error parameter is present in the URL
        if (isset($_GET['error']) && $_GET['error'] === 'wrong_credentials') {
            echo "<p style='color: red;'>Wrong credentials</p>"; // Display the error message
        }
        ?>

        <form action="../includes/login_user.php" method="post">
            <input type="text" id="username" name="username" required placeholder="Username" />
            <input type="password" id="password" name="password" required placeholder="Password" />
            <button type="submit">Enter the Imperium</button>
        </form>
        <p>Not yet recruited? <a href="register.php">Join the ranks</a>.</p>
        <p><a href="../index.php">Home</a></p>
    </div>
</body>
</html>