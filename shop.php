<?php

include "includes/db.php";
include "includes/header.php";
include "includes/categories.php";


/* =====================================================
   GET PARAMETERS
===================================================== */

$category = isset($_GET['category'])
    ? trim($_GET['category'])
    : '';

$subcategory = isset($_GET['sub_category'])
    ? trim($_GET['sub_category'])
    : (
        isset($_GET['subcategory'])
            ? trim($_GET['subcategory'])
            : ''
    );

$collection = isset($_GET['collection'])
    ? trim($_GET['collection'])
    : '';

$collection_type = isset($_GET['collection_type'])
    ? trim($_GET['collection_type'])
    : '';

$featured = isset($_GET['featured'])
    ? trim($_GET['featured'])
    : '';


/* =====================================================
   ESCAPE VALUES
===================================================== */

$category = mysqli_real_escape_string($conn, $category);
$subcategory = mysqli_real_escape_string($conn, $subcategory);
$collection = mysqli_real_escape_string($conn, $collection);
$collection_type = mysqli_real_escape_string($conn, $collection_type);
$featured = mysqli_real_escape_string($conn, $featured);


/* =====================================================
   MASTER CATEGORY VALIDATION
===================================================== */

$valid_category = false;

if (
    $category !== '' &&
    isset($loomwear_categories[$category])
) {
    $valid_category = true;
}


/* =====================================================
   MASTER SUBCATEGORY VALIDATION
===================================================== */

$valid_subcategory = false;

if (
    $valid_category &&
    $subcategory !== ''
) {

    /* NORMAL SUBCATEGORIES */

    if (
        in_array(
            $subcategory,
            $loomwear_categories[$category],
            true
        )
    ) {
        $valid_subcategory = true;
    }


    /* ACCESSORY SUBCATEGORIES */

    elseif (
        isset($loomwear_accessories[$category]) &&
        in_array(
            $subcategory,
            $loomwear_accessories[$category],
            true
        )
    ) {
        $valid_subcategory = true;
    }

}


/* =====================================================
   FEATURED FILTERS
===================================================== */

$featured_titles = [

    'new_arrivals' =>
        'New Arrivals',

    'trending' =>
        'Trending Now',

    'best_sellers' =>
        'Best Sellers',

    'matching_sets' =>
        'Matching Sets',

    'online_exclusives' =>
        'Online Exclusives',

    'back_in_stock' =>
        'Back In Stock'

];


/* =====================================================
   SALE CATEGORIES
===================================================== */

$sale_categories = [

    'men-sale' =>
        'Men',

    'women-sale' =>
        'Women',

    'girls-sale' =>
        'Girls',

    'boys-sale' =>
        'Boys',

    'toddler-girls-sale' =>
        'Baby & Toddler',

    'toddler-boys-sale' =>
        'Baby & Toddler'

];


/* =====================================================
   COLLECTION INFORMATION
===================================================== */

$is_collection = false;

$collection_heading = '';

if ($collection !== '') {

    $is_collection = true;

    if ($collection === 'Collaborations') {

        $collection_heading = 'Collaborations';

    } elseif ($collection === 'Licensed Collection') {

        $collection_heading = 'Licensed Collection';

    } elseif ($collection === 'LoomWearX') {

        $collection_heading = 'LoomWearX';

    }

}


/* =====================================================
   SALE INFORMATION
===================================================== */

$is_sale = false;

$real_sale_category = '';

if (isset($sale_categories[$category])) {

    $is_sale = true;

    $real_sale_category = mysqli_real_escape_string(
        $conn,
        $sale_categories[$category]
    );

}


/* =====================================================
   BASE QUERY
===================================================== */

/*
   IMPORTANT:
   $sql MUST be created before adding filters.
*/

$sql = "
    SELECT *
    FROM products
    WHERE is_back_to_school = 0
";


/* =====================================================
   CATEGORY FILTER
===================================================== */

if ($valid_category) {

    $sql .= "
        AND category = '$category'
    ";

}


/* =====================================================
   SUBCATEGORY FILTER
===================================================== */

if (
    $valid_subcategory &&
    $subcategory !== 'All'
) {

    $sql .= "
        AND sub_category = '$subcategory'
    ";

}


/* =====================================================
   COLLECTION FILTER
===================================================== */

if ($collection !== '') {

    $sql .= "
        AND collection = '$collection'
    ";

}

if ($collection_type !== '') {

    $sql .= "
        AND collection_type = '$collection_type'
    ";

}


