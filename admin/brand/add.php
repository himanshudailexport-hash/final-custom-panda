<?php
require_once "../../config/db.php";

$msg = "";

if (isset($_POST['submit'])) {

    $name = $_POST['name'];

    // Insert brand
    $stmt = $conn->prepare("INSERT INTO brands (name) VALUES (?)");
    $stmt->bind_param("s", $name);

    if ($stmt->execute()) {
        $msg = "Brand added successfully ✅";
    } else {
        $msg = "Failed to add brand ❌";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Brand</title>
</head>

<body>

    <h2>Add Brand</h2>

    <?php if ($msg) { ?>
        <p style="color:green;"><?php echo $msg; ?></p>
    <?php } ?>

    <form method="post">

        <input type="text" name="name" placeholder="Brand Name" required><br><br>

        <button type="submit" name="submit">Add Brand</button>

    </form>

</body>

</html>