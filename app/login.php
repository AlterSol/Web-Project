<?php

require '../config/config.php';  // Include the database configuration file
session_start();  // Start the session
$conn = connectDB();  // Connect to the database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Check and get the login information from the form
  $username = isset($_POST['username']) ? $_POST['username'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';

  // Check if the required fields are not empty
  if (!empty($username) && !empty($password)) {

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);  // 's' indicates a string parameter
    $stmt->execute(); // Execute the prepared statement
    $result = $stmt->get_result(); // Get the query result

    if ($result->num_rows > 0) {

      // Fetch the user data from the result set
      $row = $result->fetch_assoc();

      if ($password == $row['password']) {
        // Set the session variables and redirect to the appropriate page based on the user type
        $_SESSION["username"] = $username;
        $_SESSION['loggedin'] = true; // Set the logged-in status to true
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];

        if ($row["user_type"] == "user") {
          // Redirect to student page
          header("Location: student_page.php");
          exit;
        } elseif ($row["user_type"] == "admin") {
          // Redirect to admin page
          header("Location: admin_page.php");
          exit;
        }
      } else {
        $error[] = "Invalid password";
        exit;
      }
    } else {
      $error[] = "User not found";
      exit;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../images/logo.png">
  <title>Login</title>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <main>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
      <h1>Login</h1>
      <?php
      if (isset($error)) {
        foreach ($error as $error) {
          echo '<span class="error-msg">' . $error . '</span>';
        }
      }
      ?>
      <div>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" placeholder="Enter username">
      </div>
      <div>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Enter password">
      </div>
      <section>
        <button type="submit" name="submit" id="submit">Login</button>
        <div class="register-section">
          Don't have an account? <a href="register.php">Register</a> now
        </div>
      </section>
    </form>
  </main>
</body>

</html>
