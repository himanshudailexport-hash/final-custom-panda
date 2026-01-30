<?php
include "../../config/db.php";
$msg = "";

/* FETCH CATEGORIES */
$categories = $conn->query("SELECT id, name FROM categories ORDER BY name ASC");

/* FETCH BRANDS */
$brands = $conn->query("SELECT id, name FROM brands ORDER BY name ASC");

if (isset($_POST['submit'])) {

    $name           = $_POST['name'];
    $category_id    = (int)$_POST['category_id'];
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

    /* FLAGS */
    $new_arrivals = $_POST['new_arrivals'];
    $best_sales   = $_POST['best_sales'];
    $trending     = $_POST['trending'];

    $brand_name = $_POST['brand_name'];
    $rating     = $_POST['rating'];

    /* IMAGE UPLOAD */
    $uploadDir = "../../uploads/products/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $img1 = !empty($_FILES['img1']['name']) ? $uploadDir . time() . '_' . basename($_FILES['img1']['name']) : null;
    $img2 = !empty($_FILES['img2']['name']) ? $uploadDir . time() . '_' . basename($_FILES['img2']['name']) : null;
    $img3 = !empty($_FILES['img3']['name']) ? $uploadDir . time() . '_' . basename($_FILES['img3']['name']) : null;
    $img4 = !empty($_FILES['img4']['name']) ? $uploadDir . time() . '_' . basename($_FILES['img4']['name']) : null;

    if ($img1) move_uploaded_file($_FILES['img1']['tmp_name'], $img1);
    if ($img2) move_uploaded_file($_FILES['img2']['tmp_name'], $img2);
    if ($img3) move_uploaded_file($_FILES['img3']['tmp_name'], $img3);
    if ($img4) move_uploaded_file($_FILES['img4']['tmp_name'], $img4);

    $stmt = $conn->prepare("
        INSERT INTO products 
        (name, category_id, price, stock, discount_price, sku_id, color, size, description,
         net_quantity, fabric, total_amount,
         new_arrivals, best_sales, trending,
         brand_name, rating,
         img1, img2, img3, img4)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
    ");

    // $stmt->bind_param(
    //     "siiiiissssisiidisssss",
    //     $name,
    //     $category_id,
    //     $price,
    //     $stock,
    //     $discount_price,
    //     $sku_id,
    //     $color,
    //     $size,
    //     $description,
    //     $net_quantity,
    //     $fabric,
    //     $total_amount,
    //     $new_arrivals,
    //     $best_sales,
    //     $trending,
    //     $brand_name,
    //     $rating,
    //     $img1,
    //     $img2,
    //     $img3,
    //     $img4
    // );

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
        $msg = "Product added successfully ✅";
    } else {
        $msg = "Error adding product ❌";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Product</title>
</head>

<body>

    <h2>Add Product</h2>
    <p style="color:green;"><?php echo $msg; ?></p>

    <form method="post" enctype="multipart/form-data">

        <input type="text" name="name" placeholder="Product Name" required><br><br>

        <select name="category_id" required>
            <option value="">Select Category</option>
            <?php while ($cat = $categories->fetch_assoc()) { ?>
                <option value="<?php echo $cat['id']; ?>">
                    <?php echo $cat['name']; ?>
                </option>
            <?php } ?>
        </select>



        <br><br>

        <input type="number" name="price" placeholder="Price" required><br><br>
        <input type="number" name="discount_price" placeholder="Discount Price"><br><br>
        <input type="number" name="stock" placeholder="Stock" required><br><br>

        <input type="text" name="sku_id" placeholder="SKU ID" required><br><br>
        <input type="text" name="color" placeholder="Color"><br><br>
        <input type="text" name="size" placeholder="Size"><br><br>

        <textarea name="description" placeholder="Description"></textarea><br><br>
        <input type="number" name="net_quantity" placeholder="Net Quantity"><br><br>

        <textarea name="fabric" placeholder="Fabric"></textarea><br><br>

        <select name="brand_name" required>
            <option value="">Select Brand</option>
            <?php while ($brand = $brands->fetch_assoc()) { ?>
                <option value="<?php echo $brand['name']; ?>">
                    <?php echo $brand['name']; ?>
                </option>
            <?php } ?>
        </select><br><br>

        <input type="number" step="0.1" name="rating" placeholder="Rating (e.g. 4.5)"><br><br>
        <input type="number" step="0.01" name="total_amount" placeholder="Total Amount"><br><br>

        <!-- FLAGS -->
        <label>New Arrivals</label>
        <select name="new_arrivals">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select><br><br>

        <label>Best Sales</label>
        <select name="best_sales">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select><br><br>

        <label>Trending</label>
        <select name="trending">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select><br><br>

        <input type="file" name="img1" required><br><br>
        <input type="file" name="img2"><br><br>
        <input type="file" name="img3"><br><br>
        <input type="file" name="img4"><br><br>

        <button type="submit" name="submit">Add Product</button>

    </form>

</body>

</html>