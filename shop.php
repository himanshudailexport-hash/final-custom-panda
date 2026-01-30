<?php
include __DIR__ . "/config/db.php";

$categoryQuery = $conn->query("
    SELECT id, name 
    FROM categories 
    ORDER BY name ASC
");


$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';

$where = [];
$params = [];
$types = "";

/* SEARCH */
if (!empty($search)) {
    $where[] = "(p.name LIKE ? OR p.brand_name LIKE ? OR p.description LIKE ? OR p.sku_id LIKE ?)";
    $searchTerm = "%{$search}%";
    array_push($params, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $types .= "ssss";
}

/* CATEGORY */
if (!empty($category) && $category !== 'all') {
    $where[] = "LOWER(c.name) = ?";
    $params[] = strtolower($category);
    $types .= "s";
}

$whereSQL = count($where) ? "WHERE " . implode(" AND ", $where) : "";


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Men’s Clothing Online | T-Shirts, Hoodies & Sportswear</title>
    <meta name="description" content="Browse our clothing collection featuring men’s T-shirts, hoodies, and sportswear made for comfort, fit, and regular use.">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <?php include 'components/header.php'; ?>

    <div class=" py-2">



        <section id="product1" class="section-p1">
            <h2>Our Clothing Collection</h2>
            <p>Find comfortable apparel suitable for everyday wear and simple lifestyles.</p>

            <div class="container my-3">
                <div class="row g-3 align-items-center">

                    <div class="col-lg-4 col-md-6">
                        <select id="categoryFilter" class="form-select">
                            <option value="all">All Categories</option>

                            <?php while ($cat = $categoryQuery->fetch_assoc()) { ?>
                                <option value="<?= strtolower($cat['name']); ?>">
                                    <?= htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php } ?>

                        </select>
                    </div>

                    <!-- SORT -->
                    <div class="col-lg-3 col-md-4 ">
                        <select id="productSort" class="form-select">
                            <option value="">Sort by</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                            <option value="rating">Rating</option>
                            <option value="latest">Latest</option>
                        </select>
                    </div>
                </div>
            </div>

            <?php include 'components/product-cards.php'; ?>
        </section>
    </div>

    <?php include 'components/footer.php'; ?>

    <script src="assets/js/script.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const categoryFilter = document.getElementById("categoryFilter");
            const sortFilter = document.getElementById("productSort");
            const productContainer = document.querySelector(".pro-container");

            if (!categoryFilter || !sortFilter || !productContainer) return;

            const productCols = Array.from(productContainer.children);

            function filterAndSortProducts() {
                const selectedCategory = categoryFilter.value;
                const selectedSort = sortFilter.value;

                let filtered = productCols.filter((col) => {
                    const product = col.querySelector(".pro");
                    return (
                        selectedCategory === "all" ||
                        product.dataset.category === selectedCategory
                    );
                });

                filtered.sort((a, b) => {
                    const A = a.querySelector(".pro").dataset;
                    const B = b.querySelector(".pro").dataset;

                    switch (selectedSort) {
                        case "price_low":
                            return A.price - B.price;
                        case "price_high":
                            return B.price - A.price;
                        case "rating":
                            return B.rating - A.rating;
                        case "latest":
                            return B.id - A.id;
                        default:
                            return 0;
                    }
                });

                productContainer.innerHTML = "";

                if (!filtered.length) {
                    productContainer.innerHTML = `
        <div class="col-12 text-center py-5 text-muted">
          No products found
        </div>`;
                    return;
                }

                filtered.forEach((col) => productContainer.appendChild(col));
            }

            //  read category from URL
            const params = new URLSearchParams(window.location.search);
            const categoryFromURL = params.get("category");

            if (categoryFromURL) {
                categoryFilter.value = categoryFromURL;
            }

            //  update URL on filter change
            categoryFilter.addEventListener("change", function() {
                const url = new URL(window.location);

                if (this.value === "all") {
                    url.searchParams.delete("category");
                } else {
                    url.searchParams.set("category", this.value);
                }

                window.history.pushState({}, "", url);
                filterAndSortProducts();
            });

            sortFilter.addEventListener("change", filterAndSortProducts);

            filterAndSortProducts();
        });
    </script>


</body>

</html>