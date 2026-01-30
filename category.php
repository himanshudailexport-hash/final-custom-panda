<?php
include "config/db.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: shop.php");
    exit;
}

$category_id = (int)$_GET['id'];

/* FETCH PRODUCTS BY CATEGORY */
$productStmt = $conn->prepare("
    SELECT id, name, brand_name, price, rating, img1
    FROM products
    WHERE category_id = ?
");
$productStmt->bind_param("i", $category_id);
$productStmt->execute();
$productQuery = $productStmt->get_result();
?>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="assets/css/style.css">

<?php include 'components/header.php'; ?>

<section id="product1" class="section-p1">
    <div class="container">
        <div class="row g-4">

            <?php while ($row = $productQuery->fetch_assoc()) { ?>

                <div class="col-lg-3 col-md-4 col-6">

                    <div class="pro"
                        data-id="<?= $row['id']; ?>"
                        data-price="<?= $row['price']; ?>"
                        data-rating="<?= $row['rating']; ?>"
                        data-category="<?= strtolower($row['name']); ?>">

                        <a href="product-detail-page.php?id=<?= $row['id']; ?>">

                            <img src="uploads/products/<?= htmlspecialchars($row['img1']); ?>"
                                 alt="<?= htmlspecialchars($row['name']); ?>">

                            <div class="des">
                                <span><?= htmlspecialchars($row['brand_name']); ?></span>
                                <h5><?= htmlspecialchars($row['name']); ?></h5>

                                <div class="star">
                                    <?php
                                    $rating = floor($row['rating']);
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo ($i <= $rating)
                                            ? '<i class="fas fa-star"></i>'
                                            : '<i class="far fa-star"></i>';
                                    }
                                    ?>
                                </div>

                                <h4>
                                    <i class="fa-solid fa-indian-rupee-sign"></i>
                                    <?= $row['price']; ?>
                                </h4>
                            </div>
                        </a>

                        <button class="wishlist-btn" data-id="<?= $row['id']; ?>">
                            <i class="fa-regular fa-heart"></i>
                        </button>

                        <button class="cart add-to-cart"
                            data-id="<?= $row['id']; ?>"
                            data-name="<?= htmlspecialchars($row['name']); ?>"
                            data-price="<?= $row['price']; ?>"
                            data-image="<?= htmlspecialchars($row['img1']); ?>">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </button>

                    </div>

                </div>

            <?php } ?>

        </div>
    </div>
</section>



<?php include 'components/footer.php'; ?>

<script src="assets/js/script.js"></script>

