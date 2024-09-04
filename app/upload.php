<?php
session_start(); // Start the session
require_once '../config/config.php'; // Include the configuration file

// Check if the user is logged in by checking a session variable, for example, 'loggedin'.
// This 'loggedin' session variable should be set during a successful login in 'login.php'.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  // If the session variable is not set or is not true, redirect to login.php
  header("Location: login.php");
  exit; // Ensure no further code is executed
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_id']; // Assume user_id is stored in the session
    $uploadSuccess = handleFileUpload($userId); // Call the handleFileUpload function

    // Set success or error messages in the session
    if ($uploadSuccess) {
        $_SESSION['success'] = "File uploaded successfully.";
    } else {
        $_SESSION['error'] = ["File upload failed."];
    }

    // Redirect to the same page to display messages
    header("Location: upload.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
  <link rel="shortcut icon" href="../images/logo.png">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <header>
    <div class="logo">
      <img src="../images/logo.png" alt="">
      <h2>U<span class="danger">M</span>S</h2>
    </div>
    <div class="navbar">
      <a href="student_page.php">
        <span class="material-icons-sharp">home</span>
        <h3>Home</h3>
      </a>
      <a href="upload.php" class="active" onclick="timeTableAll()">
        <span class="material-icons-sharp">today</span>
        <h3>Upload</h3>
      </a>
      <a href="exam.php">
        <span class="material-icons-sharp">grid_view</span>
        <h3>Examination</h3>
      </a>
      <a href="password.php">
        <span class="material-icons-sharp">password</span>
        <h3>Change Password</h3>
      </a>
      <a href="logout.php">
        <span class="material-icons-sharp">logout</span>
        <h3>Logout</h3>
      </a>
    </div>
    <div id="profile-btn" style="display: none;">
      <span class="material-icons-sharp">person</span>
    </div>
    <div class="theme-toggler">
      <span class="material-icons-sharp active">light_mode</span>
      <span class="material-icons-sharp">dark_mode</span>
    </div>

  </header>

  <main style="margin: 0;">
    <div class="upload-container">
      <form action="upload.php" method="POST" enctype="multipart/form-data">
        <h2>Upload</h2>
        <p class="text-muted">Please upload your file</p>
        <?php
        // Display error messages
        if (isset($_SESSION['error'])) {
          foreach ($_SESSION['error'] as $error) {
            echo '<p class="error-message">' . htmlspecialchars($error) . '</p>';
          }
          unset($_SESSION['error']);
        }
        // Display success message
        if (isset($_SESSION['success'])) {
          echo '<p class="success-message">' . htmlspecialchars($_SESSION['success']) . '</p>';
          unset($_SESSION['success']);
        }
        ?>
        <div class="box">
          <p class="text-muted">Select file:</p>
          <input type="file" id="file" name="file" accept=".txt">
          <div class="button">
            <input type="submit" value="Upload" class="btn">
          </div>
        </div>
      </form>
    </div>
  </main>

</body>

<script src="../js/app.js"></script>

</html>
