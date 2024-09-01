<?php

require '../config/config.php';  // Include the database configuration file
session_start();  // Start the session
$conn = connectDB();  // Connect to the database

if (isset($_POST['submit'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = $_POST['password'];
  $password2 = $_POST['password2'];
  $user_type = $_POST['role'];

  // Check if passwords match
  if ($password !== $password2) {
    $error[] = 'Passwords do not match';
  } else {

    // Check if username already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $error[] = 'Username already exists';
    } else {
      
      // Use prepared statements to insert the new user with plain text password
      $stmt = $conn->prepare("INSERT INTO users (username, email, password, user_type) VALUES (?, ?, ?, ?)");
      $stmt->bind_param('ssss', $username, $email, $password, $user_type);

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
  <title>Register</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #f5f5f5;
    }

    main {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 320px;
      text-align: center;
    }

    form div {
      margin-bottom: 15px;
      text-align: left;
    }

    label {
      display: block;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    select {
      width: calc(100% - 20px);
      padding: 8px 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      appearance: none;
      /* For better styling consistency across browsers */
      -webkit-appearance: none;
      /* For Safari */
      background-color: white;
      /* Background color to match input fields */
    }

    input[type="checkbox"] {
      margin-right: 5px;
    }

    button {
      width: 100%;
      padding: 10px;
      background-color: #7e57c2;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px;
    }

    button:hover {
      background-color: #6c49a1;
    }

    footer {
      margin-top: 10px;
      font-size: 14px;
      color: #666;
    }

    footer a {
      text-decoration: none;
      color: #7e57c2;
      font-weight: bold;
    }

    footer a:hover {
      text-decoration: underline;
    }

    .terms a {
      color: #7e57c2;
      text-decoration: none;
    }

    .terms a:hover {
      text-decoration: underline;
    }

    .error-msg {
      margin: 10px 0;
      display: block;
      color: #FF0000;
      border-radius: 5px;
      font-size: 20px;
      padding: 10px;
    }
  </style>
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
        <label for="role">Select Role:</label>
        <select name="role" id="role">
          <option value="user">User</option>
          <option value="admin">Admin</option>
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
