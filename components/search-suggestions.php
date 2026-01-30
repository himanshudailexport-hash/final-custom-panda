<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . "/../config/db.php";

$q = trim($_GET['q'] ?? '');

if (strlen($q) < 2) {
    echo json_encode([]);
    exit;
}

$sql = "
    SELECT id, name, img1
    FROM products
    WHERE name LIKE ?
       OR brand_name LIKE ?
       OR sku_id LIKE ?
    LIMIT 6
";

$stmt = $conn->prepare($sql);

$like = "%{$q}%";
$stmt->bind_param("sss", $like, $like, $like);
$stmt->execute();

$res = $stmt->get_result();

$data = [];
while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}

header("Content-Type: application/json");
echo json_encode($data);
