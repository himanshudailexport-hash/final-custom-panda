<?php
include "config/db.php";



$id = (int)$_GET['id'];

$query = $conn->query("SELECT * FROM products WHERE id = $id");
$product = $query->fetch_assoc();

if (!$product) {
    echo "Product not found";
    exit;
}

$categoryId = (int)$product['category_id'];
$currentProductId = (int)$product['id'];

$relatedQuery = $conn->query("
    SELECT id, name, price, img1 
    FROM products 
    WHERE category_id = $categoryId 
      AND id != $currentProductId
    ORDER BY created_at DESC
    LIMIT 4
");

$relatedProducts = [];
while ($row = $relatedQuery->fetch_assoc()) {
    $relatedProducts[] = $row;
}

?>

<?php
$productUrl   = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$productTitle = urlencode($product['name']);
$productImage = urlencode("https://" . $_SERVER['HTTP_HOST'] . "/uploads/products/" . $product['img1']);
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> | Custom Panda</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        .related-products {
            padding: 70px 0;
        }

        .related-title {
            font-size: 26px;
            margin-bottom: 30px;
        }

        .product-card {
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-6px);
        }

        .product-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .product-card .product-info {
            padding: 15px;
        }

        .product-card h6 {
            font-size: 15px;
            margin-bottom: 6px;
        }

        .product-card .price {
            font-weight: 600;
        }
    </style>
</head>

