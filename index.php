<?php include 'includes/header.php'; ?>

<main>


    <!-- ==========================
         HERO SECTION
    =========================== -->

   <section class="hero">

    <div class="hero-slide active">

        <!-- Hero Video -->

        <video
            class="hero-video"
            autoplay
            muted
            loop
            playsinline
            preload="auto"
        >

            <source
                src="assets/videos/hero.mp4"
                type="video/mp4"
            >

            Your browser does not support the video tag.

        </video>


        <!-- Dark Overlay -->

        <div class="hero-overlay"></div>


        <!-- Hero Content -->

        <div class="hero-content">

            <span>NEW COLLECTION</span>

            <h1>
                Modern Fashion<br>
                For Everyone
            </h1>

            <p>
                Discover timeless essentials and premium styles for Men,
                Women, Girls, Boys & Baby.
            </p>

            <a href="shop.php" class="hero-btn">
                Shop Collection
            </a>

        </div>

    </div>

</section>

</main>
<!-- ==========================================
FEATURED CATEGORIES
=========================================== -->

<section class="featured-categories">

    <div class="section-heading">

        <span>FOR EVERY GENERATION</span>

        <h2>Find Your Style</h2>

    </div>

    <div class="category-grid">

        <a href="men.php?category=men" class="category-card">

            <img src="assets/images/categories/MEN.jfif" alt="Men">

            <div class="category-overlay">

                <h3>Men</h3>

            </div>

        </a>

        <a href="women.php?category=women" class="category-card">

            <img src="assets/images/categories/WOMEN.jfif" alt="Women">

            <div class="category-overlay">

                <h3>Women</h3>

            </div>

        </a>

        <a href="girls.php?category=girls" class="category-card">

            <img src="assets/images/categories/GIRL.jfif" alt="Girls">

            <div class="category-overlay">

                <h3>Girls</h3>

            </div>

        </a>

        <a href="boys.php?category=boys" class="category-card">

            <img src="assets/images/categories/BOY.jfif" alt="Boys">

            <div class="category-overlay">

                <h3>Boys</h3>

            </div>

        </a>

        <a href="baby.php?category=baby" class="category-card">

            <img src="assets/images/categories/BABY.jfif" alt="Baby & Toddler">

            <div class="category-overlay">

                <h3>Baby & Toddler</h3>

            </div>

        </a>

    </div>

</section>

<!-- ==========================================
     BACK TO SCHOOL VIDEO
=========================================== -->

<section class="back-to-school-video">

    <video
        class="school-video"
        autoplay
        muted
        loop
        playsinline
    >
        <source src="assets/videos/school.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Dark/Light overlay -->
    <div class="school-video-overlay"></div>

    <!-- Text -->
    <div class="school-video-content">

        <span class="school-small-text">
            The Back to School Event
        </span>

        <h2>
            40–60% off<br>
            sweats, denim & tees
        </h2>

        <div class="school-buttons">

            <a href="school.php?category=Girls">
    Girls
</a>

<a href="school.php?category=Boys">
    Boys
</a>

<a href="school.php?category=Toddler%20Girl">
    Toddler Girl
</a>

<a href="school.php?category=Toddler%20Boy">
    Toddler Boy
</a>
        </div>

    </div>

    <!-- Bottom controls -->
    <div class="school-video-controls">

        <button id="schoolVideoPause" type="button">
            ❚❚
        </button>

        <span>
            Select styles.
        </span>

        <a href="shop.php">
            Details
        </a>

    </div>

</section>

<!-- ==========================================
NEW ARRIVALS
=========================================== -->

<section class="new-arrivals">

<div class="section-heading">

    <span>JUST DROPPED</span>

    <h2>New Arrivals</h2>

</div>


<div class="arrival-slider">


<button class="slider-btn prev" onclick="slidePrev()">
❮
</button>


<div class="product-track" id="productSlider">


<?php

include "includes/db.php";


$query = "SELECT * FROM products
          WHERE section = 'new_arrival'
          ORDER BY id DESC
          LIMIT 15";

$result = mysqli_query($conn,$query);



while($product = mysqli_fetch_assoc($result)){


?>


<a href="product-details.php?id=<?= $product['id']; ?>" class="product-card">


<div class="product-image">


<img src="uploads/products/<?= $product['image']; ?>" 
alt="<?= htmlspecialchars($product['product_name']); ?>">



<?php if(!empty($product['badge'])){ ?>

<span class="badge">
<?= $product['badge']; ?>
</span>

<?php } ?>


</div>



<h4>
<?= htmlspecialchars($product['product_name']); ?>
</h4>



<p>
<?= $product['gender']; ?>
</p>



<span class="price">
Rs. <?= number_format($product['price']); ?>
</span>



</a>


<?php

}

?>


</div>


<button class="slider-btn next" onclick="slideNext()">
❯
</button>


</div>


</section>
<?php include 'includes/footer.php'; ?>