<?php
require_once "../../config/db.php";

if (!isset($_GET['id'])) {
    die("Category ID missing");
}

$id = $_GET['id'];


$stmt = $conn->prepare("SELECT img FROM categories WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$category = $result->fetch_assoc();

if (!$category) {
    die("Category not found");
}


if (!empty($category['img'])) {
    $imagePath = "../../" . $category['img'];  
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}


$stmt = $conn->prepare("DELETE FROM categories WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: all-categories.php?msg=deleted");
    exit;
} else {
    echo "Failed to delete category ❌";
}
