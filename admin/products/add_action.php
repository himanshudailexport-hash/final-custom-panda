<?php
include "../../config/db.php";
header('Content-Type: application/json');

$response = ['status' => 'error', 'message' => 'Something went wrong'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name           = $_POST['name'] ?? '';
    $category_id    = (int)$_POST['category_id'];
    $price          = $_POST['price'];
    $stock          = $_POST['stock'];
    $sku_id         = $_POST['sku_id'];
    $discount_price = $_POST['discount_price'];
    $color          = $_POST['color'];
    $size           = $_POST['size'];
    $description    = $_POST['description'];
    $net_quantity   = $_POST['net_quantity'];
    $fabric         = $_POST['fabric'];
    $total_amount   = $_POST['total_amount'];
    $rating     = $_POST['rating'];

    $new_arrivals = $_POST['new_arrivals'];
    $best_sales   = $_POST['best_sales'];
    $trending     = $_POST['trending'];

    $brand_name = $_POST['brand_name'];

    /* UPLOAD */
    $uploadDir = "../../uploads/products/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    function uploadImg($key, $dir) {
        if (!empty($_FILES[$key]['name'])) {
            $path = $dir . time() . '_' . basename($_FILES[$key]['name']);
            move_uploaded_file($_FILES[$key]['tmp_name'], $path);
            return $path;
        }
        return null;
    }

    $img1 = uploadImg('img1', $uploadDir);
    $img2 = uploadImg('img2', $uploadDir);
    $img3 = uploadImg('img3', $uploadDir);
    $img4 = uploadImg('img4', $uploadDir);

    $stmt = $conn->prepare("
        INSERT INTO products 
        (name, category_id, price, stock, discount_price, sku_id, color, size, description,
         net_quantity, fabric, total_amount,
         new_arrivals, best_sales, trending,
         brand_name, rating,
         img1, img2, img3, img4)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
    ");

    $stmt->bind_param(
        "siiiissssisdiiisdssss",
        $name,
        $category_id,
        $price,
        $stock,
        $discount_price,
        $sku_id,
        $color,
        $size,
        $description,
        $net_quantity,
        $fabric,
        $total_amount,
        $new_arrivals,
        $best_sales,
        $trending,
        $brand_name,
        $rating,
        $img1,
        $img2,
        $img3,
        $img4
    );

    if ($stmt->execute()) {
        $response = [
            'status' => 'success',
            'message' => 'Product added successfully'
        ];
    }
}

echo json_encode($response);
