<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/registration-styles.css" />
    <!-- Link to your CSS -->
    <title>Registration Page</title>
  </head>
  <body>
    <div class="overlay"></div>
    <div class="container">
      <h2>Register</h2>
      <form action="../includes/register_user.php" method="post">
        <label>Username:
          <input type="text" name="username">
        </label>
        
        <label>Email:
          <input type="email" name="email">
        </label>

        <label>First Name:
          <input type="text" name="firstName">
        </label>

        <label>Last Name:
          <input type="text" name="lastName">
        </label>

        <label>Password:
          <input type="password" name="password">
        </label>

        <label>Age:
          <input type="number" name="age">
        </label>

        <label>Gender:</label>
        <select name="gender">
            <option disabled>Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>

        <button type="submit">Register</button>

        <p>Already have an account? <a href="login.php">Login here</a>.</p>
        <p><a href="../index.php">Home</a></p>
      </form>
    </div>
  </body>
</html>
