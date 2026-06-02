<?php
session_start(); // Start the session to access it
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session entirely

// Redirect back to the login page
header("Location: LoginPage.php");
exit();
?>