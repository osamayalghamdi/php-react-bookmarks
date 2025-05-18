<?php
// 1) CORS preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    exit(0);
}

// 2) Only allow DELETE
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    header('Allow: DELETE');
    http_response_code(405);
    exit(json_encode(['message'=>'Method not allowed']));
}

// 3) CORS headers for real response
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../db/Database.php';
include_once '../../models/Bookmark.php';

$data = json_decode(file_get_contents('php://input'), true);
if (empty($data['id'])) {
    http_response_code(422);
    exit(json_encode(['message'=>'Missing id']));
}

$db = (new Database())->connect();
$bm = new Bookmark($db);
$bm->setId((int)$data['id']);

if ($bm->delete()) {
    echo json_encode(['message'=>'Bookmark deleted']);
} else {
    http_response_code(500);
    echo json_encode(['message'=>'Delete failed']);
}
?>
