<?php

include "includes/db.php";
include "includes/header.php";

?>

<!-- ==================================================
     BABY & TODDLER SUB CATEGORIES
================================================== -->

<section class="baby-subcategories">

    <div class="section-heading">

        <span>SHOP BABY & TODDLER</span>

        <h2>Baby & Toddler Clothing</h2>

    </div>


    <div class="subcategory-grid">


        <!-- SHOP ALL -->

        <a href="shop.php?category=Baby%20%26%20Toddler"
           class="subcategory-card">

            <img
                src="assets/images/baby/shop-t.jfif"
                alt="Shop All Baby and Toddler">

            <h3>Shop All</h3>

        </a>


        <!-- BODYSUITS -->

        <a href="shop.php?category=Baby%20%26%20Toddler&subcategory=Bodysuits"
           class="subcategory-card">

            <img
                src="assets/images/baby/bodysuits.jfif"
                alt="Baby Bodysuits">

            <h3>Bodysuits</h3>

        </a>


        <!-- DRESSES -->

        <a href="shop.php?category=Baby%20%26%20Toddler&subcategory=Dresses"
           class="subcategory-card">

            <img
                src="assets/images/baby/dresses-t.jfif"
                alt="Baby Dresses">

            <h3>Dresses</h3>

        </a>


        <!-- TOPS -->

        <a href="shop.php?category=Baby%20%26%20Toddler&subcategory=Tops"
           class="subcategory-card">

            <img
                src="assets/images/baby/tops-t.jfif"
                alt="Baby Tops">

            <h3>Tops</h3>

        </a>


        <!-- BOTTOMS -->

        <a href="shop.php?category=Baby%20%26%20Toddler&subcategory=Bottoms"
           class="subcategory-card">

            <img
                src="assets/images/baby/bottoms.jfif"
                alt="Baby Bottoms">

            <h3>Bottoms</h3>

        </a>


        <!-- ROMPERS -->

        <a href="shop.php?category=Baby%20%26%20Toddler&subcategory=Rompers"
           class="subcategory-card">

            <img
                src="assets/images/baby/rompers.jfif"
                alt="Baby Rompers">

            <h3>Rompers</h3>

        </a>


        <!-- SETS -->

        <a href="shop.php?category=Baby%20%26%20Toddler&subcategory=Sets"
           class="subcategory-card">

            <img
                src="assets/images/baby/sets.jfif"
                alt="Baby Clothing Sets">

            <h3>Sets</h3>

        </a>


        <!-- PAJAMAS -->

        <a href="shop.php?category=Baby%20%26%20Toddler&subcategory=Pajamas"
           class="subcategory-card">

            <img
                src="assets/images/baby/pajamas-t.jfif"
                alt="Baby Pajamas">

            <h3>Pajamas</h3>

        </a>


        <!-- SWEATERS -->

        <a href="shop.php?category=Baby%20%26%20Toddler&subcategory=Sweaters"
           class="subcategory-card">

            <img
                src="assets/images/baby/sweaters-t.jfif"
                alt="Baby Sweaters">

            <h3>Sweaters</h3>

        </a>


        <!-- HOODIES -->

        <a href="shop.php?category=Baby%20%26%20Toddler&subcategory=Hoodies"
           class="subcategory-card">

            <img
                src="assets/images/baby/hoodies-t.jfif"
                alt="Baby Hoodies">

            <h3>Hoodies</h3>

        </a>


        <!-- OUTERWEAR -->

        <a href="shop.php?category=Baby%20%26%20Toddler&subcategory=Outerwear"
           class="subcategory-card">

            <img
                src="assets/images/baby/outerwear-t.jfif"
                alt="Baby Outerwear">

            <h3>Outerwear</h3>

        </a>


        <!-- ACCESSORIES -->

        <a href="shop.php?category=Baby%20%26%20Toddler&subcategory=Accessories"
           class="subcategory-card">

            <img
                src="assets/images/baby/accesosries-t.jfif"
                alt="Baby Accessories">

            <h3>Accessories</h3>

        </a>


    </div>

</section>



<!-- ==================================================
     BABY & TODDLER VIDEO AD
================================================== -->

<section class="baby-video-banner">

    <video autoplay muted loop playsinline>

        <source
            src="assets/videos/baby.mp4"
            type="video/mp4">

        Your browser does not support the video tag.

    </video>


    <div class="baby-video-overlay">

        <span>LOOMWEAR BABY & TODDLER</span>

        <h2>Little Styles, Big Adventures</h2>

        <p>
            Soft, comfortable styles made for every little moment.
        </p>

        <a href="shop.php?category=Baby%20%26%20Toddler">
            Shop Baby & Toddler
        </a>

    </div>

</section>



<!-- ==================================================
     BABY & TODDLER NEW ARRIVALS
================================================== -->

<section class="new-arrivals baby-new-arrivals">

    <div class="section-heading">

        <span>FEATURED PRODUCTS</span>

        <h2>Shop Our Collections</h2>

    </div>


    <div class="arrival-slider">


        <button
            class="slider-btn prev"
            onclick="slideBabyPrev()">

            ❮

        </button>


        <div
            class="product-track"
            id="babyProductSlider">


            <?php

            $query = "SELECT * FROM products
          WHERE category='Baby & Toddler'
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
                        No baby & toddler products have been added yet.
                    </p>

                </div>


            <?php } ?>


        </div>


        <button
            class="slider-btn next"
            onclick="slideBabyNext()">

            ❯

        </button>


    </div>

</section>

<?php include "includes/footer.php"; ?>


</body>
</html>