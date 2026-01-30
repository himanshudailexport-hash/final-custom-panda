<?php
include "../config/db.php";
$msg = "";

if (isset($_POST['signup'])) {

    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM admin WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $msg = "Email already exists ❌";
    } else {
        $stmt = $conn->prepare("INSERT INTO admin (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $password);

        if ($stmt->execute()) {
            $msg = "Admin signup successful ✅";
        } else {
            $msg = "Signup failed ❌";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Signup</title>
</head>
<body>

<h2>Admin Signup</h2>
<p style="color:green;"><?php echo $msg; ?></p>

<form method="post">
    <input type="email" name="email" placeholder="Admin Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="signup">Signup</button>
</form>

</body>
</html>
