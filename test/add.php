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
        $msg = "Product added successfully ...";
    } else {
        $msg = "Error adding product !";
    }
}
?>








<div class="container my-2">
    <div class="card product-card shadow-sm">
        <div class="card-header text-center">
            <h2 class="mb-0">Add Product</h2>
        </div>

        <div class="card-body">
            <p class="text-success text-center"><?php echo $msg; ?></p>

            <!-- <form method="post" enctype="multipart/form-data" action="products/add.php"> -->
            <form id="addProductForm" enctype="multipart/form-data">
                <div class="row g-3">

                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Product Name" required>
                    </div>

                    <div class="col-md-6">
                        <select name="category_id" class="form-select" required>
                            <option value="">Select Category</option>
                            <?php while ($cat = $categories->fetch_assoc()) { ?>
                                <option value="<?php echo $cat['id']; ?>">
                                    <?php echo $cat['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <input type="number" name="price" class="form-control" placeholder="Price" required>
                    </div>

                    <div class="col-md-4">
                        <input type="number" name="discount_price" class="form-control" placeholder="Discount Price">
                    </div>

                    <div class="col-md-4">
                        <input type="number" name="stock" class="form-control" placeholder="Stock" required>
                    </div>

                    <div class="col-md-4">
                        <input type="text" name="sku_id" class="form-control" placeholder="SKU ID" required>
                    </div>

                    <div class="col-md-4">
                        <input type="text" name="color" class="form-control" placeholder="Color">
                    </div>

                    <div class="col-md-4">
                        <input type="text" name="size" class="form-control" placeholder="Size">
                    </div>

                    <div class="col-md-6">
                        <textarea name="description" class="form-control" placeholder="Description"></textarea>
                    </div>

                    <div class="col-md-6">
                        <textarea name="fabric" class="form-control" placeholder="Fabric"></textarea>
                    </div>

                    <div class="col-md-4">
                        <input type="number" name="net_quantity" class="form-control" placeholder="Net Quantity">
                    </div>

                    <div class="col-md-4">
                        <select name="brand_name" class="form-select" required>
                            <option value="">Select Brand</option>
                            <?php while ($brand = $brands->fetch_assoc()) { ?>
                                <option value="<?php echo $brand['name']; ?>">
                                    <?php echo $brand['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <input type="number" step="0.1" name="rating" class="form-control" placeholder="Rating (e.g. 4.5)">
                    </div>

                    <div class="col-md-6">
                        <input type="number" step="0.01" name="total_amount" class="form-control" placeholder="Total Amount">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">New Arrivals</label>
                        <select name="new_arrivals" class="form-select">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Best Sales</label>
                        <select name="best_sales" class="form-select">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Trending</label>
                        <select name="trending" class="form-select">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <input type="file" name="img1" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <input type="file" name="img2" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <input type="file" name="img3" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <input type="file" name="img4" class="form-control">
                    </div>

                    <div class="col-12 text-center mt-4">
                        <button type="submit" name="submit" class="btn btn-custom px-5">
                            Add Product
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>