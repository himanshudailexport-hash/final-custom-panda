<?php
require_once "../../config/db.php";

$msg = "";

if (isset($_POST['submit'])) {

    $name = $_POST['name'];

    
    $uploadDir = "../../uploads/categories/";

    
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    
    $imgName = $_FILES['img']['name'];
    $tmpName = $_FILES['img']['tmp_name'];

    $newImgName = time() . "_" . $imgName;

    
    $imgPath = "uploads/categories/" . $newImgName;

    
    move_uploaded_file($tmpName, "../../" . $imgPath);

    
    $stmt = $conn->prepare("INSERT INTO categories (name, img) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $imgPath);

    if ($stmt->execute()) {
        $msg = "Category added successfully ";
    } else {
        $msg = "Failed to add category ";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>
</head>
<body>

    <h2>Add Category</h2>

    <?php if ($msg) { ?>
        <p style="color:green;"><?php echo $msg; ?></p>
    <?php } ?>

    <form method="post" enctype="multipart/form-data">

        <input type="text" name="name" placeholder="Category Name" required><br><br>

        <input type="file" name="img" required><br><br>

        <button type="submit" name="submit">Add Category</button>

    </form>

</body>
</html>
