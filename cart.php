<?php
session_start();
include "config/db.php";

$cart = $_SESSION['cart'] ?? [];

$shipping = 50;
$subtotal = 0;

// Calculate subtotal
foreach ($cart as $item) {
    $subtotal += $item['price'] * $item['qty'];
}

$total = $subtotal + ($subtotal > 0 ? $shipping : 0);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

    <?php include("components/header.php"); ?>

    <section class="cart-section">
        <div class="cart-container">

            <!-- LEFT -->
            <div class="cart-left">
                <h2 class="cart-title">Your Cart</h2>

                <?php if (empty($cart)) { ?>
                    <p>Your cart is empty.</p>
                <?php } ?>

                <?php foreach ($cart as $id => $item) { ?>

                    <div class="cart-item" data-id="<?= $id ?>">

                        <div class="cart-img">
                            <img src="uploads/products/<?= htmlspecialchars($item['image']); ?>">
                        </div>

                        <div class="cart-info">
                            <h4 class="product-name"><?= htmlspecialchars($item['name']); ?></h4>

                            <div class="cart-actions-row">
                                <div class="qty-box">
                                    <button onclick="updateQty(<?= $id ?>, -1)">-</button>
                                    <span id="qty-<?= $id ?>"><?= $item['qty']; ?></span>
                                    <button onclick="updateQty(<?= $id ?>, 1)">+</button>
                                </div>

                                <div class="price">
                                    ₹ <span id="price-<?= $id ?>">
                                        <?= $item['price'] * $item['qty']; ?>
                                    </span>
                                </div>
                            </div>

                            <span class="remove-item" onclick="removeItem(<?= $id ?>)">
                                Remove
                            </span>
                        </div>

                    </div>

                <?php } ?>

                <div class="cart-back">
                    <a href="shop.php">← Back to Shop</a>
                </div>

            </div>

            <!-- RIGHT -->
            <div class="cart-right">
                <h3>Order Summary</h3>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>₹ <span id="subtotal"><?= $subtotal; ?></span></span>
                </div>

                <div class="summary-row">
                    <span>Shipping</span>
                    <span>₹ <?= $subtotal > 0 ? $shipping : 0; ?></span>
                </div>

                <div class="summary-row total">
                    <span>Total</span>
                    <span>₹ <span id="total"><?= $total; ?></span></span>
                </div>

                <!-- <button class="checkout-btn">Proceed to Checkout</button> -->
                 <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
            </div>

        </div>
    </section>

    <?php include("components/footer.php"); ?>

    

    <script>
        function updateQty(id, change) {
            fetch('cart-handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: change > 0 ? 'plus' : 'minus',
                    id: id
                })
            }).then(() => location.reload());
        }

        function removeItem(id) {
            fetch('cart-handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'remove',
                    id: id
                })
            }).then(() => location.reload());
        }
    </script>

</body>

</html>