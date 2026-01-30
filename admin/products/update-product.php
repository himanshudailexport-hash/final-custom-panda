<?php
require_once "../../config/db.php";

if (!isset($_GET['id'])) {
    die("Product ID missing");
}

$id = $_GET['id'];

// Fetch product
$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    die("Product not found");
}

$msg = "";

// Update logic
if (isset($_POST['update'])) {

    $name           = $_POST['name'];
    $category_id       = $_POST['category_id'];
    $price          = $_POST['price'];
    $stock          = $_POST['stock'];
    $discount_price = $_POST['discount_price'];
    $sku_id         = $_POST['sku_id'];
    $color          = $_POST['color'];
    $size           = $_POST['size'];
    $description    = $_POST['description'];
    $net_quantity   = $_POST['net_quantity'];
    $fabric         = $_POST['fabric'];
    $total_amount   = $_POST['total_amount'];

    $new_arrivals   = $_POST['new_arrivals'];
    $best_sales     = $_POST['best_sales'];
    $trending       = $_POST['trending'];

    $brand_name     = $_POST['brand_name'];
    $rating         = $_POST['rating'];

    // Upload dir (ROOT uploads)
    $uploadDir = "../../uploads/products/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    function uploadImg($field, $old, $dir) {
        if (!empty($_FILES[$field]['name'])) {
            $path = $dir . time() . '_' . basename($_FILES[$field]['name']);
            move_uploaded_file($_FILES[$field]['tmp_name'], $path);
            return str_replace("../../", "", $path);
        }
        return $old;
    }

    $img1 = uploadImg('img1', $product['img1'], $uploadDir);
    $img2 = uploadImg('img2', $product['img2'], $uploadDir);
    $img3 = uploadImg('img3', $product['img3'], $uploadDir);
    $img4 = uploadImg('img4', $product['img4'], $uploadDir);

    $stmt = $conn->prepare("
        UPDATE products SET
        name=?, category=?, price=?, stock=?, discount_price=?, sku_id=?, color=?, size=?, description=?,
        net_quantity=?, fabric=?, total_amount=?, new_arrivals=?, best_sales=?, trending=?,
        brand_name=?, rating=?,
        img1=?, img2=?, img3=?, img4=?
        WHERE id=?
    ");

    

    $stmt->bind_param(
    "ssiiissssisdiiisdssssi",
    $name,
    $category,
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
    $img4,
    $id
);


    if ($stmt->execute()) {
        $msg = "Product updated successfully ✅";
    } else {
        $msg = "Update failed ❌";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>

<h2>Edit Product</h2>
<p style="color:green;"><?php echo $msg; ?></p>

<form method="post" enctype="multipart/form-data">

<input type="text" name="name" value="<?php echo $product['name']; ?>" required><br><br>
<input type="text" name="category" value="<?php echo $product['category']; ?>"><br><br>

<input type="number" name="price" value="<?php echo $product['price']; ?>"><br><br>
<input type="number" name="discount_price" value="<?php echo $product['discount_price']; ?>"><br><br>
<input type="number" name="stock" value="<?php echo $product['stock']; ?>"><br><br>

<input type="text" name="sku_id" value="<?php echo $product['sku_id']; ?>"><br><br>
<input type="text" name="color" value="<?php echo $product['color']; ?>"><br><br>
<input type="text" name="size" value="<?php echo $product['size']; ?>"><br><br>

<textarea name="description"><?php echo $product['description']; ?></textarea><br><br>
<input type="number" name="net_quantity" value="<?php echo $product['net_quantity']; ?>"><br><br>

<textarea name="fabric"><?php echo $product['fabric']; ?></textarea><br><br>
<input type="text" name="brand_name" value="<?php echo $product['brand_name']; ?>"><br><br>

<input type="number" step="0.1" name="rating" value="<?php echo $product['rating']; ?>"><br><br>
<input type="number" step="0.01" name="total_amount" value="<?php echo $product['total_amount']; ?>"><br><br>

<select name="new_arrivals">
    <option value="1" <?php if($product['new_arrivals']==1) echo "selected"; ?>>New Arrival - Yes</option>
    <option value="0" <?php if($product['new_arrivals']==0) echo "selected"; ?>>New Arrival - No</option>
</select><br><br>

<select name="best_sales">
    <option value="1" <?php if($product['best_sales']==1) echo "selected"; ?>>Best Sales - Yes</option>
    <option value="0" <?php if($product['best_sales']==0) echo "selected"; ?>>Best Sales - No</option>
</select><br><br>

<select name="trending">
    <option value="1" <?php if($product['trending']==1) echo "selected"; ?>>Trending - Yes</option>
    <option value="0" <?php if($product['trending']==0) echo "selected"; ?>>Trending - No</option>
</select><br><br>

<p>Old Images:</p>
<img src="../../<?php echo $product['img1']; ?>" width="60">
<img src="../../<?php echo $product['img2']; ?>" width="60">
<img src="../../<?php echo $product['img3']; ?>" width="60">
<img src="../../<?php echo $product['img4']; ?>" width="60"><br><br>

<input type="file" name="img1"><br><br>
<input type="file" name="img2"><br><br>
<input type="file" name="img3"><br><br>
<input type="file" name="img4"><br><br>

<button type="submit" name="update">Update Product</button>

</form>
</body>
</html>
