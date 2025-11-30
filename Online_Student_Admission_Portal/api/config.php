<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// config.php - DB credentials and site constants
// Edit these to match your local setup

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'uu_portal');
define('DB_USER', 'root');
define('DB_PASS', '');

define('UPLOAD_DIR', __DIR__ . '/uploads'); // ensure writable
define('BASE_URL', '/Online_Student_Admission_Portal'); // adjust if necessary
