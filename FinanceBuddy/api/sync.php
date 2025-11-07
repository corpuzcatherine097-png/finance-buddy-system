<?php
header('Content-Type: application/json');
include '../db.php';
$raw = file_get_contents('php://input');
$data = json_decode($raw,true);
if (!$data || !isset($data['user_id']) || !is_array($data['transactions'])) {
  http_response_code(400); echo json_encode(['error'=>'bad request']); exit;
}
$uid = (int)$data['user_id'];
$resp=['inserted'=>0,'errors'=>[]];
foreach($data['transactions'] as $tx) {
  $typeCategory = $conn->real_escape_string($tx['category'] ?? 'Misc');
  $amount = (float)($tx['amount'] ?? 0);
  $note = $conn->real_escape_string($tx['note'] ?? '');
  $date = $conn->real_escape_string($tx['created_at'] ?? date('Y-m-d H:i:s'));
  $stmt = $conn->prepare("INSERT INTO expenses (user_id,category,amount,note,created_at,synced) VALUES (?,?,?,?,?,1)");
  $stmt->bind_param("isdss",$uid,$typeCategory,$amount,$note,$date);
  if ($stmt->execute()) $resp['inserted']++;
  else $resp['errors'][] = $conn->error;
}
echo json_encode($resp);
