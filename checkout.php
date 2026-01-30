<?php
session_start();
include "config/db.php";

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    header("Location: cart.php");
    exit;
}

$shipping = 50;
$subtotal = 0;

foreach ($cart as $item) {
    $subtotal += $item['price'] * $item['qty'];
}

$total = $subtotal + $shipping;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Checkout</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        .checkout-section {
            background: #f6f6f6;
            padding: 40px 15px;
        }

        .checkout-container {
            max-width: 1100px;
            margin: auto;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .checkout-left,
        .checkout-right {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
        }

        .checkout-left h2,
        .checkout-right h3 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 6px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        /* UPDATED ORDER ITEM STYLE */
        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
            font-size: 15px;
        }

        .order-item .product-name {
            font-weight: 500;
        }

        .order-item .product-total {
            white-space: nowrap;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }

        .summary-row.total {
            font-weight: bold;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .place-order-btn {
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

        @media (max-width: 768px) {
            .checkout-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <?php include("components/header.php"); ?>

    <section class="checkout-section">
        <div class="checkout-container">

            <!-- LEFT : CUSTOMER DETAILS -->
            <div class="checkout-left">
                <h2>Billing Details</h2>

                <form action="place-order.php" method="POST">

                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" required>
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" required>
                    </div>

                    <div class="form-group">
                        <label>Shipping Address</label>
                        <textarea name="address" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Order Notes (Optional)</label>
                        <textarea name="notes" rows="3"></textarea>
                    </div>

                    <button class="place-order-btn">Place Order</button>

                </form>
            </div>

            <!-- RIGHT : ORDER SUMMARY -->
            <div class="checkout-right">
                <h3>Your Order</h3>

                <?php foreach ($cart as $item) { ?>
                    <div class="order-item">
                        <div class="product-name">
                            <?= htmlspecialchars($item['name']); ?>
                        </div>

                        <div class="product-total">
                            ₹ <?= $item['price']; ?> × <?= $item['qty']; ?>
                        </div>
                    </div>
                <?php } ?>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>₹ <?= $subtotal; ?></span>
                </div>

                <div class="summary-row">
                    <span>Shipping</span>
                    <span>₹ <?= $shipping; ?></span>
                </div>

                <div class="summary-row total">
                    <span>Total</span>
                    <span>₹ <?= $total; ?></span>
                </div>
                <!-- <button class="place-order-btn">Place Order</button> -->
                <!-- <a href="place-order.php" class="place-order-btn">Place Order</a> -->
            </div>

        </div>
    </section>

    <?php include("components/footer.php"); ?>

</body>

</html>