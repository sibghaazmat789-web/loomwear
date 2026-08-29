<?php
include "includes/db.php";
?>

<!DOCTYPE html>
<html>
<head>

<title>Men | LoomWear</title>

<link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/product-details.css">
    <link rel="stylesheet" href="assets/css/cart.css">
    <link rel="stylesheet" href="assets/css/wishlist.css">
    <link rel="stylesheet" href="assets/css/checkout.css">


</head>

<body>

<?php include "includes/header.php"; ?>

<section class="women-subcategories">

    <div class="section-heading">
        <span>SHOP WOMEN</span>
        <h2>Women's Clothing</h2>
    </div>

    <div class="subcategory-grid">

        <!-- Shop All -->
        <a href="shop.php?category=Women" class="subcategory-card">
            <img src="assets/images/women/shop-all-women.jfif" alt="Shop All Women's Clothing">
            <h3>Shop All</h3>
        </a>

        <!-- Dresses -->
        <a href="shop.php?category=Women&subcategory=Dresses" class="subcategory-card">
            <img src="assets/images/women/dresses.jfif" alt="Women's Dresses">
            <h3>Dresses</h3>
        </a>

        <!-- Tops -->
        <a href="shop.php?category=Women&subcategory=Tops" class="subcategory-card">
            <img src="assets/images/women/tops.jfif" alt="Women's Tops">
            <h3>Tops</h3>
        </a>

        <!-- Jeans -->
        <a href="shop.php?category=Women&subcategory=Jeans" class="subcategory-card">
            <img src="assets/images/women/jeans-women.jfif" alt="Women's Jeans">
            <h3>Jeans</h3>
        </a>

        <!-- Pants -->
        <a href="shop.php?category=Women&subcategory=Pants" class="subcategory-card">
            <img src="assets/images/women/pants-woemn.jfif" alt="Women's Pants">
            <h3>Pants</h3>
        </a>

        <!-- Skirts -->
        <a href="shop.php?category=Women&subcategory=Skirts" class="subcategory-card">
            <img src="assets/images/women/skirts.jfif" alt="Women's Skirts">
            <h3>Skirts</h3>
        </a>

        <!-- Shirts & Blouses -->
        <a href="shop.php?category=Women&subcategory=Shirts%20%26%20Blouses" class="subcategory-card">
            <img src="assets/images/women/shirts and blouses.jfif" alt="Women's Shirts and Blouses">
            <h3>Shirts &amp; Blouses</h3>
        </a>

        <!-- Sweaters -->
        <a href="shop.php?category=Women&subcategory=Sweaters" class="subcategory-card">
            <img src="assets/images/women/sweaters-women.jfif" alt="Women's Sweaters">
            <h3>Sweaters</h3>
        </a>

        <!-- Hoodies & Sweatshirts -->
        <a href="shop.php?category=Women&subcategory=Hoodies%20%26%20Sweatshirts" class="subcategory-card">
            <img src="assets/images/women/hoodies and sweatshirts.jfif" alt="Women's Hoodies and Sweatshirts">
            <h3>Hoodies &amp; Sweatshirts</h3>
        </a>

        <!-- Outerwear -->
        <a href="shop.php?category=Women&subcategory=Outerwear" class="subcategory-card">
            <img src="assets/images/women/outerwear-women.jfif" alt="Women's Outerwear">
            <h3>Outerwear</h3>
        </a>

        <!-- Activewear -->
        <a href="shop.php?category=Women&subcategory=Activewear" class="subcategory-card">
            <img src="assets/images/women/activewear.jfif" alt="Women's Activewear">
            <h3>Activewear</h3>
        </a>

        <!-- Accessories -->
        <a href="shop.php?category=Women&subcategory=Accessories" class="subcategory-card">
            <img src="assets/images/women/accessories-w.jfif" alt="Women's Accessories">
            <h3>Accessories</h3>
        </a>

    </div>

</section>

<!-- ==========================================
     WOMEN VIDEO AD
=========================================== -->

<section class="women-video-banner">

    <video autoplay muted loop playsinline>
        <source src="assets/videos/women.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="women-video-content">

        <span>LOOMWEAR WOMEN</span>

        <h2>Style Made For You</h2>

        <p>
            Discover effortless looks designed for every moment.
        </p>

        <a href="shop.php?category=Women">
            Shop Women
        </a>

    </div>

</section>

<?php
include "includes/db.php";

$query = "SELECT * FROM products
          WHERE category='Women'
          AND section='every_generation'
          ORDER BY id DESC
          LIMIT 8";

$result = mysqli_query($conn, $query);
?>

<!-- ==========================================
     WOMEN NEW ARRIVALS
=========================================== -->

<section class="new-arrivals women-new-arrivals">

    <div class="section-heading">

        <span>FEATURED PRODUCTS</span>

        <h2>Shop Our Collections</h2>

    </div>


    <div class="arrival-slider">

        <button class="slider-btn prev" onclick="slideWomenPrev()">
            ❮
        </button>


        <div class="product-track" id="womenProductSlider">

            <?php

            $query = "SELECT * FROM products
          WHERE category='Women'
          AND section='every_generation'
          ORDER BY id DESC
          LIMIT 8";

            $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result) > 0){

                while($product = mysqli_fetch_assoc($result)){

            ?>

            <a href="product-details.php?id=<?= $product['id']; ?>"
               class="product-card">


                <div class="product-image">

                    <img
                        src="uploads/products/<?= htmlspecialchars($product['image']); ?>"
                        alt="<?= htmlspecialchars($product['product_name']); ?>"
                    >


                    <?php if(!empty($product['badge'])){ ?>

                        <span class="badge">
                            <?= htmlspecialchars($product['badge']); ?>
                        </span>

                    <?php } ?>

                </div>


                <h4>
                    <?= htmlspecialchars($product['product_name']); ?>
                </h4>


                <p>
                    <?= htmlspecialchars($product['gender']); ?>
                </p>


                <span class="price">
                    Rs. <?= number_format($product['price']); ?>
                </span>


            </a>

            <?php

                }

            }else{

            ?>

                <div class="no-products">
                    <p>No women's products have been added yet.</p>
                </div>

            <?php } ?>

        </div>


        <button class="slider-btn next" onclick="slideWomenNext()">
            ❯
        </button>

    </div>

</section>

<script src="assets/js/main.js"></script>

<?php include "includes/footer.php"; ?>


</body>
</html>