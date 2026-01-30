<?php
require_once "../../config/db.php";

// Fetch all brands
$result = $conn->query("SELECT * FROM brands ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>

<head>
    <title>All Brands</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
        }
    </style>
</head>

<body>

    <h2>All Brands</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Brand Name</th>
            <th>Created At</th>
        </tr>

        <?php if ($result->num_rows > 0) { ?>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="3">No brands found</td>
            </tr>
        <?php } ?>
    </table>

</body>

</html>