<body>

    <?php include 'components/header.php'; ?>

    <section class="product-details">
        <div class="product-top">

            <!-- LEFT: THUMBNAILS -->
            <div class="product-thumbs desktop-only">

                <?php if (!empty($product['img1'])) { ?>
                    <img src="uploads/products/<?php echo $product['img1']; ?>" onclick="changeImage(this)">
                <?php } ?>

                <?php if (!empty($product['img2'])) { ?>
                    <img src="uploads/products/<?php echo $product['img2']; ?>" onclick="changeImage(this)">
                <?php } ?>
                <?php if (!empty($product['img3'])) { ?>
                    <img src="uploads/products/<?php echo $product['img3']; ?>" onclick="changeImage(this)">
                <?php } ?>

                <?php if (!empty($product['img4'])) { ?>
                    <img src="uploads/products/<?php echo $product['img4']; ?>" onclick="changeImage(this)">
                <?php } ?>

            </div>

            <!-- CENTER: MAIN IMAGE -->
            <div class="product-main-img">
                <img id="mainImage" class="desktop-only"
                    src="uploads/products/<?php echo $product['img1']; ?>">
            </div>

            <!-- RIGHT: PRODUCT INFO -->
            <div class="product-info">

                <span class="brand">
                    <?php echo htmlspecialchars($product['brand_name']); ?>
                </span>

                <h1 class="product-title">
                    <?php echo htmlspecialchars($product['name']); ?>
                </h1>

                <div class="rating">
                    ★★★★☆ <span>(<?php echo $product['rating']; ?>)</span>
                </div>

                <h2 class="price">
                    ₹ <?php echo number_format($product['price']); ?>
                </h2>

                <div class="cart-actions">
                    <div class="quantity">
                        <button onclick="decreaseQty()">−</button>
                        <input type="text" id="qty" value="1" readonly>
                        <button onclick="increaseQty()">+</button>
                    </div>

                    <!-- <button class="add-to-cart">
                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                </button> -->

                    <!-- <button class="add-to-cart"
                        onclick="addToCart(<?php echo $product['id']; ?>)">
                        <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                    </button> -->

                    <button class="add-to-cart"
                        data-id="<?= $product['id']; ?>"
                        data-name="<?= htmlspecialchars($product['name']); ?>"
                        data-price="<?= $product['price']; ?>"
                        data-image="<?= htmlspecialchars($product['img1']); ?>"
                        data-qty-input="qty">
                        <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                    </button>





                </div>

                <div class="size-section">
                    <p class="size-title">
                        Please select a size.
                        <a href="#" class="size-chart">SIZE CHART</a>
                    </p>

                    <div class="size-options">
                        <button class="size-btn active" data-size="XS">XS</button>
                        <button class="size-btn" data-size="S">S</button>
                        <button class="size-btn" data-size="M">M</button>
                        <button class="size-btn" data-size="L">L</button>
                        <button class="size-btn" data-size="XL">XL</button>
                        <button class="size-btn" data-size="XXL">XXL</button>
                        <button class="size-btn" data-size="XXXL">XXXL</button>
                    </div>


                    <div class="size-info" id="sizeInfo">
                        To Fit Your Chest Size:
                        <strong>36</strong> |
                        Garment Chest:
                        <strong>40</strong> |
                        Length:
                        <strong>27</strong> |
                        Shoulder:
                        <strong>20</strong> |
                        Sleeve:
                        <strong>8.75</strong>
                    </div>
                </div>

                <div class="product-share">
                    <span class="share-label">Share:</span>

                    <a href="https://wa.me/?text=<?= $productTitle ?>%20<?= urlencode($productUrl) ?>"
                        target="_blank" class="share-btn whatsapp">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>

                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($productUrl) ?>"
                        target="_blank" class="share-btn facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>

                    <a href="https://twitter.com/intent/tweet?text=<?= $productTitle ?>&url=<?= urlencode($productUrl) ?>"
                        target="_blank" class="share-btn twitter">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>

                    <button class="share-btn instagram" onclick="copyProductLink()">
                        <i class="fa-brands fa-instagram"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- DESCRIPTION -->
        <div class="product-description">
            <h3>Description</h3>
            <p>
                <?php echo nl2br(htmlspecialchars($product['description'])); ?>
            </p>
        </div>

    </section>


    <div class="mb-4">
        <?php if (!empty($relatedProducts)) { ?>
        <section id="product1" class="section-p1">

            <h2 style="margin-bottom:20px;">Related Products</h2>

            <div class="container">
                <div class="row g-4 pro-container">

                    <?php foreach ($relatedProducts as $row) { ?>

                        <div class="col-lg-3 col-md-4 col-6">

                            <div class="pro"
                                data-id="<?= $row['id']; ?>"
                                data-price="<?= $row['price']; ?>"
                                data-rating="<?= $row['rating'] ?? 5; ?>">

                                <!-- PRODUCT CLICK → DETAILS PAGE -->
                                <a href="product-detail-page.php?id=<?= $row['id']; ?>">

                                    <img src="uploads/products/<?= htmlspecialchars($row['img1']); ?>"
                                        alt="<?= htmlspecialchars($row['name']); ?>">

                                    <div class="des">
                                        <span><?= htmlspecialchars($row['brand_name'] ?? ''); ?></span>
                                        <h5><?= htmlspecialchars($row['name']); ?></h5>

                                        <div class="star">
                                            <?php
                                            $rating = floor($row['rating'] ?? 5);
                                            for ($i = 1; $i <= 5; $i++) {
                                                echo ($i <= $rating)
                                                    ? '<i class="fas fa-star"></i>'
                                                    : '<i class="far fa-star"></i>';
                                            }
                                            ?>
                                        </div>

                                        <h4>
                                            <i class="fa-solid fa-indian-rupee-sign"></i>
                                            <?= number_format($row['price']); ?>
                                        </h4>
                                    </div>
                                </a>

                                <!-- CART ICON -->
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
    <?php } ?>
    </div>


    <?php include 'components/footer.php'; ?>





    <script>
        function changeImage(element) {
            document.getElementById("mainImage").src = element.src;
        }

        function increaseQty() {
            let qty = document.getElementById("qty");
            qty.value = parseInt(qty.value) + 1;
        }

        function decreaseQty() {
            let qty = document.getElementById("qty");
            if (qty.value > 1) {
                qty.value = parseInt(qty.value) - 1;
            }
        }
    </script>

    <script>
        const sizeData = {
            XS: {
                chest: 36,
                garment: 40,
                length: 27,
                shoulder: 20,
                sleeve: 8.75
            },
            S: {
                chest: 38,
                garment: 42,
                length: 28,
                shoulder: 20.5,
                sleeve: 9
            },
            M: {
                chest: 40,
                garment: 44,
                length: 29,
                shoulder: 21,
                sleeve: 9.25
            },
            L: {
                chest: 42,
                garment: 46,
                length: 30,
                shoulder: 21.5,
                sleeve: 9.5
            },
            XL: {
                chest: 44,
                garment: 48,
                length: 31,
                shoulder: 22,
                sleeve: 9.75
            },
            XXL: {
                chest: 46,
                garment: 50,
                length: 32,
                shoulder: 22.5,
                sleeve: 10
            },
            XXXL: {
                chest: 48,
                garment: 52,
                length: 33,
                shoulder: 23,
                sleeve: 10.25
            }
        };

        const sizeButtons = document.querySelectorAll(".size-btn");
        const sizeInfo = document.getElementById("sizeInfo");

        sizeButtons.forEach(btn => {
            btn.addEventListener("click", () => {

                sizeButtons.forEach(b => b.classList.remove("active"));
                btn.classList.add("active");

                const size = btn.dataset.size;
                const d = sizeData[size];

                sizeInfo.innerHTML = `
            To Fit Your Chest Size:
            <strong>${d.chest}</strong> |
            Garment Chest:
            <strong>${d.garment}</strong> |
            Length:
            <strong>${d.length}</strong> |
            Shoulder:
            <strong>${d.shoulder}</strong> |
            Sleeve:
            <strong>${d.sleeve}</strong>
        `;
            });
        });
    </script>

    <script>
        function copyProductLink() {
            navigator.clipboard.writeText("<?= $productUrl ?>");
            alert("Product link copied! Paste it on Instagram 📸");
        }
    </script>



</body>

</html>