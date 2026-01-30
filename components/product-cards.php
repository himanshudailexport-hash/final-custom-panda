<?php
if (!isset($conn)) {
    include __DIR__ . "../config/db.php";
}

$sql = "
    SELECT 
        p.id,
        p.name,
        p.brand_name,
        p.price,
        p.discount_price,
        p.rating,
        p.img1,
        p.new_arrivals,
        c.name AS category_name
    FROM products p
    JOIN categories c ON c.id = p.category_id
    $whereSQL
    ORDER BY p.id DESC
";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$productQuery = $stmt->get_result();
?>




<section id="product1" class="section-p1">
    <div class="container">
        
        <div class="row g-4 pro-container">

            <?php while ($row = $productQuery->fetch_assoc()) { ?>

                <div class="col-lg-3 col-md-4 col-6">

                    <div class="pro"
                        data-id="<?= $row['id']; ?>"
                        data-price="<?= $row['price']; ?>"
                        data-rating="<?= $row['rating']; ?>"
                        data-category="<?= strtolower($row['category_name']); ?>">

                        <a href="product-detail-page.php?id=<?= $row['id']; ?>">
                            <img src="uploads/products/<?= htmlspecialchars($row['img1']); ?>"
                                alt="<?= htmlspecialchars($row['name']); ?>">
                            <?php if ((int)$row['new_arrivals'] === 1) { ?>
                                <span class="new-badge">New</span>
                            <?php } ?>

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



<script src="assets/js/script.js"></script>



<!-- <script>
    function getWishlist() {
  return JSON.parse(localStorage.getItem('wishlist')) || [];
}

function toggleWishlist(id, btn) {
  let list = getWishlist();

  if (list.includes(id)) {
    list = list.filter(pid => pid !== id);
    btn.classList.remove('active');
  } else {
    list.push(id);
    btn.classList.add('active');
  }

  localStorage.setItem('wishlist', JSON.stringify(list));
}

</script> -->


<script>
    document.addEventListener("DOMContentLoaded", function() {

        const categoryFilter = document.getElementById("categoryFilter");
        const sortFilter = document.getElementById("productSort");
        const productContainer = document.querySelector(".pro-container");

        if (!productContainer) return;

        // Store original product columns
        const productCols = Array.from(productContainer.children);

        function filterAndSortProducts() {
            const selectedCategory = categoryFilter.value;
            const selectedSort = sortFilter.value;

            // FILTER
            let filteredProducts = productCols.filter(col => {
                const product = col.querySelector(".pro");
                if (!product) return false;

                return (
                    selectedCategory === "all" ||
                    product.dataset.category === selectedCategory
                );
            });

            // SORT
            if (selectedSort !== "") {
                filteredProducts.sort((a, b) => {
                    const prodA = a.querySelector(".pro");
                    const prodB = b.querySelector(".pro");

                    const priceA = Number(prodA.dataset.price);
                    const priceB = Number(prodB.dataset.price);
                    const ratingA = Number(prodA.dataset.rating);
                    const ratingB = Number(prodB.dataset.rating);
                    const idA = Number(prodA.dataset.id);
                    const idB = Number(prodB.dataset.id);

                    switch (selectedSort) {
                        case "price_low":
                            return priceA - priceB;

                        case "price_high":
                            return priceB - priceA;

                        case "rating":
                            return ratingB - ratingA;

                        case "latest":
                            return idB - idA;

                        default:
                            return 0;
                    }
                });
            }

            // RENDER
            productContainer.innerHTML = "";

            if (filteredProducts.length === 0) {
                productContainer.innerHTML = `
        <div class="col-12 text-center py-5 text-muted">
          No products found
        </div>
      `;
                return;
            }

            filteredProducts.forEach(col => productContainer.appendChild(col));
        }

        categoryFilter.addEventListener("change", filterAndSortProducts);
        sortFilter.addEventListener("change", filterAndSortProducts);

    });
</script>