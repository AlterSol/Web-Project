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
        $_SESSION['loggedin'] = true; // This 'loggedin' session variable should be set during a successful login in 'login.php'.
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
    width: 300px;
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
input[type="password"],
input[type="email"],
select {
    width: calc(100% - 20px);
    padding: 8px 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    appearance: none;
    -webkit-appearance: none;
    background-color: white;
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
