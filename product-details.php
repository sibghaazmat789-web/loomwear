<?php

include "includes/db.php";

// Check if product ID exists
if (!isset($_GET['id'])) {
    die("Product ID not found.");
}

$id = (int)$_GET['id'];


// Get product
$query = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}

$product = mysqli_fetch_assoc($result);

/* =====================================================
   SIZE GUIDE CATEGORY
===================================================== */

$sizeGuideCategory = 'men';

$productCategory = strtolower(trim($product['category'] ?? ''));

$productGender = strtolower(trim($product['gender'] ?? ''));

if ($productCategory === 'women' || $productGender === 'female') {

    $sizeGuideCategory = 'women';

} elseif ($productCategory === 'girls') {

    $sizeGuideCategory = 'girls';

} elseif ($productCategory === 'boys') {

    $sizeGuideCategory = 'boys';

} elseif (
    $productCategory === 'baby & toddler' ||
    $productCategory === 'baby' ||
    $productCategory === 'toddler'
) {

    $sizeGuideCategory = 'baby';

} elseif ($productGender === 'male') {

    $sizeGuideCategory = 'men';

}

$discount = 0;

if($product['old_price'] > 0){

    $discount = round(
        (($product['old_price'] - $product['price'])
        / $product['old_price']) * 100
    );

}

if (!$product) {
    die("Product not found.");
}

