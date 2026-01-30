<?php
session_start();
$total = 0;

if (!empty($_SESSION['cart'])) {
    $total = array_sum(array_column($_SESSION['cart'], 'qty'));
}

echo json_encode(['total' => $total]);
