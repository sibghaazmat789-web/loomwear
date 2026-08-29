
<?php

include "includes/db.php";


// Get search query
$search = isset($_GET['q']) ? trim($_GET['q']) : '';


// Prevent empty search
if ($search === '') {
    header("Location: shop.php");
    exit;
}


// Escape search text
$search_safe = mysqli_real_escape_string($conn, $search);


// Search products
$query = "SELECT * FROM products
          WHERE product_name LIKE '%$search_safe%'
          OR category LIKE '%$search_safe%'
          OR sub_category LIKE '%$search_safe%'
          OR description LIKE '%$search_safe%'
          OR gender LIKE '%$search_safe%'
          ORDER BY id DESC";


$result = mysqli_query($conn, $query);


if (!$result) {
    die("Search error: " . mysqli_error($conn));
}

?>


<?php include "includes/header.php"; ?>


<main class="search-page">

    <section class="search-results-section">

        <div class="section-heading">

            <span>LOOMWEAR SEARCH</span>

            <h1>
                Search Results
            </h1>

            <p>
                Results for:
                <strong>"<?= htmlspecialchars($search); ?>"</strong>
            </p>

        </div>


        <div class="product-grid">


            <?php if (mysqli_num_rows($result) > 0): ?>


                <?php while ($product = mysqli_fetch_assoc($result)): ?>


                    <a 
                        href="product-details.php?id=<?= $product['id']; ?>" 
                        class="product-card"
                    >

                        <div class="product-image">

                            <?php if (!empty($product['image'])): ?>

                                <img 
                                    src="uploads/products/<?= htmlspecialchars($product['image']); ?>" 
                                    alt="<?= htmlspecialchars($product['product_name']); ?>"
                                >

                            <?php else: ?>

                                <div class="no-image">
                                    No Image
                                </div>

                            <?php endif; ?>


                            <?php if (!empty($product['badge'])): ?>

                                <span class="product-badge">
                                    <?= htmlspecialchars($product['badge']); ?>
                                </span>

                            <?php endif; ?>

                        </div>


                        <div class="product-info">

                            <h3>
                                <?= htmlspecialchars($product['product_name']); ?>
                            </h3>


                            <?php if (!empty($product['gender'])): ?>

                                <p class="product-gender">
                                    <?= htmlspecialchars($product['gender']); ?>
                                </p>

                            <?php endif; ?>


                            <div class="product-price">

                                <?php if (!empty($product['old_price']) && $product['old_price'] > $product['price']): ?>

                                    <span class="old-price">
                                        Rs. <?= number_format($product['old_price']); ?>
                                    </span>

                                <?php endif; ?>


                                <span class="current-price">
                                    Rs. <?= number_format($product['price']); ?>
                                </span>

                            </div>

                        </div>

                    </a>


                <?php endwhile; ?>


            <?php else: ?>


                <div class="no-search-results">

                    <div class="no-results-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>

                    <h2>
                        No products found
                    </h2>

                    <p>
                        We couldn't find anything matching
                        "<strong><?= htmlspecialchars($search); ?></strong>".
                    </p>

                    <a href="shop.php" class="continue-shopping">
                        Continue Shopping
                    </a>

                </div>


            <?php endif; ?>


        </div>

    </section>

</main>


<?php include "includes/footer.php"; ?>

