<?php
// includes/functions.php
require_once 'config.php';

/**
 * Generate absolute URL
 */
function url($path = '') {
    return BASE_URL . $path;
}

/**
 * Redirect to specified path
 */
function redirect($path) {
    header('Location: ' . url($path));
    exit();
}

/**
 * Get current URL with query string
 */
function current_url() {
    return url($_SERVER['REQUEST_URI']);
}

/**
 * Redirect to login with return URL
 */
function redirect_to_login() {
    $return_url = urlencode(current_url());
    redirect('/auth/login.php?redirect=' . $return_url);
}

/**
 * Asset URL for CSS, JS, images
 */
function asset($path) {
    return ASSETS_URL . $path;
}
?>