<?php
include "../config/db.php";
session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare(
        "SELECT id, password FROM users WHERE email=?"
    );
    $stmt->bind_param("s", $_POST['email']);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($_POST['password'], $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        header("Location: ../user/index.php");
        exit;
    }

    $error = "Invalid email or password";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
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

        .auth-bg {
            background: linear-gradient(135deg, var(--off-white), var(--light-gray));
            font-family: system-ui, -apple-system, sans-serif;
        }

        .auth-card {
            background: var(--white);
            padding: 30px 28px;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }

        .auth-card h4 {
            color: var(--dark-black);
            font-weight: 600;
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
            color: var(--dark-black);
            font-weight: 600;
            padding: 10px;
            border-radius: 8px;
            border: none;
        }

        .btn-auth:hover {
            background: var(--secondary-yellow);
            color: var(--dark-black);
        }

        .auth-link {
            color: var(--dark-sky);
            text-decoration: none;
            font-weight: 500;
        }

        .auth-link:hover {
            text-decoration: underline;
        }

        .alert {
            border-radius: 8px;
            font-size: 14px;
        }
    </style>
</head>



<body>

    <?php include '../components/header.php' ?>

    <div class="auth-bg py-5">
        <div class="container">
            <div class="row justify-content-center align-items-center ">
                <div class="col-lg-5 col-md-7">

                    <div class="auth-card">
                        <h4 class="text-center mb-1">Welcome Back</h4>
                        <p class="text-center text-muted mb-4">
                            Login to your account 👋
                        </p>

                        <?php if ($error): ?>
                            <div class="alert alert-danger py-2">
                                <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" autocomplete="off">

                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email"
                                    name="email"
                                    class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password"
                                    name="password"
                                    class="form-control"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-auth w-100">
                                Login
                            </button>
                        </form>

                        <div class="text-center mt-3">
                            <small>
                                Don’t have an account?
                                <a href="sign-up.php" class="auth-link">Create one</a>
                            </small>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include '../components/Footer.php' ?>
</body>

</html>