// Product Sizes
$sizeQuery = mysqli_query($conn,
"SELECT * FROM product_sizes
WHERE product_id = $id
ORDER BY size");

// Product Colours
$colorQuery = mysqli_query($conn,
"SELECT * FROM product_colors
WHERE product_id = $id");

// Related Products
$relatedQuery = mysqli_query($conn,

"SELECT *

FROM products

WHERE category = '{$product['category']}'

AND id != $id

LIMIT 4");

?>
<?php include "includes/header.php"; ?>

<div class="product-page">

    <!-- LEFT -->

    <div class="product-gallery">

        <div class="thumbnail-gallery">

    <!-- MAIN PRODUCT IMAGE -->

    <img
        src="uploads/products/<?= htmlspecialchars($product['image']); ?>"
        class="thumb"
        alt="<?= htmlspecialchars($product['product_name']); ?>"
    >


    <?php

    $gallery = mysqli_query(
        $conn,
        "SELECT *
         FROM product_images
         WHERE product_id='$id'
         ORDER BY sort_order"
    );

    while ($img = mysqli_fetch_assoc($gallery)) {

    ?>

        <img
            src="uploads/products/<?= htmlspecialchars($img['image']); ?>"
            class="thumb"
            alt="<?= htmlspecialchars($product['product_name']); ?>"
        >

    <?php } ?>

</div>


        <div class="main-image">

            <img
id="mainImage"
src="uploads/products/<?= htmlspecialchars($product['image']); ?>"
alt="<?= htmlspecialchars($product['product_name']); ?>">
        </div>

    </div>



    <!-- RIGHT -->

    <div class="product-info">

        <span class="badge">

            <?= $product['badge']; ?>

        </span>

        <h1>

            <?= $product['product_name']; ?>

        </h1>

        <div class="rating">

★★★★★

<span>

4.8 (248 Reviews)

</span>

</div>

        <p class="brand">

            Brand:
            <strong><?= $product['brand']; ?></strong>

        </p>

       <div class="price-box">

    <span class="price">
        Rs. <?= number_format($product['price']); ?>
    </span>

    <?php if($product['old_price'] > 0){ ?>

        <del>
            Rs. <?= number_format($product['old_price']); ?>
        </del>

        <span class="discount">

            <?= $discount; ?>% OFF

        </span>

    <?php } ?>

</div>

<?php

if($product['stock'] > 10){

?>

<p class="stock in-stock">

✔ In Stock

</p>

<?php } else { ?>

<p class="stock low-stock">

Only <?= $product['stock']; ?> left

</p>

<?php } ?>

<div class="delivery-box">

<p>🚚 Free Delivery on orders above Rs. 5,000</p>

<p>↩ Easy 14-Day Returns</p>

<p>🔒 100% Secure Checkout</p>

</div>

        <p class="description">

            <?= $product['description']; ?>

        </p>

        <!-- Colours -->
   <form action="add-to-cart.php" method="POST" id="cartForm">

       <h3>Colours</h3>

<div class="colour-list">

<?php while($color = mysqli_fetch_assoc($colorQuery)){ ?>

<div class="colour-option"
     data-image="uploads/colors/<?= htmlspecialchars($color['image']); ?>"
     data-color="<?= htmlspecialchars($color['color_name']); ?>">

    <span
        style="
            background:<?= htmlspecialchars($color['color_code']); ?>;
            width:28px;
            height:28px;
            border-radius:50%;
            display:block;
            border:1px solid #ccc;">
    </span>

</div>

<?php } ?>

</div>

<input
type="hidden"
id="selectedColor"
name="selectedColor">

<input
type="hidden"
name="product_id"
value="<?= $product['id']; ?>">

        <!-- Sizes -->

       <h3>Sizes</h3>

<div class="size-list">

<?php while($size = mysqli_fetch_assoc($sizeQuery)){ ?>

    <button
        type="button"
        class="size-btn"
        data-size="<?= $size['size']; ?>"
        <?= ($size['stock'] <= 0) ? 'disabled' : ''; ?>>

        <?= $size['size']; ?>

    </button>

<?php } ?>

</div>

<input
    type="hidden"
    id="selectedSize"
    name="selectedSize"
>

<p class="size-guide">

    <button
        type="button"
        class="size-guide-link"
        id="openSizeGuide"
    >
        <i class="fa-solid fa-ruler-horizontal"></i>
        Size Guide
    </button>

</p>


<!-- ==========================================
     SIZE GUIDE MODAL
========================================== -->

<div class="size-guide-modal" id="sizeGuideModal">

    <div class="size-guide-overlay" id="sizeGuideOverlay"></div>

    <div class="size-guide-content">

        <button
            type="button"
            class="size-guide-close"
            id="closeSizeGuide"
            aria-label="Close Size Guide"
        >
            <i class="fa-solid fa-xmark"></i>
        </button>


        <div class="size-guide-header">

            <span>LOOMWEAR FIT GUIDE</span>

            <h2>Find Your Perfect Fit</h2>

            <p>
                Use our size guide to find the right size before ordering.
            </p>

        </div>


        <!-- CATEGORY TABS -->

        <div class="size-guide-tabs">

            <button
    type="button"
    class="size-tab <?= $sizeGuideCategory === 'men' ? 'active' : ''; ?>"
    data-category="men"
>
    Men
</button>

<button
    type="button"
    class="size-tab <?= $sizeGuideCategory === 'women' ? 'active' : ''; ?>"
    data-category="women"
>
    Women
</button>

<button
    type="button"
    class="size-tab <?= $sizeGuideCategory === 'boys' ? 'active' : ''; ?>"
    data-category="boys"
>
    Boys
</button>

<button
    type="button"
    class="size-tab <?= $sizeGuideCategory === 'girls' ? 'active' : ''; ?>"
    data-category="girls"
>
    Girls
</button>

<button
    type="button"
    class="size-tab <?= $sizeGuideCategory === 'baby' ? 'active' : ''; ?>"
    data-category="baby"
>
    Baby & Toddler
</button>

        </div>


        <!-- MEN -->

       <div
    class="size-table-container size-category <?= $sizeGuideCategory === 'men' ? 'active' : ''; ?>"
    id="size-men"
>

            <h3>Men's Clothing</h3>

            <div class="size-table-scroll">

                <table>

                    <thead>

                        <tr>
                            <th>Size</th>
                            <th>Chest</th>
                            <th>Waist</th>
                            <th>Hip</th>
                            <th>Inseam</th>
                        </tr>

                    </thead>

                    <tbody>

                        <tr>
                            <td>XS</td>
                            <td>34–36"</td>
                            <td>28–30"</td>
                            <td>34–36"</td>
                            <td>30"</td>
                        </tr>

                        <tr>
                            <td>S</td>
                            <td>36–38"</td>
                            <td>30–32"</td>
                            <td>36–38"</td>
                            <td>31"</td>
                        </tr>

                        <tr>
                            <td>M</td>
                            <td>38–40"</td>
                            <td>32–34"</td>
                            <td>38–40"</td>
                            <td>32"</td>
                        </tr>

                        <tr>
                            <td>L</td>
                            <td>40–42"</td>
                            <td>34–36"</td>
                            <td>40–42"</td>
                            <td>32"</td>
                        </tr>

                        <tr>
                            <td>XL</td>
                            <td>42–44"</td>
                            <td>36–38"</td>
                            <td>42–44"</td>
                            <td>33"</td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>


        <!-- WOMEN -->

       <div
    class="size-table-container size-category <?= $sizeGuideCategory === 'women' ? 'active' : ''; ?>"
    id="size-women"
>

            <h3>Women's Clothing</h3>

            <div class="size-table-scroll">

                <table>

                    <thead>

                        <tr>
                            <th>Size</th>
                            <th>Bust</th>
                            <th>Waist</th>
                            <th>Hip</th>
                        </tr>

                    </thead>

                    <tbody>

                        <tr>
                            <td>XS</td>
                            <td>32–33"</td>
                            <td>25–26"</td>
                            <td>34–35"</td>
                        </tr>

                        <tr>
                            <td>S</td>
                            <td>34–35"</td>
                            <td>27–28"</td>
                            <td>36–37"</td>
                        </tr>

                        <tr>
                            <td>M</td>
                            <td>36–37"</td>
                            <td>29–30"</td>
                            <td>38–39"</td>
                        </tr>

                        <tr>
                            <td>L</td>
                            <td>38–40"</td>
                            <td>31–33"</td>
                            <td>41–43"</td>
                        </tr>

                        <tr>
                            <td>XL</td>
                            <td>41–43"</td>
                            <td>34–36"</td>
                            <td>44–46"</td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>


        <!-- BOYS -->

        <div
    class="size-table-container size-category <?= $sizeGuideCategory === 'boys' ? 'active' : ''; ?>"
    id="size-boys"
>
            <h3>Boys' Clothing</h3>

            <div class="size-table-scroll">

                <table>

                    <thead>

                        <tr>
                            <th>Size</th>
                            <th>Age</th>
                            <th>Chest</th>
                            <th>Waist</th>
                            <th>Height</th>
                        </tr>

                    </thead>

                    <tbody>

                        <tr>
                            <td>4</td>
                            <td>3–4 Years</td>
                            <td>22"</td>
                            <td>21"</td>
                            <td>39–41"</td>
                        </tr>

                        <tr>
                            <td>6</td>
                            <td>5–6 Years</td>
                            <td>24"</td>
                            <td>22"</td>
                            <td>43–47"</td>
                        </tr>

                        <tr>
                            <td>8</td>
                            <td>7–8 Years</td>
                            <td>26"</td>
                            <td>23"</td>
                            <td>49–53"</td>
                        </tr>

                        <tr>
                            <td>10</td>
                            <td>9–10 Years</td>
                            <td>28"</td>
                            <td>24"</td>
                            <td>54–57"</td>
                        </tr>

                        <tr>
                            <td>12</td>
                            <td>11–12 Years</td>
                            <td>30"</td>
                            <td>25"</td>
                            <td>58–61"</td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>


        <!-- GIRLS -->

        <div
    class="size-table-container size-category <?= $sizeGuideCategory === 'girls' ? 'active' : ''; ?>"
    id="size-girls"
>
            <h3>Girls' Clothing</h3>

            <div class="size-table-scroll">

                <table>

                    <thead>

                        <tr>
                            <th>Size</th>
                            <th>Age</th>
                            <th>Chest</th>
                            <th>Waist</th>
                            <th>Height</th>
                        </tr>

                    </thead>

                    <tbody>

                        <tr>
                            <td>4</td>
                            <td>3–4 Years</td>
                            <td>22"</td>
                            <td>21"</td>
                            <td>39–41"</td>
                        </tr>

                        <tr>
                            <td>6</td>
                            <td>5–6 Years</td>
                            <td>24"</td>
                            <td>22"</td>
                            <td>43–47"</td>
                        </tr>

                        <tr>
                            <td>8</td>
                            <td>7–8 Years</td>
                            <td>26"</td>
                            <td>23"</td>
                            <td>49–53"</td>
                        </tr>

                        <tr>
                            <td>10</td>
                            <td>9–10 Years</td>
                            <td>28"</td>
                            <td>24"</td>
                            <td>54–57"</td>
                        </tr>

                        <tr>
                            <td>12</td>
                            <td>11–12 Years</td>
                            <td>30"</td>
                            <td>25"</td>
                            <td>58–61"</td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>


        <!-- BABY -->

       <div
    class="size-table-container size-category <?= $sizeGuideCategory === 'baby' ? 'active' : ''; ?>"
    id="size-baby"
>
            <h3>Baby & Toddler</h3>

            <div class="size-table-scroll">

                <table>

                    <thead>

                        <tr>
                            <th>Size</th>
                            <th>Age</th>
                            <th>Height</th>
                            <th>Chest</th>
                            <th>Weight</th>
                        </tr>

                    </thead>

                    <tbody>

                        <tr>
                            <td>0–3M</td>
                            <td>0–3 Months</td>
                            <td>20–24"</td>
                            <td>16"</td>
                            <td>Up to 14 lb</td>
                        </tr>

                        <tr>
                            <td>3–6M</td>
                            <td>3–6 Months</td>
                            <td>24–26"</td>
                            <td>17"</td>
                            <td>14–17 lb</td>
                        </tr>

                        <tr>
                            <td>6–12M</td>
                            <td>6–12 Months</td>
                            <td>26–30"</td>
                            <td>18"</td>
                            <td>17–22 lb</td>
                        </tr>

                        <tr>
                            <td>12–18M</td>
                            <td>12–18 Months</td>
                            <td>30–32"</td>
                            <td>19"</td>
                            <td>22–25 lb</td>
                        </tr>

                        <tr>
                            <td>18–24M</td>
                            <td>18–24 Months</td>
                            <td>32–34"</td>
                            <td>20"</td>
                            <td>25–28 lb</td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>


        <!-- HOW TO MEASURE -->

        <div class="size-measure">

            <h3>How to Measure</h3>

            <div class="measure-items">

                <div>
                    <i class="fa-solid fa-ruler-horizontal"></i>
                    <strong>Chest / Bust</strong>
                    <p>
                        Measure around the fullest part of your chest or bust.
                    </p>
                </div>

                <div>
                    <i class="fa-solid fa-ruler"></i>
                    <strong>Waist</strong>
                    <p>
                        Measure around your natural waistline.
                    </p>
                </div>

                <div>
                    <i class="fa-solid fa-person"></i>
                    <strong>Height</strong>
                    <p>
                        Stand straight without shoes and measure from floor to head.
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>

        <div class="quantity">

<button
type="button"
onclick="decreaseQty()">

-

</button>

<input
    type="number"
    id="qty"
    name="quantity"
    value="1"
    min="1"
    max="<?= (int)$product['stock']; ?>"
    data-max-stock="<?= (int)$product['stock']; ?>"
    readonly
>

<button

type="button"

onclick="increaseQty()">

+

</button>

</div>
      <?php if($product['stock'] > 0){ ?>

    <button
    type="submit"
    name="add_to_cart"
    class="add-cart">

        Add To Bag

    </button>

<?php } else { ?>

    <button
    class="add-cart disabled"
    disabled>

        Out of Stock

    </button>

<?php } ?>

<button
    type="submit"
    name="buy_now"
    class="buy-now"
    formaction="buy-now.php"
    formmethod="POST">

    Buy Now

</button>

</form>

      <a

href="add-to-wishlist.php?product=<?= $product['id']; ?>"

class="wishlist">

❤ Add to Wishlist

</a>

<div class="product-tabs">

    <button class="tab-btn active" data-tab="description">
        Description
    </button>

    <button class="tab-btn" data-tab="specifications">
        Specifications
    </button>

    <button class="tab-btn" data-tab="shipping">
        Shipping & Returns
    </button>

    <button class="tab-btn" data-tab="reviews">
        Reviews
    </button>

</div>

<div class="tab-content active" id="description">

    <p><?= nl2br($product['description']); ?></p>

</div>

<div class="tab-content" id="specifications">

    <table class="spec-table">

        <tr>
            <th>Material</th>
            <td><?= $product['material']; ?></td>
        </tr>

        <tr>
            <th>Category</th>
            <td><?= $product['category']; ?></td>
        </tr>

        <tr>
            <th>Sub Category</th>
            <td><?= $product['sub_category']; ?></td>
        </tr>

        <tr>
            <th>Gender</th>
            <td><?= $product['gender']; ?></td>
        </tr>

        <tr>
            <th>Stock</th>
            <td><?= $product['stock']; ?></td>
        </tr>

    </table>

</div>

<div class="tab-content" id="shipping">

    <h4>Care Instructions</h4>
    <p><?= nl2br($product['care_instructions']); ?></p>

    <h4>Shipping Information</h4>
    <p><?= nl2br($product['shipping_info']); ?></p>

    <h4>Return Policy</h4>
    <p><?= nl2br($product['return_policy']); ?></p>

</div>

<div class="tab-content" id="reviews">

    <h3>Customer Reviews</h3>

    <p>No reviews yet.</p>

</div>

    </div>

</div>

<section class="related-products">

    <h2>You May Also Like</h2>

    <div class="related-grid">

        <?php while($related = mysqli_fetch_assoc($relatedQuery)){ ?>

        <div class="related-card">

            <a href="product-details.php?id=<?= $related['id']; ?>">

               <img
    src="uploads/products/<?= htmlspecialchars($related['image']); ?>"
    alt="<?= htmlspecialchars($related['product_name']); ?>"
>

                <?php if(!empty($related['badge'])){ ?>

                    <span class="product-badge">

                        <?= $related['badge']; ?>

                    </span>

                <?php } ?>

                <h3><?= $related['product_name']; ?></h3>

                <p class="related-category">

                    <?= $related['category']; ?>

                </p>

                <div class="related-price">

                    <span>

                        Rs. <?= number_format($related['price']); ?>

                    </span>

                    <?php if($related['old_price'] > 0){ ?>

                    <del>

                        Rs. <?= number_format($related['old_price']); ?>

                    </del>

                    <?php } ?>

                </div>

            </a>

        </div>

        <?php } ?>

    </div>

</section>

<script src="assets/js/product-gallery.js"></script>

<script src="assets/js/product-tabs.js"></script>

<script src="assets/js/product-details.js"></script>

<?php include "includes/footer.php"; ?>