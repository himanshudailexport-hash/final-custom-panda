<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function auth_check() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /auth/login.php");
        exit;
    }
}
