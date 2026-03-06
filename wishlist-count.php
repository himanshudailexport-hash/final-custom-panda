<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/config/db.php';

$total = 0;

/*  Logged-in user → DB wishlist */
if (isset($_SESSION['user_id'])) {

    $stmt = $conn->prepare("
        SELECT COUNT(*) AS total 
        FROM wishlists 
        WHERE user_id = ?
    ");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    $total = (int)$result['total'];

/*  Guest user → session wishlist */
} else {

    if (!empty($_SESSION['wishlist'])) {
        $total = count($_SESSION['wishlist']);
    }
}

echo json_encode([
    'total' => $total
]);