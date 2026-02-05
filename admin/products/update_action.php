<?php
require_once "../../config/db.php";
header('Content-Type: application/json');

$response = ['status' => 'error', 'message' => 'Update failed'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $id = (int)$_POST['id'];

  $uploadDir = "../../uploads/products/";
  if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

  function uploadImg($key, $old, $dir) {
    if (!empty($_FILES[$key]['name'])) {
      $file = time().'_'.basename($_FILES[$key]['name']);
      move_uploaded_file($_FILES[$key]['tmp_name'], $dir.$file);
      return "uploads/products/".$file;
    }
    return $old;
  }

  $old = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

  $img1 = uploadImg('img1', $old['img1'], $uploadDir);
  $img2 = uploadImg('img2', $old['img2'], $uploadDir);
  $img3 = uploadImg('img3', $old['img3'], $uploadDir);
  $img4 = uploadImg('img4', $old['img4'], $uploadDir);

  $stmt = $conn->prepare("
    UPDATE products SET
    name=?, category_id=?, brand_name=?, price=?, discount_price=?, stock=?,
    sku_id=?, description=?, fabric=?,
    img1=?, img2=?, img3=?, img4=?
    WHERE id=?
  ");

  $stmt->bind_param(
    "sissdiissssssi",
    $_POST['name'],
    $_POST['category_id'],
    $_POST['brand_name'],
    $_POST['price'],
    $_POST['discount_price'],
    $_POST['stock'],
    $_POST['sku_id'],
    $_POST['description'],
    $_POST['fabric'],
    $img1, $img2, $img3, $img4,
    $id
  );

  if ($stmt->execute()) {
    $response = ['status' => 'success', 'message' => 'Product updated successfully'];
  }
}

echo json_encode($response);
