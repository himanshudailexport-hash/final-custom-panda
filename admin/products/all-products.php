<?php
require_once "../../config/db.php";

// Fetch all products
$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>

<head>
    <title>All Products</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        img {
            width: 60px;
            height: auto;
        }
    </style>
</head>

<body>

    <h2>All Products (Admin)</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>New Arrival</th>
                <th>Best Sales</th>
                <th>Trending</th>
                <th>Rating</th>
                <th>Created At</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>

            <?php if ($result->num_rows > 0) { ?>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>

                        <td>
                            <?php if (!empty($row['img1'])) { ?>
                                <img src="../../<?php echo $row['img1']; ?>">
                            <?php } else { ?>
                                No Image
                            <?php } ?>
                        </td>

                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td>₹<?php echo $row['price']; ?></td>
                        <td><?php echo $row['stock']; ?></td>

                        <td><?php echo $row['new_arrivals'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['best_sales'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['trending'] ? 'Yes' : 'No'; ?></td>

                        <td><?php echo $row['rating']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>

                        <td>
                            <a href="../products/update-product.php?id=<?= $row['id']; ?>">
                                Update
                            </a>
                        </td>

                        <td>
                            <a href="../products/delete-product.php?id=<?= $row['id']; ?>"
                               onclick="return confirm('Are you sure?')">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="13">No products found</td>
                </tr>
            <?php } ?>

        </tbody>
    </table>

</body>

</html>
