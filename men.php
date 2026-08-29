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

<section class="men-subcategories">

    <div class="section-heading">
        <span>SHOP MEN</span>
        <h2>Men's Clothing</h2>
    </div>

    <div class="subcategory-grid">

        <a href="shop.php?category=Men&subcategory=All" class="subcategory-card">
                <img src="assets/images/men/shop-all.jfif">
                <h3>Shop All</h3>
            
        </a>

        <a href="shop.php?category=Men&subcategory=Jeans" class="subcategory-card">
                <img src="assets/images/men/jeans.jfif">
                <h3>Jeans</h3>
        </a>

        <a href="shop.php?category=Men&subcategory=LoomWear Sweats" class="subcategory-card">
            
                <img src="assets/images/men/loomwear-sweats.jfif">
                <h3>LoomWear Sweats</h3>
          
        </a>

        <a href="shop.php?category=Men&subcategory=Tees" class="subcategory-card">
           
                <img src="assets/images/men/tees.jfif">
                <h3>Tees</h3>
           
        </a>

        <a href="shop.php?category=Men&subcategory=Shirts" class="subcategory-card">
           
                <img src="assets/images/men/shirts.jfif">
                <h3>Shirts</h3>
           
        </a>

        <a href="shop.php?category=Men&subcategory=Pants" class="subcategory-card">
           
                <img src="assets/images/men/pants.jfif">
                <h3>Pants</h3>
           
        </a>

        <a href="shop.php?category=Men&subcategory=Outerwear" class="subcategory-card">
           
                <img src="assets/images/men/outerwear.jfif">
                <h3>Outerwear</h3>
           
        </a>

        <a href="shop.php?category=Men&subcategory=Polos" class="subcategory-card">
           
                <img src="assets/images/men/polos.jfif">
                <h3>Polos</h3>
          
        </a>

        <a href="shop.php?category=Men&subcategory=Sweaters" class="subcategory-card">
           
                <img src="assets/images/men/sweaters.jfif">
                <h3>Sweaters</h3>
           
        </a>

        <a href="shop.php?category=Men&subcategory=Pajamas" class="subcategory-card">
            
                <img src="assets/images/men/pajamas.jfif">
                <h3>Pajamas</h3>
           
        </a>

        <a href="shop.php?category=Men&subcategory=Underwear" class="subcategory-card">
           
                <img src="assets/images/men/underwear.jfif">
                <h3>Underwear</h3>
            
        </a>

        <a href="shop.php?category=Men&subcategory=Accessories" class="subcategory-card">
                <img src="assets/images/men/accessories.jfif">
                <h3>Accessories</h3>
        </a>

    </div>

</section>

<section class="men-video-banner">

    <video autoplay muted loop playsinline>
        <source src="assets/videos/men.mp4" type="video/mp4">
    </video>

    <div class="video-content">

        <span>LOOMWEAR MEN</span>

        <h2>Designed For Every Day</h2>

        <p>
            Premium essentials made for comfort, confidence, and everyday style.
        </p>

        <a href="shop.php?category=Men">Shop Collection</a>

    </div>

</section>

<section class="new-arrivals">

<div class="section-heading">

    <span>FEATURED PRODUCTS</span>

    <h2>Shop Our Collections</h2>

</div>


<div class="arrival-slider">


<button class="slider-btn prev" onclick="slidePrev()">
❮
</button>


<div class="product-track" id="productSlider">


<?php

include "includes/db.php";


$query = "SELECT * FROM products
          WHERE category='Men'
          AND section='every_generation'
          ORDER BY id DESC
          LIMIT 8";

$result = mysqli_query($conn, $query);

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


<?php include "includes/footer.php"; ?>


</body>
</html>