<?php
include "../config/db.php";

date_default_timezone_set('Asia/Kolkata');

$success = false;
$error = "";

$token = $_GET['token'] ?? '';
if (!$token) {
    die("Invalid request");
}

$tokenHash = hash('sha256', $token);

$stmt = $conn->prepare(
    "SELECT id FROM users 
     WHERE reset_token = ? 
     AND reset_token_expires > NOW()"
);
$stmt->bind_param("s", $tokenHash);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    die("Link is invalid or expired");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['password'] !== $_POST['confirm_password']) {
        $error = "Passwords do not match";
    } else {

        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $update = $conn->prepare(
            "UPDATE users 
             SET password = ?, reset_token = NULL, reset_token_expires = NULL 
             WHERE id = ?"
        );
        $update->bind_param("si", $hash, $user['id']);
        $update->execute();

        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

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

        body {
            background: linear-gradient(135deg, var(--off-white), var(--light-gray));
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .auth-card {
            background: var(--white);
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, .08);
        }

        .auth-card .form-control {
            border-radius: 8px;
            padding: 10px 12px;
            border: 1px solid var(--light-gray);
        }

        .auth-card .form-control:focus {
            border-color: var(--primary-yellow);
            box-shadow: 0 0 0 2px rgba(249, 190, 8, .25);
        }

        .btn-auth {
            background: var(--primary-yellow);
            border: none;
            font-weight: 600;
            border-radius: 10px;
        }

        .btn-auth:hover {
            background: var(--secondary-yellow);
        }
        .password-toggle {
            position: absolute;
            right: 14px;
            top: 70%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--dark-gray);
            font-size: 16px;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .position-relative {
            position: relative;
        }

        .position-relative input {
            padding-right: 40px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <div class="auth-card">

                    <h4 class="text-center mb-2">Reset Your Password 🔒</h4>
                    <p class="text-center text-muted mb-4">
                        Create a strong new password
                    </p>

                    <?php if ($error): ?>
                        <div class="alert alert-danger text-center">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success text-center">
                             Password reset successfully!
                            <br>
                            <a href="login.php" class="fw-semibold" style="color: var(--dark-sky);">
                                Go to Login
                            </a>
                        </div>
                    <?php else: ?>

                        <form method="POST" onsubmit="return validatePasswords()">

                            <div class="mb-3 position-relative">
                                <label class="form-label">New Password</label>
                                <input type="password"
                                    id="password"
                                    name="password"
                                    class="form-control"
                                    minlength="6"
                                    required>
                                <i class="fa-solid fa-eye password-toggle"
                                    onclick="togglePassword('password', this)"></i>
                            </div>

                            <div class="mb-3 position-relative">
                                <label class="form-label">Confirm Password</label>
                                <input type="password"
                                    id="confirm_password"
                                    name="confirm_password"
                                    class="form-control"
                                    minlength="6"
                                    required>
                                <i class="fa-solid fa-eye password-toggle"
                                    onclick="togglePassword('confirm_password', this)"></i>
                            </div>

                            <button class="btn btn-auth w-100">
                                Reset Password
                            </button>

                        </form>

                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId, icon) {
            const input = document.getElementById(fieldId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }

        function validatePasswords() {
            const p1 = document.getElementById("password").value;
            const p2 = document.getElementById("confirm_password").value;

            if (p1 !== p2) {
                alert("Passwords do not match");
                return false;
            }
            return true;
        }
    </script>

</body>

</html>