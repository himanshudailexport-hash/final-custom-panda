<?php
include "../config/db.php";
require_once "../config/env.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../config/mailer/PHPMailer.php";
require "../config/mailer/SMTP.php";
require "../config/mailer/Exception.php";

date_default_timezone_set('Asia/Kolkata'); 

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT id, name FROM users WHERE email=? AND email_verified=1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user) {

        $token = bin2hex(random_bytes(32));
        $tokenHash = hash('sha256', $token);
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $update = $conn->prepare(
            "UPDATE users SET reset_token=?, reset_token_expires=? WHERE id=?"
        );
        $update->bind_param("ssi", $tokenHash, $expires, $user['id']);
        $update->execute();

        $resetLink = "http://localhost/custom-panda-main/auth/reset-password.php?token=$token";

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USERNAME'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $_ENV['MAIL_PORT'];

            $mail->setFrom($_ENV['MAIL_FROM_EMAIL'], $_ENV['MAIL_FROM_NAME']);
            $mail->addAddress($email, $user['name']);

            $mail->isHTML(true);
            $mail->Subject = 'Reset your password';
            $mail->Body = "
                Hi {$user['name']},<br><br>
                Click below to reset your password:<br><br>
                <a href='$resetLink'>Reset Password</a><br><br>
                This link expires in 1 hour.
            ";

            $mail->send();
        } catch (Exception $e) {}

    }

    $msg = "If the email exists, a reset link has been sent.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-yellow: #f9be08;
            --secondary-yellow: #ffce00;
            --white: #fff;
            --off-white: #f9f8f4;
            --light-gray: #dfdfd9;
            --dark-black: #1a1a19;
            --dark-sky: #088178;
        }

        .auth-bg {
            background: linear-gradient(135deg, var(--off-white), var(--light-gray));
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .auth-card {
            background: var(--white);
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
        }

        .btn-auth {
            background: var(--primary-yellow);
            font-weight: 600;
            border-radius: 8px;
        }
        .btn-auth:hover {
            background: var(--secondary-yellow);
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
    </style>
</head>

<body>

<div class="auth-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <div class="auth-card">
                    <h4 class="text-center mb-2">Forgot Password 🔐</h4>
                    <p class="text-center text-muted mb-4">
                        Enter your email to receive a reset link
                    </p>

                    <?php if ($msg): ?>
                        <div class="alert alert-success text-center">
                            <?= htmlspecialchars($msg) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   required>
                        </div>

                        <button class="btn btn-auth w-100">
                            Send Reset Link
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="login.php" style="color: var(--dark-sky);">
                            Back to login
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>

