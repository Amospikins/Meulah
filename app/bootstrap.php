<?php
ob_start();

// Load Config
require_once 'config/config.php';


// Load all top-level helper files (excluding subdirectories like validations)
foreach (glob(__DIR__ . '/helpers/*.php') as $helperFile) {
    require_once $helperFile;
}

// Load all validation files from the validations subfolder
foreach (glob(__DIR__ . '/helpers/validations/*.php') as $validationFile) {
    require_once $validationFile;
}

// Set Global Exception Handler
set_exception_handler(function ($e) {
    $trace = $e->getTrace();
    $controller = 'UnknownController';
    $method = 'UnknownMethod';

    // Extract Controller and Method Name from Stack Trace
    foreach ($trace as $frame) {
        if (isset($frame['class']) && isset($frame['function'])) {
            $controller = $frame['class'];
            $method = $frame['function'];
            break;
        }
    }

    if (APP_ENV === 'development') {
        echo "<h2 style='color: red;'>Application Error</h2>";
        echo "<p><strong>Message:</strong> " . $e->getMessage() . "</p>";
        echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
        echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
        echo "<p><strong>Controller:</strong> " . $controller . "</p>";
        echo "<p><strong>Method:</strong> " . $method . "</p>";
    } else {
        // Define Log Path
        $logDir = __DIR__ . '/logs';
        $logFile = $logDir . '/error.log';

        // Ensure Logs Directory Exists
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        // Ensure Log File Exists
        if (!file_exists($logFile)) {
            touch($logFile);
            chmod($logFile, 0666);
        }

        // Log the Error
        error_log("[" . date('Y-m-d H:i:s') . "] Error in {$controller}::{$method} - " . $e->getMessage() .
            " in " . $e->getFile() . " on line " . $e->getLine() . PHP_EOL, 
            3, $logFile
        );

        // Display a Generic Error Message
        echo "<h2>Something went wrong. Please try again later.</h2>";
    }
    exit;
});


// Autoload Core Libraries
spl_autoload_register(function ($className) {
    $file = __DIR__ . "/libraries/$className.php";
    if (file_exists($file)) {
        require_once $file;
    } else {
        if (APP_ENV === 'development') {
            echo "<h2 style='color: red;'>Application Error</h2>";
            echo "<p><strong>Message:</strong> Class '$className' not found in libraries. </p>";
            exit;
        }
        error_log("[" . date('Y-m-d H:i:s') . "] Class '$className' not found in libraries.", 3, __DIR__ . '/logs/error.log');
        http_response_code(500);
        echo "<h2>Something went wrong. Please contact support.</h2>";
        exit;
    }
});

  