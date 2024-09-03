<?php

// Connect to the database function
function connectDB() {
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

// Upload error message function
function uploadErrorMessage($error_code) {
  switch ($error_code) {
    case UPLOAD_ERR_INI_SIZE:
      return "The uploaded file exceeds the upload_max_filesize directive in php.ini";
    case UPLOAD_ERR_FORM_SIZE:
      return "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
    case UPLOAD_ERR_PARTIAL:
      return "The uploaded file was only partially uploaded";
    case UPLOAD_ERR_NO_FILE:
      return "No file was uploaded";
    case UPLOAD_ERR_NO_TMP_DIR:
      return "Missing a temporary folder";
    case UPLOAD_ERR_CANT_WRITE:
      return "Failed to write file to disk";
    case UPLOAD_ERR_EXTENSION:
      return "File upload stopped by extension";
    default:
      return "Unknown upload error";
  }
}

?>
