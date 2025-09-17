<?php
// includes/config.php

// Application Base Path (adjust this according to your project structure)
define('APP_BASE_PATH', '/LaravelLadder/learning/taskManager');

// Server Protocol
define('APP_PROTOCOL', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");

// Server Host
define('APP_HOST', $_SERVER['HTTP_HOST']);

// Full Base URL
define('BASE_URL', APP_PROTOCOL . '://' . APP_HOST . APP_BASE_PATH);

// Assets URL (for CSS, JS, images)
define('ASSETS_URL', BASE_URL . '/assets');
?>