<?php
$orderNumber = $_GET['order'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Placed Successfully</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        .success-section {
            min-height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f6f6f6;
        }

        .success-box {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            text-align: center;
            max-width: 500px;
        }

        .success-box h2 {
            color: #28a745;
            margin-bottom: 10px;
        }

        .success-box p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .success-box a {
            display: inline-block;
            text-decoration: none;
            background: #0a7cff;
            color: #fff;
            padding: 10px 18px;
            border-radius: 6px;
        }
    </style>
</head>

<body>

    <?php include("components/header.php"); ?>

    <section class="success-section">
        <div class="success-box">
            <h2>🎉 Order Placed Successfully!</h2>
            <p>Your order number is:</p>
            <h4><?= htmlspecialchars($orderNumber); ?></h4>
            <p>We will contact you shortly for confirmation.</p>

            <a href="shop.php">Continue Shopping</a>
        </div>
    </section>

    <?php include("components/footer.php"); ?>

</body>

</html>