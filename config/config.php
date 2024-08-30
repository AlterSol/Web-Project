<?php

// Improved database connection function with error handling
function connectDB()
{
  // Database connection parameters
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "auth";

  // Create a new MySQLi object-oriented connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check for a successful connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);  // Exit and display the error message if connection fails
  }

  return $conn;  // Return the connection object
}
