<?php
session_start();
require 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../app/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectDB();
    $error = array();

    // Check if file was uploaded without errors
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
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
                $user_id = $_SESSION['id']; // Assuming you store user ID in session
                $upload_date = date('Y-m-d H:i:s');

                $stmt = $conn->prepare("INSERT INTO uploads (user_id, filename, filetype, filesize, upload_date) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("issss", $user_id, $filename, $filetype, $filesize, $upload_date);

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
        $error[] = "Error: " . uploadErrorMessage($_FILES["file"]["error"]);
    }

    $conn->close();

    if (!empty($error)) {
        $_SESSION['error'] = $error;
    }
}

// Redirect back to the upload page
header("Location: ../app/upload.php");
exit;

?>
