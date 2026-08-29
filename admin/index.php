<?php

include "../includes/db.php";

// Statistics
$productCount = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM products"));

$orderCount['total'] = 0;
$customerCount['total'] = 0;
$revenue['total'] = 0;
?>

<?php include "includes/header.php"; ?>
<?php include "includes/sidebar.php"; ?>

<div class="main">

<?php include "includes/navbar.php"; ?>

<div class="content">

<h1>Dashboard</h1>

<div class="cards">

    <div class="card">

        <i class="fa-solid fa-box"></i>

        <h3>Total Products</h3>

        <h2><?= $productCount['total']; ?></h2>

    </div>

    <div class="card">

        <i class="fa-solid fa-cart-shopping"></i>

        <h3>Orders</h3>

        <h2><?= $orderCount['total']; ?></h2>

    </div>

    <div class="card">

        <i class="fa-solid fa-users"></i>

        <h3>Customers</h3>

        <h2><?= $customerCount['total']; ?></h2>

    </div>

    <div class="card">

        <i class="fa-solid fa-money-bill-wave"></i>

        <h3>Revenue</h3>

        <h2>Rs. <?= number_format($revenue['total'] ?? 0); ?></h2>

    </div>

</div>

<?php

$recent = mysqli_query(
    $conn,
    "SELECT *
     FROM products
     ORDER BY id DESC
     LIMIT 5"
);

?>

<h2>Recently Added Products</h2>

<table>

<tr>

<th>Image</th>

<th>Product</th>

<th>Category</th>

<th>Section</th>

<th>Price</th>

<th>Stock</th>

</tr>

<?php while($row = mysqli_fetch_assoc($recent)){ ?>

<tr>

<td>

<img
    src="../uploads/products/<?= htmlspecialchars($row['image']); ?>"
    alt="<?= htmlspecialchars($row['product_name']); ?>"
>

</td>

<td>

<?= htmlspecialchars($row['product_name']); ?>

</td>

<td>

<?= htmlspecialchars($row['category']); ?>

</td>

<td>

<?php

if ($row['section'] === 'every_generation') {

    echo 'Every Generation';

}

elseif ($row['section'] === 'school') {

    echo 'Back to School';

}

elseif ($row['section'] === 'new_arrival') {

    echo 'New Arrivals';

}

else {

    echo 'Not Assigned';

}

?>

</td>

<td>

Rs. <?= number_format($row['price']); ?>

</td>

<td>

<?= $row['stock']; ?>

</td>

</tr>

<?php } ?>

</table>

<?php

$low = mysqli_query($conn,

"SELECT *

FROM products

WHERE stock<=5");

?>

<h2>Low Stock</h2>

<table>

<tr>

<th>Product</th>

<th>Stock</th>

</tr>

<?php while($row=mysqli_fetch_assoc($low)){ ?>

<tr>

<td><?= $row['product_name']; ?></td>

<td>

<span class="stock-red">

<?= $row['stock']; ?>

</span>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

<?php include "includes/footer.php"; ?>