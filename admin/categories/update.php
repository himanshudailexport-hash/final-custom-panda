<?php
require_once "../../config/db.php";

if (!isset($_GET['id'])) {
    die("Category ID missing");
}

$id = $_GET['id'];
$msg = "";


$stmt = $conn->prepare("SELECT * FROM categories WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$category = $result->fetch_assoc();

if (!$category) {
    die("Category not found");
}


if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $imgPath = $category['img'];

    
    $uploadDir = "../../uploads/categories/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    
    if (!empty($_FILES['img']['name'])) {

        
        if (!empty($category['img']) && file_exists("../../" . $category['img'])) {
            unlink("../../" . $category['img']);
        }

        $newImgName = time() . "_" . $_FILES['img']['name'];

        
        $imgPath = "uploads/categories/" . $newImgName;

        
        move_uploaded_file($_FILES['img']['tmp_name'], "../../" . $imgPath);
    }

    
    $stmt = $conn->prepare("UPDATE categories SET name=?, img=? WHERE id=?");
    $stmt->bind_param("ssi", $name, $imgPath, $id);

    if ($stmt->execute()) {
        $msg = "Category updated successfully ";

        $category['name'] = $name;
        $category['img']  = $imgPath;
    } else {
        $msg = "Failed to update category ";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Category</title>
</head>

<body>

<h2>Update Category</h2>

<?php if ($msg) { ?>
    <p style="color:green;"><?php echo $msg; ?></p>
<?php } ?>

<form method="post" enctype="multipart/form-data">

    <input type="text" name="name"
        value="<?php echo htmlspecialchars($category['name']); ?>"
        required><br><br>

    <p>Current Image:</p>
    <img src="../../<?php echo $category['img']; ?>" width="120"><br><br>

    <input type="file" name="img"><br><br>

    <button type="submit" name="submit">Update Category</button>

</form>

</body>
</html>
