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

$db   = (new Database())->connect();
$bm   = new Bookmark($db);
$stmt = $bm->readAll();

$outs = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $outs[] = [
        'id'        => (int)   $row['id'],  
        'url'       => (string)$row['url'],  
        'title'     => (string)$row['title'],
        'dateAdded' => (string)$row['date_added']
    ];
}

echo json_encode($outs);
?>
