<?php
require_once __DIR__ . '/config.php';
try {
  $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  ]);
  echo "DB OK — connected to ".DB_NAME;
} catch (Exception $e) {
  echo "DB CONNECT ERROR: " . $e->getMessage();
}
