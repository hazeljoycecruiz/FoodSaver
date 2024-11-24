<?php
session_start(); // Start the session

// Destroy the session
session_unset();
session_destroy();

// Redirect to the login page
header("Location: index_login.php");
exit();
?>
