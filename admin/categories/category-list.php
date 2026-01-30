<?php
require_once "../../config/db.php";

// Fetch all categories
$result = $conn->query("SELECT id, name, img FROM categories ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Categories</title>

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        img {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }
        a button {
            padding: 6px 12px;
            cursor: pointer;
        }
    </style>
</head>

<body>

<h2>All Categories</h2>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') { ?>
    <p style="color:green;">Category deleted successfully </p>
<?php } ?>

<table>
    <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Name</th>
        <th>Actions</th>
    </tr>

    <?php if ($result->num_rows > 0) { ?>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>

                <td>
                    <?php if (!empty($row['img'])) { ?>
                        <img src="../../<?= $row['img'] ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                    <?php } else { ?>
                        No Image
                    <?php } ?>
                </td>

                <td><?= htmlspecialchars($row['name']) ?></td>

                <td>
                    <!-- UPDATE -->
                    <a href="update.php?id=<?= $row['id'] ?>">
                        <button type="button">Update</button>
                    </a>

                    <!-- DELETE -->
                    <a href="delete.php?id=<?= $row['id'] ?>"
                       onclick="return confirm('Are you sure you want to delete this category?');">
                        <button type="button">Delete</button>
                    </a>
                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
            <td colspan="4">No categories found</td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
