<?php

include "includes/db.php";
include "includes/header.php";

?>

<!-- ==================================================
     BOYS SUB CATEGORIES
================================================== -->

<section class="boys-subcategories">

    <div class="section-heading">

        <span>SHOP BOYS</span>

        <h2>Boys' Clothing</h2>

    </div>


    <div class="subcategory-grid">


        <!-- SHOP ALL -->

        <a href="shop.php?category=Boys"
           class="subcategory-card">

            <img
                src="assets/images/boys/shop-b.jfif"
                alt="Shop All Boys">

            <h3>Shop All</h3>

        </a>


        <!-- TEES -->

        <a href="shop.php?category=Boys&subcategory=Tees"
           class="subcategory-card">

            <img
                src="assets/images/boys/tees-b.jfif"
                alt="Boys Tees">

            <h3>Tees</h3>

        </a>


        <!-- SHIRTS -->

        <a href="shop.php?category=Boys&subcategory=Shirts"
           class="subcategory-card">

            <img
                src="assets/images/boys/shirts-b.jfif"
                alt="Boys Shirts">

            <h3>Shirts</h3>

        </a>


        <!-- JEANS -->

        <a href="shop.php?category=Boys&subcategory=Jeans"
           class="subcategory-card">

            <img
                src="assets/images/boys/jeans-b.jfif"
                alt="Boys Jeans">

            <h3>Jeans</h3>

        </a>


        <!-- PANTS -->

        <a href="shop.php?category=Boys&subcategory=Pants"
           class="subcategory-card">

            <img
                src="assets/images/boys/pants-b.jfif"
                alt="Boys Pants">

            <h3>Pants</h3>

        </a>


        <!-- SHORTS -->

        <a href="shop.php?category=Boys&subcategory=Shorts"
           class="subcategory-card">

            <img
                src="assets/images/boys/shorts-b.jfif"
                alt="Boys Shorts">

            <h3>Shorts</h3>

        </a>


        <!-- POLOS -->

        <a href="shop.php?category=Boys&subcategory=Polos"
           class="subcategory-card">

            <img
                src="assets/images/boys/polos-b.jfif"
                alt="Boys Polos">

            <h3>Polos</h3>

        </a>


        <!-- SWEATERS -->

        <a href="shop.php?category=Boys&subcategory=Sweaters"
           class="subcategory-card">

            <img
                src="assets/images/boys/sweaters-b.jfif"
                alt="Boys Sweaters">

            <h3>Sweaters</h3>

        </a>


        <!-- HOODIES & SWEATSHIRTS -->

        <a href="shop.php?category=Boys&subcategory=Hoodies%20%26%20Sweatshirts"
           class="subcategory-card">

            <img
                src="assets/images/boys/hoodies-b.jfif"
                alt="Boys Hoodies and Sweatshirts">

            <h3>Hoodies &amp; Sweatshirts</h3>

        </a>


        <!-- OUTERWEAR -->

        <a href="shop.php?category=Boys&subcategory=Outerwear"
           class="subcategory-card">

            <img
                src="assets/images/boys/outerwear-b.jfif"
                alt="Boys Outerwear">

            <h3>Outerwear</h3>

        </a>


        <!-- ACTIVEWEAR -->

        <a href="shop.php?category=Boys&subcategory=Activewear"
           class="subcategory-card">

            <img
                src="assets/images/boys/activewear-b.jfif"
                alt="Boys Activewear">

            <h3>Activewear</h3>

        </a>


        <!-- ACCESSORIES -->

        <a href="shop.php?category=Boys&subcategory=Accessories"
           class="subcategory-card">

            <img
                src="assets/images/boys/accessories-b.jfif"
                alt="Boys Accessories">

            <h3>Accessories</h3>

        </a>


    </div>

</section>



<!-- ==================================================
     BOYS VIDEO AD
================================================== -->

<section class="boys-video-banner">

    <video autoplay muted loop playsinline>

        <source
            src="assets/videos/boys.mp4"
            type="video/mp4">

        Your browser does not support the video tag.

    </video>


    <div class="boys-video-overlay">

        <span>LOOMWEAR BOYS</span>

        <h2>Ready For Every Adventure</h2>

        <p>
            Comfortable styles made for play, fun and everyday adventures.
        </p>

        <a href="shop.php?category=Boys">
            Shop Boys
        </a>

    </div>

</section>



<!-- ==================================================
     BOYS NEW ARRIVALS
================================================== -->

<section class="new-arrivals boys-new-arrivals">

    <div class="section-heading">

        <span>FEATURED PRODUCTS</span>

        <h2>Shop Our Collections</h2>

    </div>


    <div class="arrival-slider">


        <button
            class="slider-btn prev"
            onclick="slideBoysPrev()">

            ❮

        </button>


        <div
            class="product-track"
            id="boysProductSlider">


            <?php

           $query = "SELECT * FROM products
          WHERE category='Boys'
          AND section='every_generation'
          ORDER BY id DESC
          LIMIT 8";
            $result = mysqli_query($conn, $query);


            if(mysqli_num_rows($result) > 0){

                while($product = mysqli_fetch_assoc($result)){

            ?>


            <a
                href="product-details.php?id=<?= $product['id']; ?>"
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

                    Rs.
                    <?= number_format($product['price']); ?>

                </span>


            </a>


            <?php

                }

            } else {

            ?>


                <div class="no-products">

                    <p>
                        No boys' products have been added yet.
                    </p>

                </div>


            <?php } ?>


        </div>


        <button
            class="slider-btn next"
            onclick="slideBoysNext()">

            ❯

        </button>


    </div>

</section>

<?php include "includes/footer.php"; ?>


</body>
</html>