<?php
session_start();
include_once __DIR__ . "/../config/db.php";

/* Protect dashboard */
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

/* Fetch user */
$stmt = $conn->prepare("SELECT name, email, phone, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

/* Safety fallback */
if (!$user) {
    session_destroy();
    header("Location: ../auth/login.php");
    exit;
}
?>


<?php include "../components/header.php"; ?>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="../assets/css/style.css">

<style>
    :root {
        --primary-yellow: #f9be08;
        --secondary-yellow: #ffce00;
        --white: #fff;
        --off-white: #f9f8f4;
        --light-gray: #dfdfd9;
        --dark-black: #1a1a19;
        --dark-sky: #088178;
        --dark-gray: #555;
    }

    .dashboard-card {
        background: var(--white);
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, .06);
        padding: 20px;
    }

    .user-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: var(--primary-yellow);
        color: var(--dark-black);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .order-status {
        font-size: 13px;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 500;
    }

    .status-delivered {
        background: #e6f6f2;
        color: var(--dark-sky);
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }
</style>

<div class="container my-5">
    <div class="row g-4">

        <a href="../index.php" class="text-center">Shop more</a>
        <!-- LEFT: USER DETAILS -->
        <div class="col-lg-4">
            <div class="dashboard-card text-center">

                <div class="user-avatar">
                    <?= strtoupper(substr($user['name'], 0, 1)) ?>
                </div>

                <h5 class="mb-1">
                    <?= htmlspecialchars($user['name']) ?>
                </h5>

                <p class="text-muted mb-2">
                    <?= htmlspecialchars($user['email']) ?>
                </p>

                <hr>

                <p class="mb-1">
                    <strong>Phone:</strong>
                    <?= $user['phone'] ? htmlspecialchars($user['phone']) : 'Not added' ?>
                </p>

                <p class="mb-3">
                    <strong>Member Since:</strong>
                    <?= date("M Y", strtotime($user['created_at'])) ?>
                </p>

                <a href="profile.php"
                    class="btn btn-sm w-100"
                    style="background: var(--primary-yellow); font-weight: 600;">
                    Edit Profile
                </a>
            </div>
        </div>


        <!-- RIGHT: USER ORDERS -->
        <div class="col-lg-8">
            <div class="dashboard-card">
                <h5 class="mb-3">My Orders</h5>

                <!-- Order Item -->
                <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                    <div>
                        <strong>Order #1023</strong>
                        <div class="text-muted small">Placed on 12 Feb 2025</div>
                    </div>
                    <div>
                        <span class="order-status status-delivered">Delivered</span>
                        <div class="fw-semibold mt-1">₹2,499</div>
                    </div>
                </div>

                <!-- Order Item -->
                <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                    <div>
                        <strong>Order #1022</strong>
                        <div class="text-muted small">Placed on 05 Feb 2025</div>
                    </div>
                    <div>
                        <span class="order-status status-pending">Pending</span>
                        <div class="fw-semibold mt-1">₹1,299</div>
                    </div>
                </div>

                <!-- Order Item -->
                <div class="d-flex justify-content-between align-items-center py-3">
                    <div>
                        <strong>Order #1021</strong>
                        <div class="text-muted small">Placed on 28 Jan 2025</div>
                    </div>
                    <div>
                        <span class="order-status status-delivered">Delivered</span>
                        <div class="fw-semibold mt-1">₹3,199</div>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <a href="orders.php" class="btn btn-outline-secondary btn-sm">
                        View All Orders
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include "../components/footer.php"; ?>