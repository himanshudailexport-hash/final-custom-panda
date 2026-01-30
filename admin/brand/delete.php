<?php
require_once "../../config/db.php";

if (!isset($_GET['id'])) {
    die("Brand ID missing");
}

$id = $_GET['id'];

// Delete brand
$stmt = $conn->prepare("DELETE FROM brands WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: all-brands.php?msg=deleted");
    exit;
} else {
    echo "Failed to delete brand ❌";
}
