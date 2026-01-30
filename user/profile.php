<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$success = "";
$error   = "";


$stmt = $conn->prepare("SELECT name, email, phone FROM users WHERE id=?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    die("User not found");
}

/* Update profile */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name  = trim($_POST['name']);
    $phone = trim($_POST['phone']);

    $newName  = $name !== '' ? $name : $user['name'];
    $newPhone = $phone !== '' ? $phone : $user['phone'];

    if ($newName === $user['name'] && $newPhone === $user['phone']) {
        $success = "No changes to update";
    } else {

        $stmt = $conn->prepare(
            "UPDATE users SET name=?, phone=? WHERE id=?"
        );
        $stmt->bind_param("ssi", $newName, $newPhone, $_SESSION['user_id']);

        if ($stmt->execute()) {
            $success = "Profile updated successfully";
            $user['name']  = $newName;
            $user['phone'] = $newPhone;
        } else {
            $error = "Update failed";
        }
    }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

        .profile-bg {
            background: linear-gradient(135deg, var(--off-white), var(--light-gray));
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .profile-card {
            background: var(--white);
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }

        .profile-card h4 {
            font-weight: 600;
            color: var(--dark-black);
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid var(--light-gray);
        }

        .form-control:focus {
            border-color: var(--primary-yellow);
            box-shadow: 0 0 0 2px rgba(249, 190, 8, .25);
        }

        .btn-profile {
            background: var(--primary-yellow);
            color: var(--dark-black);
            font-weight: 600;
            border-radius: 8px;
            padding: 10px;
        }

        .btn-profile:hover {
            background: var(--secondary-yellow);
        }
    </style>
</head>

<body>

    <?php include "../components/header.php"; ?>

    <div class="profile-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">

                    <div class="profile-card">
                        <h4 class="text-center mb-3">My Profile</h4>

                        <?php if ($success): ?>
                            <div class="alert alert-success py-2">
                                <?= htmlspecialchars($success) ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($error): ?>
                            <div class="alert alert-danger py-2">
                                <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST">

                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text"
                                    name="name"
                                    class="form-control"
                                    value="<?= htmlspecialchars($user['name'] ?? '') ?>"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email (readonly)</label>
                                <input type="email"
                                    class="form-control"
                                    value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                                    readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text"
                                    name="phone"
                                    class="form-control"
                                    value="<?= htmlspecialchars($user['phone'] ?? '') ?>">

                            </div>

                            <button type="submit" class="btn btn-profile w-100">
                                Update Profile
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include "../components/footer.php"; ?>

</body>

</html>