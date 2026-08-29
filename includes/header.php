<?php

if(session_status() == PHP_SESSION_NONE){

    session_start();

}

include "includes/db.php";

$session_id = session_id();

$cartCount = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(quantity) AS total
FROM cart
WHERE session_id='$session_id'
"));

$wishCount = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM wishlist
WHERE session_id='$session_id'
"));

$wishlistTotal = $wishCount['total'];

$bagCount = $cartCount['total'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>LoomWear</title>

    <!-- Google Font -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>

    <!-- CSS -->

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/product-details.css">
    <link rel="stylesheet" href="assets/css/cart.css">
    <link rel="stylesheet" href="assets/css/wishlist.css">
    <link rel="stylesheet" href="assets/css/checkout.css">
    <link rel="stylesheet" href="assets/css/responsive.css">

</head>

<body>

<div class="announcement-bar">

    <div class="announcement-track">

        <span>
            Free Shipping on Orders Over Rs. 5,000
        </span>

        <span>•</span>

        <span>
            New Collection Available Now
        </span>

        <span>•</span>

        <span>
            Easy 14-Day Returns
        </span>

        <span>•</span>

        <span>
            Shop Our Latest Collection
        </span>

        <span>•</span>


    </div>

</div>
<!-- =========================
Header
========================= -->

<header class="header">

   <div class="header-nav-row">
        <!-- Logo -->

        <a href="index.php" class="logo">
            Loom<span>Wear</span>
        </a>

        <nav class="navbar">

<ul class="nav-menu">

<li class="mega-parent">

<a href="#">Men</a>

<div class="mega-menu">

<div class="mega-container">

<div class="mega-banner">

<img src="assets/images/banners/men1-banner.jfif">

<h4>New Season</h4>

<p>Modern essentials for every day.</p>

</div>

<div class="mega-column">

<h3>New & Featured</h3>

<ul>

   <li>
    <a href="shop.php?category=Men&featured=new_arrivals">
        New Arrivals
    </a>
</li>

<li>
    <a href="shop.php?category=Men&featured=trending">
        Trending Now
    </a>
</li>

<li>
    <a href="shop.php?category=Men&featured=best_sellers">
        Best Sellers
    </a>
</li>

<li>
    <a href="shop.php?category=Men&featured=matching_sets">
        Matching Sets
    </a>
</li>

<li>
    <a href="shop.php?category=Men&featured=online_exclusives">
        Online Exclusives
    </a>
</li>

<li>
    <a href="shop.php?category=Men&featured=back_in_stock">
        Back In Stock
    </a>
</li>

</ul>

</div>

<div class="mega-column">

<h3>Categories</h3>

<ul>

<li>
    <a href="shop.php?category=Men&subcategory=Jeans">
        Jeans
    </a>
</li>

<li>
    <a href="shop.php?category=Men&subcategory=LoomWear%20Sweats">
        LoomWear Sweats
    </a>
</li>

<li>
    <a href="shop.php?category=Men&subcategory=Tees">
        Tees
    </a>
</li>

<li>
    <a href="shop.php?category=Men&subcategory=Shirts">
        Shirts
    </a>
</li>

<li>
    <a href="shop.php?category=Men&subcategory=Pants">
        Pants
    </a>
</li>

<li>
    <a href="shop.php?category=Men&subcategory=Outerwear">
        Outerwear
    </a>
</li>

<li>
    <a href="shop.php?category=Men&subcategory=Polos">
        Polos
    </a>
</li>

<li>
    <a href="shop.php?category=Men&subcategory=Sweaters">
        Sweaters
    </a>
</li>

<li>
    <a href="shop.php?category=Men&subcategory=Pajamas">
        Pajamas
    </a>
</li>

<li>
    <a href="shop.php?category=Men&subcategory=Underwear">
        Underwear
    </a>
</li>

<li>
    <a href="shop.php?category=Men&subcategory=Accessories">
        Accessories
    </a>
</li>

</ul>

<h3 class="mt">
    <a href="shop.php?category=men-sale" class="sale-heading">
        Sale
    </a>
</h3>
</div>

<div class="mega-column">

<h3>Accessories</h3>

<ul>

<li><a href="shop.php?category=Men&subcategory=Caps">Caps</a></li>
<li><a href="shop.php?category=Men&subcategory=Belts">Belts</a></li>
<li><a href="shop.php?category=Men&subcategory=Wallets">Wallets</a></li>

</ul>

<h3>Collaborations</h3>

<ul>

<li>
    <a href="shop.php?collection=LoomWearX">
        LoomWear X
    </a>
</li>

<li>
    <a href="shop.php?collection=Collaborations&collection_type=Limited%20Edition">
        Limited Drops
    </a>
</li>

</ul>

<h3>Guides</h3>

<ul>

<li>
    <a href="size-guide.php">Size Guide</a>
</li>

<li>
    <a href="care-guide.php">
        Care Guide
    </a>
</li>

</ul>

</div>

<div class="mega-banner">

<img src="assets/images/banners/men-banner.jfif">

<h4>Everyday Collection</h4>

<p>Designed for comfort.</p>

</div>

</div>

</div>

</li>

<!-- ==========================
WOMEN MEGA MENU
=========================== -->

<li class="mega-parent">

    <a href="shop.php?gender=women">Women</a>

    <div class="mega-menu">

        <div class="mega-container">

            <!-- Left Banner -->

            <div class="mega-banner">

                <img src="assets/images/banners/women-left.jfif" alt="Women's Collection">

                <h4>Women's New Collection</h4>

                <p>Designed for confidence and everyday elegance.</p>

            </div>

            <!-- New & Featured -->

            <div class="mega-column">

                <h3>New & Featured</h3>

<ul>

   <li>
    <a href="shop.php?category=Women&featured=new_arrivals">
        New Arrivals
    </a>
</li>

<li>
    <a href="shop.php?category=Women&featured=trending">
        Trending Now
    </a>
</li>

<li>
    <a href="shop.php?category=Women&featured=best_sellers">
        Best Sellers
    </a>
</li>

<li>
    <a href="shop.php?category=Women&featured=matching_sets">
        Matching Sets
    </a>
</li>

<li>
    <a href="shop.php?category=Women&featured=online_exclusives">
        Online Exclusives
    </a>
</li>

<li>
    <a href="shop.php?category=Women&featured=back_in_stock">
        Back In Stock
    </a>
</li>


</ul>

            </div>

            <!-- Categories -->

            <div class="mega-column">

                  <h3>Categories</h3>

<ul>

<li>
    <a href="shop.php?category=Women&subcategory=Dresses">
        Dresses
    </a>
</li>

<li>
    <a href="shop.php?category=Women&subcategory=Tops">
        Tops
    </a>
</li>

<li>
    <a href="shop.php?category=Women&subcategory=Jeans">
        Jeans
    </a>
</li>

<li>
    <a href="shop.php?category=Women&subcategory=Pants">
        Pants
    </a>
</li>

<li>
    <a href="shop.php?category=Women&subcategory=Skirts">
        Skirts
    </a>
</li>

<li>
   <a href="shop.php?category=Women&subcategory=Shirts%20%26%20Blouses">
        Shirts & Blouses
    </a>
</li>

<li>
    <a href="shop.php?category=Women&subcategory=Sweaters">
        Sweaters
    </a>
</li>

<li>
    <a href="shop.php?category=Women&subcategory=Hoodies%20%26%20Sweatshirts">
        Hoodies & Sweatshirts
    </a>
</li>

<li>
    <a href="shop.php?category=Women&subcategory=Outerwear">
        Outerwear
    </a>
</li>

<li>
    <a href="shop.php?category=Women&subcategory=Activewear">
        Activewear
    </a>
</li>

<li>
    <a href="shop.php?category=Women&subcategory=Accessories">
        Accessories
    </a>
</li>

</ul>

               <h3 class="mt">
    <a href="shop.php?category=women-sale" class="sale-heading">
        Sale
    </a>
</h3>

            </div>


            <!-- Accessories -->

            <div class="mega-column">

                <h3>Accessories</h3>

                <ul>
                   <li><a href="shop.php?category=Women&subcategory=Bags">Bags</a></li>
<li><a href="shop.php?category=Women&subcategory=Belts">Belts</a></li>
<li><a href="shop.php?category=Women&subcategory=Caps">Caps</a></li>
<li><a href="shop.php?category=Women&subcategory=Scarves">Scarves</a></li>
<li><a href="shop.php?category=Women&subcategory=Sunglasses">Sunglasses</a></li>
<li><a href="shop.php?category=Women&subcategory=Socks">Socks</a></li>
                </ul>

               <h3>Collaborations</h3>

<ul>

<li>
    <a href="shop.php?collection=LoomWearX">
        LoomWear X
    </a>
</li>

<li>
    <a href="shop.php?collection=Collaborations&collection_type=Limited%20Edition">
        Limited Drops
    </a>
</li>

</ul>
                <h3 class="mt">Guides</h3>

                <ul>
                 <li>
    <a href="size-guide.php">Size Guide</a>
</li>
                
                    <li>
    <a href="care-guide.php">
        Care Guide
    </a>
</li>
                </ul>

            </div>

            <!-- Right Banner -->

            <div class="mega-banner">

                <img src="assets/images/banners/women-righ.jfif" alt="Women's Campaign">

                <h4>Everyday Essentials</h4>

                <p>Premium comfort with effortless style.</p>

            </div>

        </div>

    </div>

</li>

<!-- ==========================
GIRLS MEGA MENU
=========================== -->

<li class="mega-parent">

    <a href="shop.php?gender=girls">Girls</a>

    <div class="mega-menu">

        <div class="mega-container">

            <!-- Left Banner -->

            <div class="mega-banner">

                <img src="assets/images/banners/girl-left.jfif" alt="Girls Collection">

                <h4>Girls' New Collection</h4>

                <p>Playful styles for every adventure.</p>

            </div>

            <!-- New & Featured -->

            <div class="mega-column">

              <h3>New & Featured</h3>

<ul>

   <li>
    <a href="shop.php?category=Girls&featured=new_arrivals">
        New Arrivals
    </a>
</li>

<li>
    <a href="shop.php?category=Girls&featured=trending">
        Trending Now
    </a>
</li>

<li>
    <a href="shop.php?category=Girls&featured=best_sellers">
        Best Sellers
    </a>
</li>

<li>
    <a href="shop.php?category=Girls&featured=matching_sets">
        Matching Sets
    </a>
</li>

<li>
    <a href="shop.php?category=Girls&featured=online_exclusives">
        Online Exclusives
    </a>
</li>

<li>
    <a href="shop.php?category=Girls&featured=back_in_stock">
        Back In Stock
    </a>
</li>

</ul>

            </div>

            <!-- Categories -->

            <div class="mega-column">

                <h3>Categories</h3>

                <ul>

                   <li>
    <a href="shop.php?category=Girls&subcategory=Dresses">
        Dresses
    </a>
</li>

<li>
    <a href="shop.php?category=Girls&subcategory=Tops">
        Tops
    </a>
</li>

<li>
    <a href="shop.php?category=Girls&subcategory=Jeans">
        Jeans
    </a>
</li>

<li>
    <a href="shop.php?category=Girls&subcategory=Pants">
        Pants
    </a>
</li>

<li>
    <a href="shop.php?category=Girls&subcategory=Skirts">
        Skirts
    </a>
</li>

<li>
    <a href="shop.php?category=Girls&subcategory=Shirts%20%26%20Blouses">
        Shirts & Blouses
    </a>
</li>

<li>
    <a href="shop.php?category=Girls&subcategory=Sweaters">
        Sweaters
    </a>
</li>

<li>
    <a href="shop.php?category=Girls&subcategory=Hoodies%20%26%20Sweatshirts">
        Hoodies & Sweatshirts
    </a>
</li>

<li>
    <a href="shop.php?category=Girls&subcategory=Outerwear">
        Outerwear
    </a>
</li>

<li>
    <a href="shop.php?category=Girls&subcategory=Activewear">
        Activewear
    </a>
</li>

<li>
    <a href="shop.php?category=Girls&subcategory=Accessories">
        Accessories
    </a>
</li>


                </ul>

                <h3 class="mt">
    <a href="shop.php?category=girls-sale" class="sale-heading">
        Sale
    </a>
</h3>

            </div>

            <!-- Accessories -->

            <div class="mega-column">

                <h3>Accessories</h3>

                <ul>

                   <li><a href="shop.php?category=Girls&subcategory=Backpacks">Backpacks</a></li>
<li><a href="shop.php?category=Girls&subcategory=Hair%20Accessories">Hair Accessories</a></li>
<li><a href="shop.php?category=Girls&subcategory=Caps%20%26%20Hats">Caps & Hats</a></li>
<li><a href="shop.php?category=Girls&subcategory=Socks">Socks</a></li>
<li><a href="shop.php?category=Girls&subcategory=Belts">Belts</a></li>
<li><a href="shop.php?category=Girls&subcategory=Bags">Bags</a></li>
<li><a href="shop.php?category=Girls&subcategory=Scarves">Scarves</a></li>

                </ul>

            </div>


            <!-- Right Banner -->

            <div class="mega-banner">

                <img src="assets/images/banners/girl-right.jfif" alt="Girls Fashion">

                <h4>Everyday Favourites</h4>

                <p>Comfortable styles made for school, play and weekends.</p>

            </div>

        </div>

    </div>

</li>

<!-- ==========================
BOYS MEGA MENU
=========================== -->

<li class="mega-parent">

    <a href="shop.php?gender=boys">Boys</a>

    <div class="mega-menu">

        <div class="mega-container">

            <!-- Left Banner -->

            <div class="mega-banner">

                <img src="assets/images/banners/boy-left.jfif" alt="Boys Collection">

                <h4>Boys' New Collection</h4>

                <p>Everyday comfort for school, sports and adventure.</p>

            </div>

            <!-- New & Featured -->

            <div class="mega-column">

               <h3>New & Featured</h3>

<ul>

   <li>
    <a href="shop.php?category=Boys&featured=new_arrivals">
        New Arrivals
    </a>
</li>

<li>
    <a href="shop.php?category=Boys&featured=trending">
        Trending Now
    </a>
</li>

<li>
    <a href="shop.php?category=Boys&featured=best_sellers">
        Best Sellers
    </a>
</li>

<li>
    <a href="shop.php?category=Boys&featured=matching_sets">
        Matching Sets
    </a>
</li>

<li>
    <a href="shop.php?category=Boys&featured=online_exclusives">
        Online Exclusives
    </a>
</li>

<li>
    <a href="shop.php?category=Boys&featured=back_in_stock">
        Back In Stock
    </a>
</li>

</ul>

            </div>

            <!-- Categories -->

            <div class="mega-column">

                <h3>Categories</h3>

                <ul>

                  <li>
    <a href="shop.php?category=Boys&subcategory=Tees">
        Tees
    </a>
</li>

<li>
    <a href="shop.php?category=Boys&subcategory=Shirts">
        Shirts
    </a>
</li>

<li>
    <a href="shop.php?category=Boys&subcategory=Jeans">
        Jeans
    </a>
</li>

<li>
    <a href="shop.php?category=Boys&subcategory=Pants">
        Pants
    </a>
</li>

<li>
    <a href="shop.php?category=Boys&subcategory=Shorts">
        Shorts
    </a>
</li>

<li>
    <a href="shop.php?category=Boys&subcategory=Polos">
        Polos
    </a>
</li>

<li>
    <a href="shop.php?category=Boys&subcategory=Sweaters">
        Sweaters
    </a>
</li>

<li>
    <a href="shop.php?category=Boys&subcategory=Hoodies%20%26%20Sweatshirts">
        Hoodies & Sweatshirts
    </a>
</li>

<li>
    <a href="shop.php?category=Boys&subcategory=Outerwear">
        Outerwear
    </a>
</li>

<li>
    <a href="shop.php?category=Boys&subcategory=Activewear">
        Activewear
    </a>
</li>

<li>
    <a href="shop.php?category=Boys&subcategory=Accessories">
        Accessories
    </a>
</li>


                </ul>

                <h3 class="mt">
    <a href="shop.php?category=boys-sale" class="sale-heading">
        Sale
    </a>
</h3>

            </div>

            <!-- Accessories -->

            <div class="mega-column">

                <h3>Accessories</h3>

                <ul>

                   <li><a href="shop.php?category=Boys&subcategory=Backpacks">Backpacks</a></li>
<li><a href="shop.php?category=Boys&subcategory=Caps%20%26%20Hats">Caps & Hats</a></li>
<li><a href="shop.php?category=Boys&subcategory=Belts">Belts</a></li>
<li><a href="shop.php?category=Boys&subcategory=Socks">Socks</a></li>
<li><a href="shop.php?category=Boys&subcategory=Beanies">Beanies</a></li>
<li><a href="shop.php?category=Boys&subcategory=Crossbody%20Bags">Crossbody Bags</a></li>
<li><a href="shop.php?category=Boys&subcategory=Wallets">Wallets</a></li>

                </ul>

            </div>

            <!-- Right Banner -->

            <div class="mega-banner">

                <img src="assets/images/banners/boy-right.jfif" alt="Boys Fashion">

                <h4>Built for Every Adventure</h4>

                <p>Durable styles designed for active kids.</p>

            </div>

        </div>

    </div>

</li>

<!-- ==========================
BABY & TODDLER MEGA MENU
=========================== -->

<li class="mega-parent">

    <a href="shop.php?gender=baby-toddler">Baby & Toddler</a>

    <div class="mega-menu">

        <div class="mega-container">

            <!-- Left Banner -->

            <div class="mega-banner">

                <img src="assets/images/banners/baby-left.jfif" alt="Baby & Toddler">

                <h4>Baby & Toddler Collection</h4>

                <p>Soft, comfortable essentials for every little moment.</p>

            </div>

            <!-- New & Featured -->

            <div class="mega-column">

                <h3>New & Featured</h3>

<ul>

   <li>
    <a href="shop.php?category=Baby%20%26%20Toddler&featured=new_arrivals">
        New Arrivals
    </a>
</li>

<li>
    <a href="shop.php?category=Baby%20%26%20Toddler&featured=trending">
        Trending Now
    </a>
</li>

<li>
    <a href="shop.php?category=Baby%20%26%20Toddler&featured=best_sellers">
        Best Sellers
    </a>
</li>

<li>
    <a href="shop.php?category=Baby%20%26%20Toddler&featured=matching_sets">
        Matching Sets
    </a>
</li>

<li>
    <a href="shop.php?category=Baby%20%26%20Toddler&featured=online_exclusives">
        Online Exclusives
    </a>
</li>

<li>
    <a href="shop.php?category=Baby%20%26%20Toddler&featured=back_in_stock">
        Back In Stock
    </a>
</li>

</ul>
            </div>

            <!-- Baby 0-24M -->

            <div class="mega-column">

                <h3>Baby 0-24M</h3>

                <ul>

                   <li>
    <a href="shop.php?category=Baby&subcategory=Dresses">
        Dresses
    </a>
</li>

<li>
    <a href="shop.php?category=Baby&subcategory=Tops">
        Tops
    </a>
</li>

<li>
    <a href="shop.php?category=Baby&subcategory=Bodysuits">
        Bodysuits
    </a>
</li>

<li>
    <a href="shop.php?category=Baby&subcategory=Bottoms">
        Bottoms
    </a>
</li>

<li>
    <a href="shop.php?category=Baby&subcategory=Rompers">
        Rompers
    </a>
</li>

<li>
    <a href="shop.php?category=Baby&subcategory=Sets">
        Sets
    </a>
</li>

<li>
    <a href="shop.php?category=Baby&subcategory=Sweaters">
        Sweaters
    </a>
</li>

<li>
    <a href="shop.php?category=Baby&subcategory=Hoodies">
        Hoodies
    </a>
</li>

<li>
    <a href="shop.php?category=Baby&subcategory=Outerwear">
        Outerwear
    </a>
</li>

<li>
    <a href="shop.php?category=Baby&subcategory=Pajamas">
        Pajamas
    </a>
</li>

<li>
    <a href="shop.php?category=Baby&subcategory=Accessories">
        Accessories
    </a>
</li>


                </ul>

               <h3 class="mt">
    <a href="shop.php?category=Baby%20%26%20Toddler&sale=1" class="sale-heading">
        Sale
    </a>
</h3>
            </div>

            <!-- Girl Toddler -->

            <div class="mega-column">

                <h3>Girl | Toddler 6M-6T</h3>

                <ul>

                   <li>
    <a href="shop.php?category=Baby%20%26%20Toddler&subcategory=Dresses">
        Dresses
    </a>
</li>

<li>
    <a href="shop.php?category=Baby%20%26%20Toddler&subcategory=Tops">
        Tops
    </a>
</li>

<li>
    <a href="shop.php?category=Baby%20%26%20Toddler&subcategory=Leggings">
        Leggings
    </a>
</li>

<li>
    <a href="shop.php?category=Baby%20%26%20Toddler&subcategory=Jeans">
        Jeans
    </a>
</li>

<li>
    <a href="shop.php?category=Baby%20%26%20Toddler&subcategory=Sets">
        Sets
    </a>
</li>

<li>
    <a href="shop.php?category=Baby%20%26%20Toddler&subcategory=Sleepwear">
        Sleepwear
    </a>
</li>

<li>
    <a href="shop.php?category=Baby%20%26%20Toddler&subcategory=Outerwear">
        Outerwear
    </a>
</li>

<li>
    <a href="shop.php?category=Baby%20%26%20Toddler&subcategory=Shoes">
        Shoes
    </a>
</li>

                </ul>

                <h3 class="mt">
    <a href="shop.php?category=toddler-girls-sale" class="sale-heading">
        Sale
    </a>
</h3>

            </div>

           

            <!-- Nursery & More -->

            <!-- Right Banner -->

            <div class="mega-banner">

                <img src="assets/images/banners/baby-right.jfif" alt="Baby Collection">

                <h4>Made for Little Ones</h4>

                <p>Gentle fabrics, playful designs and everyday comfort.</p>

            </div>

        </div>

    </div>

</li>

</nav>

</nav>


    <!-- SEARCH + ICONS -->

    <div class="header-actions-row">

        <form
            action="search.php"
            method="GET"
            class="search-box"
        >

            <input
                type="text"
                name="q"
                placeholder="Search products"
                autocomplete="off"
                required
            >

            <button
                type="submit"
                aria-label="Search"
            >

                <i class="fa-solid fa-magnifying-glass"></i>

            </button>

        </form>


        <div class="header-icons">

            <a href="#" aria-label="Account">
                <i class="fa-regular fa-user"></i>
            </a>


            <a
                href="wishlist.php"
                class="wishlist-icon"
                aria-label="Wishlist"
            >

                <i class="fa-regular fa-heart"></i>

                <?php if($wishlistTotal > 0){ ?>

                    <span class="wishlist-count">
                        <?= $wishlistTotal ?>
                    </span>

                <?php } ?>

            </a>


            <a
                href="cart.php"
                class="cart-icon"
                aria-label="Cart"
            >

                <i class="fa-solid fa-bag-shopping"></i>

                <?php if($bagCount > 0){ ?>

                    <span class="cart-count">
                        <?= $bagCount; ?>
                    </span>

                <?php } ?>

            </a>

        </div>

    </div>


</div>

</div>

