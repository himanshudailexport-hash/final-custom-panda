<?php
session_start();
header('Content-Type: application/json');
require_once "config/db.php";

$data = json_decode(file_get_contents("php://input"), true);
$productId = (int)($data['product_id'] ?? 0);

if (!$productId) {
    echo json_encode(["error" => true]);
    exit;
}

$userId = $_SESSION['user_id'] ?? null;

/* LOGGED-IN USER */
if ($userId) {

    $check = $conn->prepare("
        SELECT id FROM wishlists WHERE user_id=? AND product_id=?
    ");
    $check->bind_param("ii", $userId, $productId);
    $check->execute();
    $exists = $check->get_result()->num_rows;

    if ($exists) {
        $del = $conn->prepare("
            DELETE FROM wishlists WHERE user_id=? AND product_id=?
        ");
        $del->bind_param("ii", $userId, $productId);
        $del->execute();

        echo json_encode(["added" => false]);
        exit;
    } else {
        $ins = $conn->prepare("
            INSERT INTO wishlists (user_id, product_id)
            VALUES (?,?)
        ");
        $ins->bind_param("ii", $userId, $productId);
        $ins->execute();

        echo json_encode(["added" => true]);
        exit;
    }
}

/* GUEST USER */
else {
    $_SESSION['wishlist'] ??= [];

    if (isset($_SESSION['wishlist'][$productId])) {
        unset($_SESSION['wishlist'][$productId]);
        echo json_encode(["added" => false]);
    } else {
        $_SESSION['wishlist'][$productId] = true;
        echo json_encode(["added" => true]);
    }
}