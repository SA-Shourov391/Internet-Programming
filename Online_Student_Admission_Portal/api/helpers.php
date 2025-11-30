<?php
// helpers.php - small utilities

function json_response($data, $status=200){
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit;
}

function ensure_upload_dir() {
    require_once __DIR__ . '/config.php';
    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0755, true);
    }
}

// basic safe filename
function safe_filename($name){
    $name = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $name);
    return substr($name, 0, 200);
}
