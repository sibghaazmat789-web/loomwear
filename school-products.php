<?php

include "includes/db.php";
include "includes/header.php";


/* =====================================================
   GET CATEGORY
===================================================== */

$school_category = isset($_GET['category'])
    ? mysqli_real_escape_string(
        $conn,
        $_GET['category']
    )
    : '';


/* =====================================================
   GET SUBCATEGORY
===================================================== */

$school_subcategory = isset($_GET['subcategory'])
    ? mysqli_real_escape_string(
        $conn,
        $_GET['subcategory']
    )
    : '';


/* =====================================================
   CHECK DATA
===================================================== */

if (
    $school_category == '' ||
    $school_subcategory == ''
) {

    header("Location: school.php");

    exit;

}


/* =====================================================
   GET PRODUCTS
===================================================== */

$query = "

    SELECT *

    FROM products

    WHERE is_back_to_school = 1

    AND school_category = '$school_category'

    AND school_subcategory = '$school_subcategory'

    ORDER BY id DESC

";


$result = mysqli_query(
    $conn,
    $query
);


if (!$result) {

    die(
        "SQL Error: " .
        mysqli_error($conn)
    );

}

?>


<!-- =====================================================
     PAGE HEADER
===================================================== -->

<section class="school-page-header">

    <span>
        <?= htmlspecialchars($school_category); ?>
    </span>

    <h1>
        <?= htmlspecialchars($school_subcategory); ?>
    </h1>

    <p>
        School-ready styles made for every adventure.
    </p>

</section>


<!-- =====================================================
     PRODUCTS
===================================================== -->

<section class="school-products">

    <div class="school-products-heading">

        <span>
            <?= htmlspecialchars($school_category); ?>
        </span>

        <h2>
            <?= htmlspecialchars($school_subcategory); ?>
        </h2>

    </div>


    <div class="school-product-grid">


        <?php

        if (mysqli_num_rows($result) > 0) {

            while (
                $product =
                mysqli_fetch_assoc($result)
            ) {

        ?>


        <!-- PRODUCT CARD -->

        <a
            href="product-details.php?id=<?= $product['id']; ?>"
            class="school-product-card"
        >


            <!-- IMAGE -->

            <div class="school-product-image">

                <img
                    src="uploads/products/<?= htmlspecialchars(
                        $product['image']
                    ); ?>"
                    alt="<?= htmlspecialchars(
                        $product['product_name']
                    ); ?>"
                >


                <?php if (
                    !empty($product['badge'])
                ) { ?>

                    <span class="school-product-badge">

                        <?= htmlspecialchars(
                            $product['badge']
                        ); ?>

                    </span>

                <?php } ?>

            </div>


            <!-- NAME -->

            <h3>

                <?= htmlspecialchars(
                    $product['product_name']
                ); ?>

            </h3>


            <!-- GENDER -->

            <p>

                <?= htmlspecialchars(
                    $product['gender']
                ); ?>

            </p>


            <!-- PRICE -->

            <span class="school-product-price">

                Rs.
                <?= number_format(
                    $product['price']
                ); ?>

            </span>


        </a>


        <?php

            }

        } else {

        ?>


            <div class="school-no-products">

                <h2>
                    Coming Soon
                </h2>

                <p>
                    New <?= htmlspecialchars(
                        $school_subcategory
                    ); ?> styles are coming soon.
                </p>

            </div>


        <?php

        }

        ?>


    </div>

</section>


<?php include "includes/footer.php"; ?>