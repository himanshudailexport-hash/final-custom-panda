<?php
session_start();
require_once "config/db.php";

// $wishlistProducts = [];
$wishlistProducts = null;

/* LOGGED-IN USER */
if (isset($_SESSION['user_id'])) {

    $sql = "
        SELECT 
            p.id,
            p.name,
            p.price,
            p.img1
        FROM wishlists w
        JOIN products p ON p.id = w.product_id
        WHERE w.user_id = ?
        ORDER BY w.id DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $wishlistProducts = $stmt->get_result();

    /* GUEST USER */
} else {

    $ids = array_keys($_SESSION['wishlist'] ?? []);

    if (!empty($ids)) {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));

        $sql = "
            SELECT id, name, price, img1
            FROM products
            WHERE id IN ($placeholders)
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$ids);
        $stmt->execute();
        $wishlistProducts = $stmt->get_result();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Wishlist</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <?php include 'components/header.php' ?>

    <div class="container py-5">
        <h3 class="mb-4">My Wishlist </h3>

        <?php if (
            !isset($wishlistProducts) ||
            !$wishlistProducts instanceof mysqli_result ||
            $wishlistProducts->num_rows === 0
        ) { ?>

            <div class="text-center text-muted py-5">
                <h5>Your wishlist is empty</h5>
                <a href="shop.php" class="btn btn-dark mt-3">Continue Shopping</a>
            </div>
        <?php } else { ?>

            <div class="row g-4">

                <?php while ($row = $wishlistProducts->fetch_assoc()) { ?>

                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="card h-100">

                            <a href="product-detail-page.php?id=<?= $row['id']; ?>">
                                <img src="uploads/products/<?= htmlspecialchars($row['img1']); ?>"
                                    class="card-img-top"
                                    alt="<?= htmlspecialchars($row['name']); ?>">
                            </a>

                            <div class="card-body">
                                <h6 class="card-title">
                                    <?= htmlspecialchars($row['name']); ?>
                                </h6>

                                <p class="fw-bold mb-2">
                                    ₹<?= $row['price']; ?>
                                </p>

                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-danger remove-wishlist"
                                        data-id="<?= $row['id']; ?>">
                                        Remove
                                    </button>

                                    <button class="btn btn-sm btn-dark add-to-cart"
                                        data-id="<?= $row['id']; ?>"
                                        data-name="<?= htmlspecialchars($row['name']); ?>"
                                        data-price="<?= $row['price']; ?>"
                                        data-image="<?= htmlspecialchars($row['img1']); ?>">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                <?php } ?>

            </div>

        <?php } ?>
    </div>

    <?php include 'components/footer.php' ?>

    <script>
        document.addEventListener("click", function(e) {

            const btn = e.target.closest(".remove-wishlist");
            if (!btn) return;

            const productId = btn.dataset.id;

            fetch("wishlist-handler.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    credentials: "same-origin",
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {

                    if (data.error) {
                        console.error("Remove failed:", data.error);
                        return;
                    }

                    // ✅ Remove card instantly
                    const card = btn.closest(".col-lg-3");
                    if (card) card.remove();

                    // ✅ Update wishlist count if function exists
                    if (typeof updateWishlistCount === "function") {
                        updateWishlistCount();
                    }

                    // ✅ If empty, show empty message without reload
                    if (document.querySelectorAll(".remove-wishlist").length === 0) {
                        document.querySelector(".row.g-4").innerHTML = `
                <div class="col-12 text-center text-muted py-5">
                    <h5>Your wishlist is empty</h5>
                    <a href="shop.php" class="btn btn-dark mt-3">Continue Shopping</a>
                </div>
            `;
                    }

                })
                .catch(error => console.error("Fetch error:", error));

        });
    </script>

</body>

</html>