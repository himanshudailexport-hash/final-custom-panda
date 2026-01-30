<?php
session_start();
include "../config/db.php";
// include "../config/db.php";


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
    <style>
        /* CART SECTION */
        .cart-section {
            background: #f6f6f6;
            padding: 40px 15px;
        }

        /* MAIN CONTAINER */
        .cart-container {
            max-width: 1200px;
            margin: auto;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        /* LEFT SIDE */
        .cart-left {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
        }

        .cart-title {
            margin-bottom: 20px;
            font-size: 26px;
        }

        /* CART ITEM */
        .cart-item {
            display: flex;
            gap: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .cart-img img {
            width: 110px;
            height: 130px;
            object-fit: cover;
            border-radius: 10px;
        }

        .cart-info {
            flex: 1;
        }

        .product-name {
            margin: 0 0 10px;
            font-size: 18px;
        }

        /* QTY + PRICE ROW */
        .cart-actions-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* QUANTITY BOX */
        .qty-box {
            display: flex;
            border: 1px solid #ccc;
            border-radius: 6px;
            overflow: hidden;
        }

        .qty-box button {
            border: none;
            background: #eee;
            padding: 6px 12px;
            cursor: pointer;
            font-size: 16px;
        }

        .qty-box span {
            padding: 6px 14px;
            min-width: 30px;
            text-align: center;
        }

        /* PRICE */
        .price {
            font-weight: bold;
            font-size: 16px;
        }

        /* REMOVE */
        .remove-item {
            display: inline-block;
            margin-top: 8px;
            color: red;
            cursor: pointer;
            font-size: 14px;
        }

        /* BACK BUTTON */
        .cart-back {
            text-align: right;
            margin-top: 20px;
        }

        .cart-back a {
            text-decoration: none;
            color: #333;
            background: #eee;
            padding: 8px 14px;
            border-radius: 6px;
        }

        /* RIGHT SIDE */
        .cart-right {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            height: fit-content;
        }

        .cart-right h3 {
            margin-bottom: 15px;
        }

        /* SUMMARY */
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 12px 0;
            font-size: 15px;
        }

        .summary-row.total {
            font-weight: bold;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        /* CHECKOUT BUTTON */
        .checkout-btn {
            width: 100%;
            margin-top: 20px;
            background: #0a7cff;
            color: #fff;
            border: none;
            padding: 14px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
        }

        /* EMPTY CART TEXT */
        .cart-left p {
            font-size: 16px;
            color: #555;
        }

        /* MOBILE RESPONSIVE */
        @media (max-width: 768px) {
            .cart-container {
                grid-template-columns: 1fr;
            }

            .cart-item {
                flex-direction: column;
            }

            .cart-img img {
                width: 100%;
                height: auto;
            }

            .cart-actions-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>

</head>

<body>

    <?php include("../components/header.php"); ?>

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
                            <img src="../uploads/products/<?= htmlspecialchars($item['image']); ?>">
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
                    <a href="../shop.php">← Back to Shop</a>
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

                <a href="../checkout.php" class="checkout-btn">Proceed to Checkout</a>
            </div>

        </div>
    </section>

    <?php include("../components/footer.php"); ?>

    <script src="../assets/js/common-cart.js"></script>

    <script>
        function updateQty(id, change) {
            fetch('../cart/cart-handler.php', {
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
            fetch('../cart/cart-handler.php', {
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