<?php

session_start();

// Clear session data and redirect to login page
session_unset();  // Unset all session variables
session_destroy();  // Destroy the session
header('Location: login.php');  // Redirect to the login page

exit;  // Ensure no further code is executed

?>
