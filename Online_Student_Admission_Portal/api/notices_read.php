<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';

$pdo = getPDO();

$dept = $_GET['department'] ?? null;
$search = $_GET['q'] ?? null;

$sql = "SELECT n.*, u.name as author FROM notices n LEFT JOIN users u ON n.created_by = u.id WHERE n.status = 'active'";
$params = [];

if ($dept && $dept !== 'all') {
    $sql .= " AND n.department = ?";
    $params[] = $dept;
}
if ($search) {
    $sql .= " AND (n.title LIKE ? OR n.body LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}
$sql .= " ORDER BY n.created_at DESC LIMIT 200";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();

json_response(['data'=>$rows]);
