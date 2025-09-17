<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Delete the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Redirect to login page
header('Location: login.php');
exit();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logout</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container">
    <div class="auth-container">
        <div class="auth-card">
            <h2><i class="fas fa-sign-out-alt"></i> Logging out...</h2>
            <p>You have been successfully logged out.</p>
            <p>Redirecting to login page...</p>
            <p>If you are not redirected, <a href="login.php">click here</a>.</p>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        window.location.href = 'login.php';
    }, 2000);
</script>
</body>
</html>