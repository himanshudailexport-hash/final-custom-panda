<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// include_once "config/db.php";
require_once __DIR__ . "/../config/bootstrap.php";


$navCategories = $conn->query("SELECT id, name FROM categories ORDER BY name DESC");


?>
<style>
    .search-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        z-index: 9999;
        display: none;
    }

    .search-suggestions a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        text-decoration: none;
        color: #333;
        border-bottom: 1px solid #eee;
    }

    .search-suggestions a:hover {
        background: #f8f9fa;
    }

    .search-suggestions img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 4px;
    }
</style>


<nav class="navbar navbar-expand-lg sticky-top custom-navbar">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand logo-animate" href="index.php">
            <img src="assets/img/logo/logo.png" alt="logo" class="navbar-logo">
        </a>

        <!-- Search -->


        <form class="d-none d-lg-flex ms-3 position-relative"
            action="shop.php"
            method="GET"
            style="max-width: 400px; width:100%;">

            <div class="input-group">
                <input type="text"
                    id="searchInput"
                    name="search"
                    class="form-control"
                    placeholder="Search products..."
                    autocomplete="off"
                    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">

                <button class="btn btn-warning" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>

            <!-- Suggestions -->
            <div id="searchSuggestions" class="search-suggestions"></div>
        </form>


        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
                <li class="nav-item category-dropdown">
                    <a href="#" class="nav-link category-link">
                        Category
                        <i class="fa-solid fa-chevron-down dropdown-icon"></i>
                    </a>
                    <ul class="category-menu">
                        <?php while ($cat = $navCategories->fetch_assoc()) { ?>
                            <li>
                                <a href="shop.php?category=<?= urlencode(strtolower($cat['name'])); ?>">
                                    <?= htmlspecialchars($cat['name']); ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>

                </li>



                <li class="nav-item">
                    <a class="nav-link" href="shop.php">Shop</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="all-blogs.php">Blog</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>

                <!-- Cart -->

                <li class="nav-item position-relative ms-lg-3">
                    <a href="cart.php" class="nav-link cart-icon">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <!-- <span id="cart-count" class="cart-count">0</span> -->
                        <span id="cart-count" class="cart-count">0</span>

                    </a>
                </li>

                <!-- User -->
                <li class="nav-item ms-lg-3">
                    <a class="nav-link user-icon" href="#">
                        <i class="fa-solid fa-circle-user"></i>
                    </a>
                </li>

            </ul>
        </div>

    </div>
</nav>



<script src="assets/js/common-cart.js"></script>

<script src="assets/js/script.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.getElementById("searchInput");
        const box = document.getElementById("searchSuggestions");
        let timer;

        if (!input || !box) return;

        input.addEventListener("input", function() {
            clearTimeout(timer);
            const query = this.value.trim();

            if (query.length < 2) {
                box.style.display = "none";
                return;
            }

            timer = setTimeout(() => {
                fetch(`components/search-suggestions.php?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (!data.length) {
                            box.style.display = "none";
                            return;
                        }

                        box.innerHTML = data.map(item => `
                        <a href="product-detail-page.php?id=${item.id}">
                            <img src="uploads/products/${item.img1}">
                            <div>
                                <div>${item.name}</div>
                                
                            </div>
                        </a>
                    `).join("");

                        box.style.display = "block";
                    })
                    .catch(() => box.style.display = "none");
            }, 300);
        });

        document.addEventListener("click", e => {
            if (!e.target.closest(".search-suggestions") &&
                !e.target.closest("#searchInput")) {
                box.style.display = "none";
            }
        });
    });
</script>