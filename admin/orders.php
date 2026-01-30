<?php include("config/db.php"); ?>
<h2>Orders</h2>

<table border="1" cellpadding="10">
<tr><th>ID</th><th>Customer</th><th>Total</th><th>Status</th></tr>

<?php
$o = mysqli_query($conn,"SELECT * FROM orders");
while($r=mysqli_fetch_assoc($o)){
?>
<tr>
<td><?= $r['id'] ?></td>
<td><?= $r['customer'] ?></td>
<td>₹<?= $r['total'] ?></td>
<td><?= $r['status'] ?></td>
</tr>
<?php } ?>
</table>
