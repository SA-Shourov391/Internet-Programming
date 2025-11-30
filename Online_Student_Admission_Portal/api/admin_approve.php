<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') json_response(['error'=>'Invalid method'],405);
if (empty($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin','superadmin'])) json_response(['error'=>'Unauthorized'],401);

$student_id = intval($_POST['student_id'] ?? 0);
$action = $_POST['action'] ?? ''; // 'approve' or 'reject'
$comment = trim($_POST['comment'] ?? null);

if (!$student_id || !in_array($action,['approve','reject'])) json_response(['error'=>'Invalid data'],422);

$pdo = getPDO();
$pdo->beginTransaction();
try {
    $status = $action === 'approve' ? 'approved' : 'rejected';
    $stmt = $pdo->prepare("UPDATE students SET status = ? WHERE id = ?");
    $stmt->execute([$status, $student_id]);

    $log = $pdo->prepare("INSERT INTO approvals (student_id, approved_by, action, comment) VALUES (?,?,?,?)");
    $log->execute([$student_id, $_SESSION['user_id'], $action, $comment]);

    $pdo->commit();
    json_response(['success'=>true, 'message'=>"Student $status"]);
} catch(PDOException $e) {
    $pdo->rollBack();
    json_response(['error'=>$e->getMessage()],500);
}
