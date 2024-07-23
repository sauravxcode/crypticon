<?php
require_once 'config.php';

session_start();

// Unset all session variables
$_SESSION = array();

$sessionID = session_id();
mysqli_query($conn, "DELETE FROM UserSessions WHERE SessionID = '$sessionID'");


// Destroy the session
session_destroy();

// Clear session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect to login page
header("Location: ../index.php");
exit();
?>
