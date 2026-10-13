<?php
session_start();

// Hapus semua data session
$_SESSION = [];

// Hapus session cookie di browser
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

// Hapus cookie "remember me"
if (isset($_COOKIE['user_email'])) {
    setcookie('user_email', '', time() - 3600, '/');
}

// Destroy session di server
session_destroy();

// Redirect ke login
header('Location: login.php?msg=logged_out');
exit;