<?php

include "includes/db.php";
include "includes/header.php";

?>

<!-- ==========================================
     GIRLS SUB CATEGORIES
=========================================== -->

<section class="girls-subcategories">

    <div class="section-heading">

        <span>SHOP GIRLS</span>

        <h2>Girls' Clothing</h2>

    </div>


    <div class="subcategory-grid">


        <!-- SHOP ALL -->

        <a href="shop.php?category=Girls" class="subcategory-card">

            <img
                src="assets/images/girls/shop-girl.jfif"
                alt="Shop All Girls">

            <h3>Shop All</h3>

        </a>


        <!-- DRESSES -->

        <a href="shop.php?category=Girls&subcategory=Dresses"
           class="subcategory-card">

            <img
                src="assets/images/girls/dresses-g.jfif"
                alt="Girls Dresses">

            <h3>Dresses</h3>

        </a>


        <!-- TOPS -->

        <a href="shop.php?category=Girls&subcategory=Tops"
           class="subcategory-card">

            <img
                src="assets/images/girls/tops-g.jfif"
                alt="Girls Tops">

            <h3>Tops</h3>

        </a>


        <!-- JEANS -->

        <a href="shop.php?category=Girls&subcategory=Jeans"
           class="subcategory-card">

            <img
                src="assets/images/girls/jeans-g.jfif"
                alt="Girls Jeans">

            <h3>Jeans</h3>

        </a>


        <!-- PANTS -->

        <a href="shop.php?category=Girls&subcategory=Pants"
           class="subcategory-card">

            <img
                src="assets/images/girls/pants-g.jfif"
                alt="Girls Pants">

            <h3>Pants</h3>

        </a>


        <!-- SKIRTS -->

        <a href="shop.php?category=Girls&subcategory=Skirts"
           class="subcategory-card">

            <img
                src="assets/images/girls/skirts-g.jfif"
                alt="Girls Skirts">

            <h3>Skirts</h3>

        </a>


        <!-- SHIRTS & BLOUSES -->

        <a href="shop.php?category=Girls&subcategory=Shirts%20%26%20Blouses"
           class="subcategory-card">

            <img
                src="assets/images/girls/shirts-g.jfif"
                alt="Girls Shirts and Blouses">

            <h3>Shirts &amp; Blouses</h3>

        </a>


        <!-- SWEATERS -->

        <a href="shop.php?category=Girls&subcategory=Sweaters"
           class="subcategory-card">

            <img
                src="assets/images/girls/sweaters-g.jfif"
                alt="Girls Sweaters">

            <h3>Sweaters</h3>

        </a>


        <!-- HOODIES -->

        <a href="shop.php?category=Girls&subcategory=Hoodies%20%26%20Sweatshirts"
           class="subcategory-card">

            <img
                src="assets/images/girls/hoodies.jfif"
                alt="Girls Hoodies and Sweatshirts">

            <h3>Hoodies &amp; Sweatshirts</h3>

        </a>


        <!-- OUTERWEAR -->

        <a href="shop.php?category=Girls&subcategory=Outerwear"
           class="subcategory-card">

            <img
                src="assets/images/girls/outerwear-g.jpg"
                alt="Girls Outerwear">

            <h3>Outerwear</h3>

        </a>


        <!-- ACTIVEWEAR -->

        <a href="shop.php?category=Girls&subcategory=Activewear"
           class="subcategory-card">

            <img
                src="assets/images/girls/activewear-g.jfif"
                alt="Girls Activewear">

            <h3>Activewear</h3>

        </a>


        <!-- ACCESSORIES -->

        <a href="shop.php?category=Girls&subcategory=Accessories"
           class="subcategory-card">

            <img
                src="assets/images/girls/accessories-g.jfif"
                alt="Girls Accessories">

            <h3>Accessories</h3>

        </a>


    </div>

</section>

<!-- ==========================================
     GIRLS VIDEO AD
=========================================== -->

<section class="girls-video-banner">

    <video autoplay muted loop playsinline>
        <source src="assets/videos/girls.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="girls-video-overlay">

        <span>LOOMWEAR GIRLS</span>

        <h2>Made For Every Little Moment</h2>

        <p>
            Fun, comfortable styles made for her everyday adventures.
        </p>

        <a href="shop.php?category=Girls">
            Shop Girls
        </a>

    </div>

</section>

<!-- ==========================================
     GIRLS NEW ARRIVALS
=========================================== -->

<section class="new-arrivals girls-new-arrivals">

    <div class="section-heading">
        <span>FEATURED PRODUCTS</span>
        <h2>Shop Our Collections</h2>
    </div>

    <div class="arrival-slider">

        <button class="slider-btn prev" onclick="slideGirlsPrev()">
            ❮
        </button>

        <div class="product-track" id="girlsProductSlider">

            <?php

            $query = "SELECT * FROM products
          WHERE category='Girls'
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

            } else {

            ?>

                <div class="no-products">
                    <p>No girls' products have been added yet.</p>
                </div>

            <?php } ?>

        </div>

        <button class="slider-btn next" onclick="slideGirlsNext()">
            ❯
        </button>

    </div>

</section>

<?php include "includes/footer.php"; ?>


</body>
</html>