<?php
require_once "../../config/db.php";

$categories = $conn->query("SELECT id, name FROM categories ORDER BY name");
$brands = $conn->query("SELECT name FROM brands ORDER BY name");
?>

<div class="add-product-wrapper">
    <div class="card product-card shadow-sm">
        <div class="card-header text-center">
            <h2 class="mb-0">Add Product</h2>
        </div>

        <div class="card-body">

            <p id="formMessage" class="text-center"></p>

            <form id="addProductForm" enctype="multipart/form-data">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Product Name" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Select Category</option>
                            <?php while ($cat = $categories->fetch_assoc()) { ?>
                                <option value="<?= $cat['id'] ?>">
                                    <?= $cat['name'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Price</label>
                        <input type="number" name="price" class="form-control" placeholder="Price" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Discount Price</label>
                        <input type="number" name="discount_price" class="form-control" placeholder="Discount Price">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" placeholder="Stock" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">SKU ID</label>
                        <input type="text" name="sku_id" class="form-control" placeholder="SKU ID" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Color</label>
                        <input type="text" name="color" class="form-control" placeholder="Color">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Size</label>
                        <input type="text" name="size" class="form-control" placeholder="Size">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" placeholder="Description"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Fabric</label>
                        <textarea name="fabric" class="form-control" placeholder="Fabric"></textarea>
                    </div>

                    <!-- <div class="col-md-4">
                        <label class="form-label">Net Quantity</label>
                        <input type="number" name="net_quantity" class="form-control" placeholder="Net Quantity">
                    </div> -->

                    <div class="col-md-4">
                        <label class="form-label">Brand</label>
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
                        <label class="form-label">Rating</label>
                        <input type="number" step="0.1" name="rating" class="form-control" placeholder="Rating (e.g. 4.5)">
                    </div>

                    <!-- <div class="col-md-6">
                        <label class="form-label">Total Amount</label>
                        <input type="number" step="0.01" name="total_amount" class="form-control" placeholder="Total Amount">
                    </div> -->

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
                        <label class="form-label">Image 1</label>
                        <input type="file" name="img1" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Image 2</label>
                        <input type="file" name="img2" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Image 3</label>
                        <input type="file" name="img3" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Image 4</label>
                        <input type="file" name="img4" class="form-control">
                    </div>

                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-custom px-5">
                            Add Product
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>