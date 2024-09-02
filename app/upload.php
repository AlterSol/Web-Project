<?php
session_start(); // Start the session

// Check if the user is logged in by checking a session variable, for example, 'loggedin'.
// This 'loggedin' session variable should be set during a successful login in 'login.php'.
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

<style>
  header {
    position: relative;
  }

  .upload-container {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 90vh;
  }

  .upload-container form {
    display: flex;
    flex-direction: column;
    justify-content: center;
    border-radius: var(--border-radius-2);
    padding: 3.5rem;
    background-color: var(--color-white);
    box-shadow: var(--box-shadow);
    width: 95%;
    max-width: 32rem;
  }

  .upload-container form:hover {
    box-shadow: none;
  }

  .upload-container form input[type=file] {
    border: none;
    outline: none;
    border: 1px solid var(--color-light);
    background: transparent;
    height: 2.5rem;
    /* Keep the increased height */
    width: 100%;
    padding: 0.4rem;
    /* Reduced padding */
    font-size: 1rem;
    /* Keep the increased font size */
    margin-top: 0;
    /* Removed the margin-top */
  }

  .upload-container form .box {
    padding: 0;
    /* Removed padding to bring items closer */
    margin-bottom: 0.5rem;
    /* Added margin for a little space after the box */
  }

  .upload-container form .box p {
    line-height: 1.5;
    /* Reduced line height */
    font-size: 1.1rem;
    /* Keep the increased font size */
    font-weight: 500;
    /* Keep the font weight */
    margin-bottom: 0.2rem;
    /* Reduced margin to bring the label closer to the input */
  }

  .upload-container form h2+p {
    margin: .4rem 0 1.2rem 0;
  }

  .btn {
    background: none;
    border: none;
    border: 2px solid var(--color-primary) !important;
    border-radius: var(--border-radius-1);
    padding: .5rem 1rem;
    color: var(--color-white);
    background-color: var(--color-primary);
    cursor: pointer;
    margin: 1rem 1.5rem 1rem 0;
    margin-top: 1.5rem;
  }

  .btn:hover {
    color: var(--color-primary);
    background-color: transparent;
  }
</style>

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
      <form action="../config/upload_func.php" enctype="multipart/form-data" method="POST">
        <h2>Upload</h2>
        <p class="text-muted">Please upload your file</p>
        <div class="box">
          <p class="text-muted">Select file:</p>
          <input type="file" id="file">
          <div class="button">
            <input type="submit" value="Upload" class="btn">
          </div>
      </form>
    </div>
  </main>

</body>

<script src="../js/timeTable.js"></script>
<script src="../js/app.js"></script>

</html>
