<?php
require_once "../../config/db.php";

if (!isset($_GET['id'])) {
  die("Product ID missing");
}

$id = (int)$_GET['id'];

$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

$categories = $conn->query("SELECT id, name FROM categories ORDER BY name");
$brands = $conn->query("SELECT name FROM brands ORDER BY name");
?>

<div class="add-product-wrapper">
  <div class="card product-card shadow-sm">

    <div class="card-header text-center">
      <h2 class="mb-0">Update Product</h2>
    </div>

    <div class="card-body">

      <p id="formMessage" class="text-center"></p>

      <!-- <form id="updateProductForm" method="POST" enctype="multipart/form-data"> -->

      <form id="updateProductForm"
        method="POST"
        action="products/update_action.php"
        enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?= $product['id'] ?>">


        <div class="row g-3">

          <div class="col-md-6">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control"
              value="<?= $product['name'] ?>" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Category</label>

            <select name="category_id" class="form-select" required>

              <?php while ($cat = $categories->fetch_assoc()) { ?>

                <option value="<?= $cat['id'] ?>"
                  <?= $product['category_id'] == $cat['id'] ? 'selected' : '' ?>>

                  <?= $cat['name'] ?>

                </option>

              <?php } ?>

            </select>
          </div>

          <div class="col-md-4">
            <label class="form-label">Price</label>
            <input type="number" name="price" class="form-control"
              value="<?= $product['price'] ?>">
          </div>

          <div class="col-md-4">
            <label class="form-label">Discount Price</label>
            <input type="number" name="discount_price" class="form-control"
              value="<?= $product['discount_price'] ?>">
          </div>

          <div class="col-md-4">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control"
              value="<?= $product['stock'] ?>">
          </div>

          <div class="col-md-4">
            <label class="form-label">SKU ID</label>
            <input type="text" name="sku_id" class="form-control"
              value="<?= $product['sku_id'] ?>">
          </div>

          <div class="col-md-4">
            <label class="form-label">Color</label>
            <input type="text" name="color" class="form-control"
              value="<?= $product['color'] ?>">
          </div>

          <div class="col-md-4">
            <label class="form-label">Size</label>
            <input type="text" name="size" class="form-control"
              value="<?= $product['size'] ?>">
          </div>

          <div class="col-md-6">
            <label>Description</label>
            <textarea name="description" class="form-control"><?= $product['description'] ?></textarea>
          </div>

          <div class="col-md-6">
            <label>Fabric</label>
            <textarea name="fabric" class="form-control"><?= $product['fabric'] ?></textarea>
          </div>

          <div class="col-md-4">

            <label>Brand</label>

            <select name="brand_name" class="form-select">

              <?php while ($brand = $brands->fetch_assoc()) { ?>

                <option value="<?= $brand['name'] ?>"
                  <?= $product['brand_name'] == $brand['name'] ? 'selected' : '' ?>>

                  <?= $brand['name'] ?>

                </option>

              <?php } ?>

            </select>

          </div>

          <div class="col-md-4">
            <label>Rating</label>
            <input type="number" step="0.1" name="rating"
              value="<?= $product['rating'] ?>" class="form-control">
          </div>

          <div class="col-md-2">
            <label>New Arrivals</label>
            <select name="new_arrivals" class="form-select">
              <option value="1" <?= $product['new_arrivals'] == 1 ? 'selected' : '' ?>>Yes</option>
              <option value="0" <?= $product['new_arrivals'] == 0 ? 'selected' : '' ?>>No</option>
            </select>
          </div>

          <div class="col-md-2">
            <label>Best Sales</label>
            <select name="best_sales" class="form-select">
              <option value="1" <?= $product['best_sales'] == 1 ? 'selected' : '' ?>>Yes</option>
              <option value="0" <?= $product['best_sales'] == 0 ? 'selected' : '' ?>>No</option>
            </select>
          </div>

          <div class="col-md-2">
            <label>Trending</label>
            <select name="trending" class="form-select">
              <option value="1" <?= $product['trending'] == 1 ? 'selected' : '' ?>>Yes</option>
              <option value="0" <?= $product['trending'] == 0 ? 'selected' : '' ?>>No</option>
            </select>
          </div>

          <!-- Images -->

          <div class="col-md-3">
            <label>Image 1</label>
            <input type="file" name="img1" class="form-control">
            <img src="../../<?= $product['img1'] ?>" width="80">
          </div>

          <div class="col-md-3">
            <label>Image 2</label>
            <input type="file" name="img2" class="form-control">
            <img src="../../<?= $product['img2'] ?>" width="80">
          </div>

          <div class="col-md-3">
            <label>Image 3</label>
            <input type="file" name="img3" class="form-control">
            <img src="../../<?= $product['img3'] ?>" width="80">
          </div>

          <div class="col-md-3">
            <label>Image 4</label>
            <input type="file" name="img4" class="form-control">
            <img src="../../<?= $product['img4'] ?>" width="80">
          </div>

          <div class="col-12 text-center mt-4">

            <button type="submit" class="btn btn-custom px-5">
              Update Product
            </button>

          </div>

        </div>
      </form>

    </div>
  </div>
</div>

