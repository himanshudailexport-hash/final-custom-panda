<?php
require_once "../../config/db.php";

if (!isset($_GET['id'])) {
    die("Product ID missing");
}

$id = $_GET['id'];

// Fetch product images first
$stmt = $conn->prepare("SELECT img1, img2, img3, img4 FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found");
}

// Delete image files
$images = [$product['img1'], $product['img2'], $product['img3'], $product['img4']];
foreach ($images as $img) {
    if (!empty($img) && file_exists("../../" . $img)) {
        unlink("../../" . $img);
    }
}

// Delete product record
$stmt = $conn->prepare("DELETE FROM products WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: products_list.php?msg=deleted");
    exit;
} else {
    echo "Failed to delete product ❌";
}
?>
