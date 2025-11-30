<?php
require_once 'db.php';
$username = 'admin';
$name = 'Admin';
$email = 'admin@uu.edu.bd';
$pass = 'Admin@123'; // change to secure
$hash = password_hash($pass, PASSWORD_DEFAULT);

$pdo = getPDO();
$stmt = $pdo->prepare("INSERT INTO users (username,name,email,password_hash,role) VALUES (?,?,?,?, 'superadmin')");
try {
    $stmt->execute([$username,$name,$email,$hash]);
    echo "Admin created. Username: $username, Password: $pass";
} catch(Exception $e){
    echo "Error: " . $e->getMessage();
}
