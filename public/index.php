<?php

// Require Composer autoloader if available
$vendorAutoload = '../app/helpers/vendor/autoload.php';
if (file_exists($vendorAutoload)) {
    require_once $vendorAutoload;
}

// Bootstrap the framework
require_once '../app/bootstrap.php';

// Check if Core class exists before initializing
if (class_exists('Core')) {
    $init = new Core;
} else {
    die('Fatal Error: Core framework initialization failed.');
}