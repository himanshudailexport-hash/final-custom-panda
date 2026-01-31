<?php
include "../config/db.php";

require_once "../config/env.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../config/mailer/PHPMailer.php";
require "../config/mailer/SMTP.php";
require "../config/mailer/Exception.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $hash  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // 1️⃣ Generate email verification token
    $token = bin2hex(random_bytes(32));
    $tokenHash = hash('sha256', $token);
    $expires = date('Y-m-d H:i:s', strtotime('+24 hours'));

    // 2️⃣ Insert user as UNVERIFIED
    $stmt = $conn->prepare(
        "INSERT INTO users 
        (name, email, password, email_verification_token, email_verification_expires) 
        VALUES (?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "sssss",
        $name,
        $email,
        $hash,
        $tokenHash,
        $expires
    );

    if ($stmt->execute()) {

        // 3️⃣ Send verification email

        $verifyLink = "http://localhost/custom-panda-main/auth/verify-email.php?token=$token";


        $mail = new PHPMailer(true);

        try {

            


            $mail->isSMTP();
            $mail->Host = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USERNAME'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $_ENV['MAIL_PORT'];

            $mail->setFrom(
                $_ENV['MAIL_FROM_EMAIL'],
                $_ENV['MAIL_FROM_NAME']
            );

            $mail->addAddress($email, $name);
            $mail->isHTML(true);
            $mail->Subject = 'Verify your email';
            $mail->Body = "
                Hi $name,<br><br>
                Please verify your email by clicking the link below:<br><br>
                <a href='$verifyLink'>Verify Email</a><br><br>
                This link expires in 24 hours.
            ";

            $mail->send();
        } catch (Exception $e) {
            error_log("Mailer Error: " . $mail->ErrorInfo);
        }

        // 4️⃣ Redirect to check-email page
        header("Location: check-email.php");
        exit;
    }

    $error = "Email already exists";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Account</title>
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
    <div class="auth-bg">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-lg-5 col-md-7">

                    <div class="auth-card">
                        <h4 class="text-center mb-1">Create Account</h4>
                        <p class="text-center text-muted mb-4">
                            Join us and start shopping 🛒
                        </p>

                        <?php if ($error): ?>
                            <div class="alert alert-danger py-2">
                                <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" autocomplete="off">

                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text"
                                    name="name"
                                    class="form-control"
                                    required>
                            </div>

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
                                    minlength="6"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-auth w-100">
                                Create Account
                            </button>
                        </form>

                        <div class="text-center mt-3">
                            <small>
                                Already have an account?
                                <a href="login.php" class="auth-link">Login</a>
                            </small>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include '../components/footer.php' ?>

</body>

</html>