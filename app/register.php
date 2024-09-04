<?php

require '../config/config.php';  // Include the database configuration file
session_start();  // Start the session
$conn = connectDB();  // Connect to the database

if (isset($_POST['submit'])) {
  // Get the form data
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = $_POST['password'];
  $password2 = $_POST['password2'];
  $user_type = $_POST['user_type'];

  // Check if passwords match
  if ($password !== $password2) {
    $error[] = 'Passwords do not match';
  } else {

    // Prepare and execute a SQL query to check if the username already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?"); // Prepare the SQL statement
    $stmt->bind_param('s', $username);  // Bind the username parameter
    $stmt->execute();  // Execute the prepared statement
    $result = $stmt->get_result();  // Get the result of the query

    // Check if the username already exists
    if ($result->num_rows > 0) {
      $error[] = 'Username already exists';
    } else {

      // Use prepared statements to insert the new user with plain text password
      $stmt = $conn->prepare("INSERT INTO users (username, password, email, user_type) VALUES (?, ?, ?, ?)");
      $stmt->bind_param('ssss', $username, $password, $email, $user_type);

      if ($stmt->execute()) {
        $_SESSION['username'] = $username;
        $_SESSION['user_type'] = $user_type;
        header('Location: login.php');  // Redirect to the login page
        exit();
      } else {
        $error[] = 'Registration failed. Please try again.';
      }
    }

    $stmt->close();
  }
}

$conn->close();  // Close the database connection

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../images/logo.png">
  <title>Register</title>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <main>
    <form action="<?php $_SERVER["PHP_SELF"] ?>" method="POST">
      <h1>Sign Up</h1>
      <?php
      if (isset($error)) {
        foreach ($error as $error) {
          echo '<span class="error-msg">' . $error . '</span>';
        }
      }
      ?>
      <div>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
      </div>
      <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email">
      </div>
      <div>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
      </div>
      <div>
        <label for="password2">Password Again:</label>
        <input type="password" name="password2" id="password2">
      </div>
      <div>
        <label for="user_type">Select Role:</label>
        <select name="user_type" id="user_type">
          <option value="user">User</option>
        </select>
      </div>
      <div class="terms">
        <label for="agree">
          <input type="checkbox" name="agree" id="agree" value="yes" /> I agree
          with the <a href="#" title="term of services">term of services</a>
        </label>

      </div>
      <button type="submit" id="submit" name="submit">Register</button>
      <footer>Already a member? <a href="login.php">Login here</a></footer>
    </form>
  </main>
</body>

</html>
