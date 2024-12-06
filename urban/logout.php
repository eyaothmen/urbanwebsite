<?php
session_start(); // Start the session
session_destroy(); // Destroy all session data
header("Location: urban.php?message=logged_out"); // Redirect to login page with a message
exit();
?>
