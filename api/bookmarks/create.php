<?php
// 1) Handle CORS preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    exit(0);
}

// 2) Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    echo json_encode(['message'=>'Method not allowed']);
    return;
}

// 3) And still send CORS on every real response
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

include_once '../../db/Database.php';
include_once '../../models/Bookmark.php';

$database = new Database();
$db       = $database->connect();

$bm = new Bookmark($db);
$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['url'], $data['title'])) {
    http_response_code(422);
    echo json_encode(['message'=>'Missing url or title']);
    return;
}

$bm->setUrl($data['url']);
$bm->setTitle($data['title']);

if ($bm->create()) {
    echo json_encode(['message'=>'Bookmark created']);
} else {
    http_response_code(500);
    echo json_encode(['message'=>'Create failed']);
}
?>
