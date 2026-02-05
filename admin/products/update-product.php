<?php
require_once "../../config/db.php";

if (!isset($_GET['id'])) die("Product ID missing");
$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
if (!$product) die("Product not found");

$categories = $conn->query("SELECT id, name FROM categories ORDER BY name");
$brands     = $conn->query("SELECT name FROM brands ORDER BY name");
?>

<div class="add-product-wrapper">
  <div class="card product-card shadow-sm">
    <div class="card-header text-center">
      <h2 class="mb-0">Edit Product</h2>
    </div>

    <div class="card-body">
      <p id="formMessage" class="text-center"></p>

      <form id="editProductForm" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">

        <div class="row g-3">

          <div class="col-md-6">
            <input type="text" name="name" class="form-control"
                   value="<?= $product['name'] ?>" required>
          </div>

          <div class="col-md-6">
            <select name="category_id" class="form-select" required>
              <?php while ($c = $categories->fetch_assoc()) { ?>
                <option value="<?= $c['id'] ?>"
                  <?= $c['id'] == $product['category_id'] ? 'selected' : '' ?>>
                  <?= $c['name'] ?>
                </option>
              <?php } ?>
            </select>
          </div>

          <div class="col-md-6">
            <select name="brand_name" class="form-select" required>
              <?php while ($b = $brands->fetch_assoc()) { ?>
                <option value="<?= $b['name'] ?>"
                  <?= $b['name'] == $product['brand_name'] ? 'selected' : '' ?>>
                  <?= $b['name'] ?>
                </option>
              <?php } ?>
            </select>
          </div>

          <div class="col-md-3">
            <input type="number" name="price" class="form-control"
                   value="<?= $product['price'] ?>">
          </div>

          <div class="col-md-3">
            <input type="number" name="discount_price" class="form-control"
                   value="<?= $product['discount_price'] ?>">
          </div>

          <div class="col-md-3">
            <input type="number" name="stock" class="form-control"
                   value="<?= $product['stock'] ?>">
          </div>

          <div class="col-md-3">
            <input type="text" name="sku_id" class="form-control"
                   value="<?= $product['sku_id'] ?>">
          </div>

          <div class="col-md-6">
            <textarea name="description" class="form-control"><?= $product['description'] ?></textarea>
          </div>

          <div class="col-md-6">
            <textarea name="fabric" class="form-control"><?= $product['fabric'] ?></textarea>
          </div>

          <!-- images -->
          <div class="col-md-3">
            <input type="file" name="img1" class="form-control">
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
            <button class="btn btn-custom px-5">
              Update Product
            </button>
          </div>

        </div>
      </form>
    </div>
  </div>
</div>
