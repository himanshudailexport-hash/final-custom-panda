<?php
session_start();
include "config/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: checkout.php");
    exit;
}

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    header("Location: cart.php");
    exit;
}

$name    = $_POST['name'];
$email   = $_POST['email'];
$phone   = $_POST['phone'];
$address = $_POST['address'];
$notes   = $_POST['notes'];

$shipping = 50;
$subtotal = 0;

foreach ($cart as $item) {
    $subtotal += $item['price'] * $item['qty'];
}

$total = $subtotal + $shipping;
$orderNumber = "NWC" . time();

/* INSERT ORDER */
$stmt = $conn->prepare("
    INSERT INTO orders 
    (order_number, name, email, phone, address, notes, subtotal, shipping, total)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "ssssssddd",
    $orderNumber,
    $name,
    $email,
    $phone,
    $address,
    $notes,
    $subtotal,
    $shipping,
    $total
);

$stmt->execute();
$order_id = $stmt->insert_id;

/* INSERT ORDER ITEMS */
$itemStmt = $conn->prepare("
    INSERT INTO order_items 
    (order_id, product_name, price, quantity)
    VALUES (?, ?, ?, ?)
");

foreach ($cart as $item) {
    $itemStmt->bind_param(
        "isdi",
        $order_id,
        $item['name'],
        $item['price'],
        $item['qty']
    );
    $itemStmt->execute();
}

/* CLEAR CART */
unset($_SESSION['cart']);

/* REDIRECT TO SUCCESS */
header("Location: order-success.php?order=$orderNumber");
exit;
