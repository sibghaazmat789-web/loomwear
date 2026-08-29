<?php
session_start();

include "includes/db.php";
include "includes/header.php";

$session_id = session_id();

$query = mysqli_query($conn, "
SELECT wishlist.id,
products.*
FROM wishlist
JOIN products
ON wishlist.product_id = products.id
WHERE wishlist.session_id='$session_id'
");
?>

<div class="wishlist-page">

    <h1>My Wishlist</h1>

    <?php if(mysqli_num_rows($query) > 0){ ?>

    <div class="wishlist-grid">

        <?php while($product = mysqli_fetch_assoc($query)){ ?>
<div class="wishlist-card">

    <img src="uploads/products/<?= htmlspecialchars($product['image']); ?>"
         alt="<?= htmlspecialchars($product['product_name']); ?>">

    <h3>
        <?= htmlspecialchars($product['product_name']); ?>
    </h3>

    <p class="price">
        Rs. <?= number_format($product['price']); ?>
    </p>

    <a href="product-details.php?id=<?= $product['id']; ?>" class="view-btn">
        View Product
    </a>

    <a href="wishlist-remove.php?id=<?= $product['id']; ?>" class="remove-btn">
        Remove
    </a>

</div>
        <?php } ?>

    </div>

    <?php } else { ?>

    <h3>Your Wishlist is Empty</h3>

    <a href="index.php" class="continue-btn">
    Continue Shopping
</a>

    <?php } ?>

</div>

<?php include "includes/footer.php"; ?>