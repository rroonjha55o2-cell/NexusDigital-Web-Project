<?php
// NexusDigital - Enterprise Admin Logout Action Handler
session_start();

// 1. Unset all session superglobal variables
$_SESSION = array();

// 2. Destroy session cookie if present in browser
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

// 3. Destroy session storage on server
session_destroy();

// 4. Safe redirect back to login portal
header("Location: admin_login.php?logout=success");
exit();
?>
