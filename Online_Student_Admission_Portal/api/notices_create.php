<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') json_response(['error'=>'Invalid method'],405);
if (empty($_SESSION['user_id'])) json_response(['error'=>'Unauthorized'],401);

$title = trim($_POST['title'] ?? '');
$body = trim($_POST['body'] ?? '');
$dept = trim($_POST['department'] ?? 'Global');

if (!$title || !$body) json_response(['error'=>'Missing fields'],422);

$pdo = getPDO();
$stmt = $pdo->prepare("INSERT INTO notices (title,body,department,created_by) VALUES (?,?,?,?)");
try {
    $stmt->execute([$title,$body,$dept,$_SESSION['user_id']]);
    json_response(['success'=>true, 'message'=>'Notice published']);
} catch(PDOException $e) {
    json_response(['error'=>$e->getMessage()],500);
}
