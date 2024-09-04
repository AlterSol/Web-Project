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

// Handle file upload function
function handleFileUpload($userId) {
    $conn = connectDB();  // Connect to the database
    $error = array(); // Initialize an empty array to store error messages

    // Check if file was uploaded without errors
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
      // Get the file information
        $filename = $_FILES["file"]["name"];
        $filetype = $_FILES["file"]["type"];
        $filesize = $_FILES["file"]["size"];

        // Verify file extension
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if ($ext !== "txt") {
            $error[] = "Error: Only .txt files are allowed.";
        }

        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if ($filesize > $maxsize) {
            $error[] = "Error: File size is larger than the allowed limit (5MB).";
        }

        // Verify MIME type of the file
        if ($filetype !== "text/plain") {
            $error[] = "Error: Only plain text files are allowed.";
        }

        if (empty($error)) {
            $upload_path = "../uploads/" . $filename;

            // Check whether file exists before uploading it
            if (file_exists($upload_path)) {
                $error[] = $filename . " already exists.";
            } elseif (move_uploaded_file($_FILES["file"]["tmp_name"], $upload_path)) {
              // File uploaded successfully, now insert the file info into the database
                $upload_date = date('Y-m-d H:i:s');
              // Prepare the SQL statement to insert the file info into the database
                $stmt = $conn->prepare("INSERT INTO uploads (user_id, filename, filetype, filesize, upload_date) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("issss", $userId, $filename, $filetype, $filesize, $upload_date);

                // Execute the SQL statement
                if ($stmt->execute()) {
                    $_SESSION['success'] = "Your file was uploaded successfully.";
                } else {
                    $error[] = "Error: There was a problem uploading your file. Please try again.";
                }
                $stmt->close();
            } else {
                $error[] = "Error: There was a problem uploading your file. Please try again.";
            }
        }
    } else {
        $error[] = "Error: " . uploadErrorMessage($_FILES["file"]["error"]); // Add the error message to the error array
    }

    $conn->close();

    // If there are any errors, set the error message in the session and return false
    if (!empty($error)) {
        $_SESSION['error'] = $error;
        return false;
    }
    return true; // Return true if the file was uploaded successfully
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
