<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$id = $data['id'];

switch ($data['action']) {

    case 'add':
        $qty = $data['qty'] ?? 1;
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$id] = [
                'name'  => $data['name'],
                'price' => $data['price'],
                'qty'   => $qty,
                'image' => $data['image']
            ];
        }
        break;

    case 'plus':
        $_SESSION['cart'][$id]['qty']++;
        break;

    case 'minus':
        $_SESSION['cart'][$id]['qty']--;
        if ($_SESSION['cart'][$id]['qty'] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
        break;

    case 'remove':
        unset($_SESSION['cart'][$id]);
        break;
}

$total = array_sum(array_column($_SESSION['cart'], 'qty'));
echo json_encode(['total' => $total]);


