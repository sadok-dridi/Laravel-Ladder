<?php
session_start();
require_once 'functions.php'; // This includes config.php automatically

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    redirect_to_login();
}

// Get current user ID
$current_user_id = $_SESSION['user_id'];
?>