<?php
require_once "../../config/db.php";

if (!isset($_GET['id'])) {
    die("Brand ID missing");
}

$id = $_GET['id'];
$msg = "";

// Fetch existing brand
$stmt = $conn->prepare("SELECT * FROM brands WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$brand = $result->fetch_assoc();

if (!$brand) {
    die("Brand not found");
}

// Update brand
if (isset($_POST['submit'])) {

    $name = $_POST['name'];

    $stmt = $conn->prepare("UPDATE brands SET name=? WHERE id=?");
    $stmt->bind_param("si", $name, $id);

    if ($stmt->execute()) {
        $msg = "Brand updated successfully ✅";
    } else {
        $msg = "Failed to update brand ❌";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Update Brand</title>
</head>

<body>

    <h2>Update Brand</h2>

    <?php if ($msg) { ?>
        <p style="color:green;"><?php echo $msg; ?></p>
    <?php } ?>

    <form method="post">

        <input type="text"
            name="name"
            value="<?php echo htmlspecialchars($brand['name']); ?>"
            required><br><br>

        <button type="submit" name="submit">Update Brand</button>

    </form>

</body>

</html>