/* =====================================================
   FEATURED FILTER
===================================================== */

if (isset($featured_titles[$featured])) {

    /*
       This uses your existing featured_section column.
    */

    $sql .= "
        AND featured_section = '$featured'
    ";

}


/* =====================================================
   SALE FILTER
===================================================== */

if ($is_sale) {

    $sql .= "
        AND category = '$real_sale_category'
        AND old_price > price
    ";

}


/* =====================================================
   ORDER
===================================================== */

$sql .= "
    ORDER BY id DESC
";


/* =====================================================
   RUN QUERY
===================================================== */

$result = mysqli_query($conn, $sql);

if (!$result) {

    die(
        "SQL Error: " .
        mysqli_error($conn)
    );

}

?>


<section class="shop-page">


<!-- =====================================================
     PAGE HEADING
===================================================== -->

<div class="section-heading">

    <span>

        <?php

        /* FEATURED */

        if (isset($featured_titles[$featured])) {

    echo "NEW & FEATURED";

} elseif ($is_collection) {

    echo strtoupper(
        htmlspecialchars($collection_heading)
    );

} elseif ($is_sale) {

            echo "SALE";


        /* SUBCATEGORY */

        } elseif (
            $valid_subcategory &&
            $subcategory !== 'All'
        ) {

            echo strtoupper(
                htmlspecialchars($category)
            );


        /* CATEGORY */

        } elseif ($valid_category) {

            echo strtoupper(
                htmlspecialchars($category)
            );


        /* SHOP ALL */

        } else {

            echo "SHOP";

        }

        ?>

    </span>


    <h2>

        <?php

        /* =============================================
           FEATURED TITLE
        ============================================= */

       if (
    isset(
        $featured_titles[$featured]
    )
) {

    echo htmlspecialchars(
        $featured_titles[$featured]
    );

} elseif ($is_collection) {

    if ($collection_type !== '') {

        echo htmlspecialchars(
            $collection_type
        );

    } else {

        echo htmlspecialchars(
            $collection_heading
        );

    }

} elseif ($is_sale) {

            echo "Sale";


        /* =============================================
           SUBCATEGORY TITLE
        ============================================= */

        } elseif (
            $valid_subcategory &&
            $subcategory !== 'All'
        ) {

            echo htmlspecialchars(
                $subcategory
            );


        /* =============================================
           CATEGORY TITLE
        ============================================= */

        } elseif ($valid_category) {

            echo htmlspecialchars(
                $category
            );


        /* =============================================
           DEFAULT
        ============================================= */

        } else {

            echo "Shop All";

        }

        ?>

    </h2>

</div>


<!-- =====================================================
     PRODUCT GRID
===================================================== -->

<div class="product-grid">


<?php

if (
    mysqli_num_rows($result) > 0
) {

    while (
        $product =
        mysqli_fetch_assoc($result)
    ) {

?>


<!-- =====================================================
     PRODUCT CARD
===================================================== -->

<a
    href="product-details.php?id=<?= (int)$product['id']; ?>"
    class="product-card"
>


<!-- PRODUCT IMAGE -->

<div class="product-image">

    <img
        src="uploads/products/<?= htmlspecialchars(
            $product['image']
        ); ?>"
        alt="<?= htmlspecialchars(
            $product['product_name']
        ); ?>"
    >


    <?php

    if (
        !empty($product['badge'])
    ) {

    ?>

        <span class="badge">

            <?= htmlspecialchars(
                $product['badge']
            ); ?>

        </span>

    <?php

    }

    ?>

</div>


<!-- PRODUCT NAME -->

<h4>

    <?= htmlspecialchars(
        $product['product_name']
    ); ?>

</h4>


<!-- GENDER -->

<p>

    <?= htmlspecialchars(
        $product['gender']
    ); ?>

</p>


<!-- PRICE -->

<span class="price">

    Rs.
    <?= number_format(
        $product['price']
    ); ?>


    <?php

    if (
        !empty($product['old_price']) &&
        $product['old_price'] >
        $product['price']
    ) {

    ?>

        <del>

            Rs.
            <?= number_format(
                $product['old_price']
            ); ?>

        </del>

    <?php

    }

    ?>

</span>


</a>


<?php

    }

} else {

?>


<!-- =====================================================
     NO PRODUCTS
===================================================== -->

<div class="no-products">

    <h3>
        No products found.
    </h3>

    <p>
        There are currently no products in this section.
    </p>

</div>


<?php

}

?>


</div>

</section>


<?php

include "includes/footer.php";

?>