<?php

include "includes/db.php";
include "includes/header.php";


/* =====================================================
   GET SCHOOL CATEGORY
===================================================== */

$school_category = isset($_GET['category'])
    ? mysqli_real_escape_string(
        $conn,
        $_GET['category']
    )
    : '';


/* =====================================================
   GET SCHOOL SUBCATEGORY
===================================================== */

$school_subcategory = isset($_GET['subcategory'])
    ? mysqli_real_escape_string(
        $conn,
        $_GET['subcategory']
    )
    : '';


/* =====================================================
   SCHOOL SUBCATEGORIES
===================================================== */

$school_subcategories = [

    "Girls" => [

        [
            "name" => "School Uniforms",
            "image" => "uniform-g.jfif"
        ],

        [
            "name" => "School Shirts & Blouses",
            "image" => "shirt-g.jfif"
        ],

        [
            "name" => "School Skirts & Bottoms",
            "image" => "skirt-g.jfif"
        ],

        [
            "name" => "Sweaters & Cardigans",
            "image" => "sweater-g.jfif"
        ],

        [
            "name" => "Backpacks",
            "image" => "backpack-g.jfif"
        ]

    ],


    "Boys" => [

        [
            "name" => "School Uniforms",
            "image" => "uniform-boy.jfif"
        ],

        [
            "name" => "School Shirts",
            "image" => "shirts-boys.jfif"
        ],
        [
            "name" => "School Pants & Trousers",
            "image" => "pants-boys.jfif"
        ],

        [
            "name" => "Sweaters & Cardigans",
            "image" => "sweater-boys.jfif"
        ],

        [
            "name" => "Backpacks",
            "image" => "backpack-boys.webp"
        ]

    ],


    "Toddler Girl" => [

        [
            "name" => "School Dresses",
            "image" => "dresses-tg.jfif"
        ],

        [
            "name" => "School Skirts",
            "image" => "skirts-tg.jfif"
        ],

        [
            "name" => "Pants & Leggings",
            "image" => "pants-tg.jfif"
        ],

        [
            "name" => "Sweaters & Cardigans",
            "image" => "sweaters-tg.jfif"
        ],

        [
            "name" => "Backpacks",
            "image" => "backpacks-tg.jfif"
        ]

    ],


    "Toddler Boy" => [

        [
            "name" => "School Shirts & Polos",
            "image" => "polos-tb.jfif"
        ],
        [
            "name" => "School Pants & Shorts",
            "image" => "pants-tb.jfif"
        ],

        [
            "name" => "Joggers & Sweatpants",
            "image" => "sweatpants-tb.jfif"
        ],

        [
            "name" => "Sweaters & Cardigans",
            "image" => "sweaters-tb.jfif"
        ],

        [
            "name" => "Backpacks",
            "image" => "backpacks-tb.jfif"
        ]

    ]

];


/* =====================================================
   GET PRODUCTS
===================================================== */

if ($school_category != '' && $school_subcategory != '') {

    $query = "
        SELECT *
        FROM products
        WHERE is_back_to_school = 1
        AND school_category = '$school_category'
        AND school_subcategory = '$school_subcategory'
        ORDER BY id DESC
    ";

}
elseif ($school_category != '') {

    $query = "
        SELECT *
        FROM products
        WHERE is_back_to_school = 1
        AND school_category = '$school_category'
        ORDER BY id DESC
    ";

}
else {

    $query = "
        SELECT *
        FROM products
        WHERE is_back_to_school = 1
        ORDER BY id DESC
    ";

}


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

    <span>LOOMWEAR</span>

    <h1>

        <?php

        if ($school_subcategory != '') {

            echo htmlspecialchars(
                $school_subcategory
            );

        }
        elseif ($school_category != '') {

            echo htmlspecialchars(
                $school_category
            );

        }
        else {

            echo "Back to School";

        }

        ?>

    </h1>

    <p>
        School-ready styles made for every adventure.
    </p>

</section>


<!-- =====================================================
     MAIN CATEGORY NAVIGATION
===================================================== -->

