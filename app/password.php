<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  // If the session variable is not set or is not true, redirect to login.php
  header("Location: login.php");
  exit; // Ensure no further code is executed
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
      <a href="upload.php" onclick="timeTableAll()">
        <span class="material-icons-sharp">today</span>
        <h3>Upload</h3>
      </a>
      <a href="exam.php">
        <span class="material-icons-sharp">grid_view</span>
        <h3>Examination</h3>
      </a>
      <a href="password.php" class="active">
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

  <div class="change-password-container">
    <form action="">
      <h2>Create new password</h2>
      <p class="text-muted">Your new password must be different from previous used passwords.</p>
      <div class="box">
        <p class="text-muted">Current Password</p>
        <input type="password" id="currentpass">
      </div>
      <div class="box">
        <p class="text-muted">New Password</p>
        <input type="password" id="newpass">
      </div>
      <div class="box">
        <p class="text-muted">Confirm Password</p>
        <input type="password" id="confirmpass">
      </div>
      <div class="button">
        <input type="submit" value="Save" class="btn">
        <a href="student_page.php" class="text-muted">Cancel</a>
      </div>
    </form>
  </div>

</body>

<script src="../js/app.js"></script>

</html>
