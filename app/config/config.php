<?php
define('SESSION_NAMESPACE', 'settlematter_');
define('SESSION_USER_KEY', SESSION_NAMESPACE . 'user_id');

session_name('SETTLEMATTER_SESSION'); 
session_start();

// Load environment variables if available
$envFile = dirname(__DIR__) . '/.env';
if (file_exists($envFile)) {
    $env = parse_ini_file($envFile);
} else {
    $env = [];
}

// App Environment (default to production if not set)
define('APP_ENV', $env['APP_ENV'] ?? 'production');

// Database Configuration
define('DB_HOST', $env['DB_HOST']);
define('DB_USER', $env['DB_USER']);
define('DB_PASS', $env['DB_PASS']);
define('DB_NAME', $env['DB_NAME']);

//App name
define('SITENAME', $env['APP_NAME'] ?? '');

// SMTP Configuration from .env
define('SMTP_HOST', $env['SMTP_HOST'] ?? 'smtp.gmail.com');
define('SMTP_USER', $env['SMTP_USER'] ?? '');
define('SMTP_PASS', $env['SMTP_PASS'] ?? '');
define('SMTP_PORT', $env['SMTP_PORT'] ?? 587);
define('SMTP_FROM_EMAIL', $env['SMTP_FROM_EMAIL'] ?? 'no-reply@example.com');
define('SMTP_FROM_NAME', $env['SMTP_FROM_NAME'] ?? $env['APP_NAME']);


// App Root Directory
define('APPROOT', dirname(__DIR__));

// Dynamically Set URL Root
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptName = str_replace('/public', '', dirname($_SERVER['SCRIPT_NAME']));
define('URLROOT', "{$protocol}://{$host}{$scriptName}");

// Error Reporting Based on Environment
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}