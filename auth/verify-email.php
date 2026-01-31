<?php
include "../config/db.php";

$token = $_GET['token'] ?? '';

if (!$token) {
    header("Location: login.php?error=invalid_link");
    exit;
}

$tokenHash = hash('sha256', $token);

// Check if token exists and is valid
$stmt = $conn->prepare(
    "SELECT id, email_verified FROM users
     WHERE email_verification_token = ?
     AND email_verification_expires > NOW()"
);
$stmt->bind_param("s", $tokenHash);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {

    // If already verified
    if ($user['email_verified']) {
        header("Location: login.php?message=already_verified");
        exit;
    }

    // Verify email
    $update = $conn->prepare(
        "UPDATE users
         SET email_verified = 1,
             email_verification_token = NULL,
             email_verification_expires = NULL
         WHERE id = ?"
    );
    $update->bind_param("i", $user['id']);
    $update->execute();

    header("Location: login.php?message=verified");
    exit;

} else {
    header("Location: login.php?error=expired");
    exit;
}
