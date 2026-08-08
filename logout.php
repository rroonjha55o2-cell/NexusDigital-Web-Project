<?php
// NexusDigital - Admin Logout Action
// Destroys active admin sessions and redirects to login screen
session_start();
session_destroy();
header("Location: admin_login.php");
exit();
?>
