<?php include("../../config/db.php"); ?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex justify-content-center align-items-center" style="height:100vh;">

   

    <div class="card p-4 shadow" style="width:380px;">
        <h4 class="text-center mb-3">Admin Login</h4>

        <?php
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $q = mysqli_query($conn, "SELECT * FROM admin WHERE email='$email'");
            $admin = mysqli_fetch_assoc($q);

            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin'] = $admin['email'];
                header("Location: ../admin-dashboard.php");
            } else {
                echo "<div class='alert alert-danger'>Invalid Login</div>";
            }
        }
        ?>

        <form method="POST">
            <input class="form-control mb-3" name="email" placeholder="Email" required>
            <input class="form-control mb-3" type="password" name="password" placeholder="Password" required>
            <button class="btn btn-primary w-100" name="login">Login</button>
        </form>
    </div>

</body>

</html>