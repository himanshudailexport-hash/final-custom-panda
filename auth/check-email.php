<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Check Your Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
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
            --dark-gray: #555;
        }

        body {
            background: linear-gradient(135deg, var(--off-white), var(--light-gray));
            font-family: system-ui, -apple-system, sans-serif;
        }

        .email-card {
            background: var(--white);
            padding: 32px 28px;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
            text-align: center;
        }

        .email-icon img{
            font-size: 48px;
            color: var(--dark-sky);
            border: none;
            width: 30px;
            height: 30px;
        }

        .email-card h4 {
            color: var(--dark-black);
            font-weight: 600;
            margin-top: 12px;
        }

        .email-card p {
            color: var(--dark-gray);
            font-size: 15px;
            margin-top: 10px;
        }

        .btn-email {
            background: var(--primary-yellow);
            color: var(--dark-black);
            font-weight: 600;
            padding: 10px;
            border-radius: 8px;
            border: none;
            text-decoration: none;
            display: inline-block;
            width: 100%;
        }

        .btn-email:hover {
            background: var(--secondary-yellow);
            color: var(--dark-black);
        }

        .hint-text {
            font-size: 13px;
            color: var(--dark-gray);
            margin-top: 14px;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-lg-5 col-md-7">

            <div class="email-card">
                <!-- <div class="email-icon">📧</div> -->

                <div class="email-icon">
                    <img src="../assets/img/gmail.png" alt="">
                </div>

                <h4>Check your inbox</h4>

                <p>
                    We’ve sent a verification link to your email address.<br>
                    Please verify your account before logging in.
                </p>

                <!-- Button to open email -->
                <a href="https://mail.google.com" target="_blank" class="btn-email mt-3">
                    Go to Email
                </a>

                <div class="hint-text">
                    Didn’t receive the email? Check your spam folder.
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
