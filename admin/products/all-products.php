<?php
require_once "../../config/db.php";

$result = $conn->query("
  SELECT p.*, c.name AS category_name
  FROM products p
  LEFT JOIN categories c ON p.category_id = c.id
  ORDER BY p.id DESC
");
?>

<div class="all-products">
  <h2 class="text-center mb-0">All Products</h2>

  <table>
    <thead>
      <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Category</th>
        <th>Price</th>
        <th>Stock</th>
        <th>New Arrival</th>
        <th>Best Sales</th>
        <th>Trending</th>
        <th>Rating</th>
        <th>Listing</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>

    <tbody>
      <?php if ($result->num_rows > 0) { ?>
        <?php while ($row = $result->fetch_assoc()) { ?>
          <tr>
            
            <td>
              <?php if (!empty($row['img1'])) { ?>
                <img src="../uploads/products/<?= $row['img1']; ?>" alt="">
              <?php } else { ?>
                No Image
              <?php } ?>
            </td>
            <td><?= htmlspecialchars($row['name']); ?></td>
            <td><?= htmlspecialchars($row['category_name']); ?></td>
            <td>₹<?= $row['price']; ?></td>
            <td><?= $row['stock']; ?></td>
            <td><?= $row['new_arrivals'] ? 'Yes' : 'No'; ?></td>
            <td><?= $row['best_sales'] ? 'Yes' : 'No'; ?></td>
            <td><?= $row['trending'] ? 'Yes' : 'No'; ?></td>
            <td><?= $row['rating']; ?></td>
            <td><?= $row['created_at']; ?></td>
            <td>
              <a href="#" class="load-page"
                 data-page="products/update-product.php?id=<?= $row['id']; ?>">
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
          <td colspan="13" style="text-align:center;">No products found</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