<section class="school-navigation">

    <a
        href="school.php?category=Girls"
        class="<?= ($school_category == 'Girls')
            ? 'active'
            : ''; ?>"
    >
        Girls
    </a>


    <a
        href="school.php?category=Boys"
        class="<?= ($school_category == 'Boys')
            ? 'active'
            : ''; ?>"
    >
        Boys
    </a>


    <a
        href="school.php?category=<?= urlencode(
            'Toddler Girl'
        ); ?>"
        class="<?= ($school_category == 'Toddler Girl')
            ? 'active'
            : ''; ?>"
    >
        Toddler Girl
    </a>


    <a
        href="school.php?category=<?= urlencode(
            'Toddler Boy'
        ); ?>"
        class="<?= ($school_category == 'Toddler Boy')
            ? 'active'
            : ''; ?>"
    >
        Toddler Boy
    </a>

</section>


<?php if (
    $school_category != '' &&
    isset(
        $school_subcategories[
            $school_category
        ]
    )
) { ?>


<!-- =====================================================
     SUBCATEGORY CARDS
===================================================== -->

<section class="school-subcategories">

    <div class="school-section-heading">

        <span>SHOP BY CATEGORY</span>

        <h2>
            <?= htmlspecialchars(
                $school_category
            ); ?>
            School
        </h2>

    </div>


    <div class="school-subcategory-grid">


        <?php

        foreach (
            $school_subcategories[
                $school_category
            ]
            as $subcategory
        ) {

        ?>


        <a
            href="school-products.php?category=<?= urlencode(
                $school_category
            ); ?>&subcategory=<?= urlencode(
                $subcategory['name']
            ); ?>"
            class="school-subcategory-card"
        >


            <div class="school-subcategory-image">

                <img
                    src="assets/images/school/<?= strtolower(
                        str_replace(
                            ' ',
                            '-',
                            $school_category
                        )
                    ); ?>/<?= $subcategory['image']; ?>"
                    alt="<?= htmlspecialchars(
                        $subcategory['name']
                    ); ?>"
                >

            </div>


            <div class="school-subcategory-info">

                <h3>

                    <?= htmlspecialchars(
                        $subcategory['name']
                    ); ?>

                </h3>

                <span>
                    Shop Now →
                </span>

            </div>


        </a>


        <?php } ?>


    </div>

</section>

<?php } ?>


<!-- =====================================================
     PRODUCTS
===================================================== -->

<section class="school-products">

    <div class="school-products-heading">

        <?php if ($school_subcategory != '') { ?>

            <span>
                <?= htmlspecialchars(
                    $school_category
                ); ?>
            </span>

            <h2>
                <?= htmlspecialchars(
                    $school_subcategory
                ); ?>
            </h2>

        <?php } elseif ($school_category != '') { ?>

            <span>
                BACK TO SCHOOL
            </span>

            <h2>
                <?= htmlspecialchars(
                    $school_category
                ); ?>
                Collection
            </h2>

        <?php } else { ?>

            <span>
                BACK TO SCHOOL
            </span>

            <h2>
                School Collection
            </h2>

        <?php } ?>

    </div>


    <div class="school-product-grid">


        <?php

        if (
            mysqli_num_rows($result) > 0
        ) {

            while (
                $product =
                mysqli_fetch_assoc($result)
            ) {

        ?>


        <a
            href="product-details.php?id=<?= $product['id']; ?>"
            class="school-product-card"
        >


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


            <h3>

                <?= htmlspecialchars(
                    $product['product_name']
                ); ?>

            </h3>


            <p>

                <?= htmlspecialchars(
                    $product['gender']
                ); ?>

            </p>


            <span class="school-product-price">

                Rs.
                <?= number_format(
                    $product['price']
                ); ?>

            </span>


        </a>


        <?php

            }

        }
        else {

        ?>


            <div class="school-no-products">

                <h2>
                    Coming Soon
                </h2>

                <p>
                    New school styles are coming soon.
                </p>

            </div>


        <?php

        }

        ?>


    </div>

</section>


<?php include "includes/footer.php"; ?>