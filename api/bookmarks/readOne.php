<?php
// 1) CORS preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    exit(0);
}

// 2) Only allow GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Allow: GET');
    http_response_code(405);
    exit(json_encode(['message'=>'Method not allowed']));
}

// 3) CORS headers for real response
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../db/Database.php';
include_once '../../models/Bookmark.php';

$db = (new Database())->connect();
$bm = new Bookmark($db);

if (!isset($_GET['id'])) {
    http_response_code(422);
    exit(json_encode(['message'=>'Missing id']));
}

$bm->setId((int)$_GET['id']);
if (!$bm->readOne()) {
    http_response_code(404);
    exit(json_encode(['message'=>'Not found']));
}

echo json_encode([
    'id'        => $bm->getId(),
    'url'       => $bm->getUrl(),
    'title'     => $bm->getTitle(),
    'dateAdded' => $bm->getDateAdded()
]);
?>
