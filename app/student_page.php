<?php

session_start(); // Start the session
require '../config/config.php'; // Include the database configuration file
$conn = connectDB();  // Connect to the database

// Check if the user is logged in 
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  // If the session variable is not set or is not true, redirect to login.php
  header("Location: login.php");
  exit; // Ensure no further code is executed
}

// Get the username and email from the database
$username = $_SESSION['username'];  // Assume 'username' is stored in session
$stmt = $conn->prepare("SELECT id, username, email FROM users WHERE username = ?");
$stmt->bind_param("s", $username); // Bind the username parameter
$stmt->execute(); // Execute the prepared statement
$result = $stmt->get_result(); // Get the result of the query

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();  // Fetch the user's data

  // Get the username and email from the result
  $username = $row['username'];
  $email = $row['email'];
  $user_id = $row['id'];

  // Capitalize the first letter of the username
  $username = ucfirst($username);
} else {
  echo "User not found.";
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
  <link rel="shortcut icon" href="../images/logo.png">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <header>
    <div class="logo" title="University Management System">
      <img src="../images/logo.png" alt="">
      <h2>U<span class="danger">M</span>S</h2>
    </div>
    <div class="navbar">
      <a href="student_page.php" class="active">
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
      <a href="password.php">
        <span class="material-icons-sharp">password</span>
        <h3>Change Password</h3>
      </a>
      <a href="logout.php">
        <span class="material-icons-sharp">logout</span>
        <h3>Logout</h3>
      </a>
    </div>
    <div id="profile-btn">
      <span class="material-icons-sharp">person</span>
    </div>
    <div class="theme-toggler">
      <span class="material-icons-sharp active">light_mode</span>
      <span class="material-icons-sharp">dark_mode</span>
    </div>

  </header>
  <div class="container">
    <aside>
      <!-- Display user's profile information -->
      <div class="profile">
        <div class="top">
          <div class="profile-photo">
            <img src="../images/profile-1.jpg" alt="">
          </div>
          <div class="info">
            <!-- Use htmlspecialchars to prevent XSS attacks -->
            <p>Hey, <b><?php echo htmlspecialchars($username); ?></b> </p>
            <small class="text-muted">ID: <?php echo htmlspecialchars($user_id); ?></small>
          </div>
        </div>
        <div class="about">
          <h5>Email</h5>
          <p><?php echo htmlspecialchars($email); ?></p>
        </div>
      </div>
    </aside>

    <main>
      <h1>Attendance</h1>
      <div class="subjects">
        <div class="eg">
          <span class="material-icons-sharp">architecture</span>
          <h3>Engineering Graphics</h3>
          <h2>12/14</h2>
          <div class="progress">
            <svg>
              <circle cx="38" cy="38" r="36"></circle>
            </svg>
            <div class="number">
              <p>86%</p>
            </div>
          </div>
          <small class="text-muted">Last 24 Hours</small>
        </div>
        <div class="mth">
          <span class="material-icons-sharp">functions</span>
          <h3>Mathematical Engineering</h3>
          <h2>27/29</h2>
          <div class="progress">
            <svg>
              <circle cx="38" cy="38" r="36"></circle>
            </svg>
            <div class="number">
              <p>93%</p>
            </div>
          </div>
          <small class="text-muted">Last 24 Hours</small>
        </div>
        <div class="cs">
          <span class="material-icons-sharp">computer</span>
          <h3>Computer Architecture</h3>
          <h2>27/30</h2>
          <div class="progress">
            <svg>
              <circle cx="38" cy="38" r="36"></circle>
            </svg>
            <div class="number">
              <p>81%</p>
            </div>
          </div>
          <small class="text-muted">Last 24 Hours</small>
        </div>
        <div class="cg">
          <span class="material-icons-sharp">dns</span>
          <h3>Database Management</h3>
          <h2>24/25</h2>
          <div class="progress">
            <svg>
              <circle cx="38" cy="38" r="36"></circle>
            </svg>
            <div class="number">
              <p>96%</p>
            </div>
          </div>
          <small class="text-muted">Last 24 Hours</small>
        </div>
        <div class="net">
          <span class="material-icons-sharp">router</span>
          <h3>Network Security</h3>
          <h2>25/27</h2>
          <div class="progress">
            <svg>
              <circle cx="38" cy="38" r="36"></circle>
            </svg>
            <div class="number">
              <p>92%</p>
            </div>
          </div>
          <small class="text-muted">Last 24 Hours</small>
        </div>
      </div>

      <div class="timetable" id="timetable">
        <div>
          <span id="prevDay">&lt;</span>
          <h2>Today's Timetable</h2>
          <span id="nextDay">&gt;</span>
        </div>
        <span class="closeBtn" onclick="timeTableAll()">X</span>
        <table>
          <thead>
            <tr>
              <th>Time</th>
              <th>Room No.</th>
              <th>Subject</th>
              <th></th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </main>

    <div class="right">
      <div class="announcements">
        <h2>Announcements</h2>
        <div class="updates">
          <div class="message">
            <p> <b>Academic</b> Summer training internship with Live Projects.</p>
            <small class="text-muted">2 Minutes Ago</small>
          </div>
          <div class="message">
            <p> <b>Co-curricular</b> Global internship oportunity by Student organization.</p>
            <small class="text-muted">10 Minutes Ago</small>
          </div>
          <div class="message">
            <p> <b>Examination</b> Instructions for Mid Term Examination.</p>
            <small class="text-muted">Yesterday</small>
          </div>
        </div>
      </div>

      <div class="leaves">
        <h2>Teachers on leave</h2>
        <div class="teacher">
          <div class="profile-photo"><img src="../images/profile-2.jpeg" alt=""></div>
          <div class="info">
            <h3>The Professor</h3>
            <small class="text-muted">Full Day</small>
          </div>
        </div>
        <div class="teacher">
          <div class="profile-photo"><img src="../images/profile-3.jpg" alt=""></div>
          <div class="info">
            <h3>Lisa Manobal</h3>
            <small class="text-muted">Half Day</small>
          </div>
        </div>
        <div class="teacher">
          <div class="profile-photo"><img src="../images/profile-4.jpg" alt=""></div>
          <div class="info">
            <h3>Himanshu Jindal</h3>
            <small class="text-muted">Full Day</small>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="../js/timeTable.js"></script>
  <script src="../js/app.js"></script>
</body>

</html>
