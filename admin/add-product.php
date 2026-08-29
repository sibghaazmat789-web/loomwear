<?php

include "../includes/db.php";
include "../includes/categories.php";
include "includes/header.php";


/* =========================================================
   ADD PRODUCT
========================================================= */

if (isset($_POST['add_product'])) {


    /* =====================================================
       BASIC PRODUCT INFORMATION
    ===================================================== */

    $product_name = mysqli_real_escape_string(
        $conn,
        $_POST['product_name'] ?? ''
    );

    $category = mysqli_real_escape_string(
        $conn,
        $_POST['category'] ?? ''
    );

    $sub_category = mysqli_real_escape_string(
        $conn,
        $_POST['sub_category'] ?? ''
    );

    $collection = isset($_POST['collection'])
    ? mysqli_real_escape_string(
        $conn,
        $_POST['collection']
    )
    : '';

$collection_type = isset($_POST['collection_type'])
    ? mysqli_real_escape_string(
        $conn,
        $_POST['collection_type']
    )
    : '';

    $gender = mysqli_real_escape_string(
        $conn,
        $_POST['gender'] ?? ''
    );

    $price = (float) ($_POST['price'] ?? 0);

    $old_price = (float) ($_POST['old_price'] ?? 0);

    $description = mysqli_real_escape_string(
        $conn,
        $_POST['description'] ?? ''
    );

    $material = mysqli_real_escape_string(
        $conn,
        $_POST['material'] ?? ''
    );

    $badge = mysqli_real_escape_string(
        $conn,
        $_POST['badge'] ?? ''
    );

    $stock = (int) ($_POST['stock'] ?? 0);

    $sku = mysqli_real_escape_string(
        $conn,
        $_POST['sku'] ?? ''
    );


    /* =====================================================
       ADDITIONAL PRODUCT DETAILS
    ===================================================== */

    $brand = mysqli_real_escape_string(
        $conn,
        $_POST['brand'] ?? ''
    );

    $fit = mysqli_real_escape_string(
        $conn,
        $_POST['fit'] ?? ''
    );

    $sleeve_type = mysqli_real_escape_string(
        $conn,
        $_POST['sleeve_type'] ?? ''
    );

    $neck_type = mysqli_real_escape_string(
        $conn,
        $_POST['neck_type'] ?? ''
    );

    $pattern_type = mysqli_real_escape_string(
        $conn,
        $_POST['pattern_type'] ?? ''
    );

    $care_instructions = mysqli_real_escape_string(
        $conn,
        $_POST['care_instructions'] ?? ''
    );

    $shipping_info = mysqli_real_escape_string(
        $conn,
        $_POST['shipping_info'] ?? ''
    );

    $return_policy = mysqli_real_escape_string(
        $conn,
        $_POST['return_policy'] ?? ''
    );


    /* =====================================================
       PRODUCT SECTION
    ===================================================== */

    $section = mysqli_real_escape_string(
        $conn,
        $_POST['section'] ?? 'every_generation'
    );


    /* =====================================================
       FEATURED SECTION
    ===================================================== */

    $featured_section = mysqli_real_escape_string(
        $conn,
        $_POST['featured_section'] ?? ''
    );


    /* =====================================================
       SCHOOL CATEGORY
    ===================================================== */

    $school_category = mysqli_real_escape_string(
        $conn,
        $_POST['school_category'] ?? ''
    );


    /* =====================================================
       SCHOOL SUBCATEGORY
    ===================================================== */

    $school_subcategory = mysqli_real_escape_string(
        $conn,
        $_POST['school_subcategory'] ?? ''
    );


    /* =====================================================
       PRODUCT IMAGE
    ===================================================== */

    if (
        !isset($_FILES['image']) ||
        empty($_FILES['image']['name'])
    ) {

        die("Please select a product image.");

    }


    $image = $_FILES['image']['name'];

    $tmp = $_FILES['image']['tmp_name'];

    $image_name = time() . "_" . basename($image);

    $folder = "../uploads/products/";


    if (!is_dir($folder)) {

        mkdir(
            $folder,
            0777,
            true
        );

    }


    if (
        !move_uploaded_file(
            $tmp,
            $folder . $image_name
        )
    ) {

        die("Error uploading product image.");

    }


    /* =====================================================
       INSERT PRODUCT
    ===================================================== */

    $query = "INSERT INTO products
    (
        product_name,
        category,
        sub_category,
        collection,
collection_type,
        gender,
        price,
        old_price,
        description,
        care_instructions,
        shipping_info,
        return_policy,
        material,
        badge,
        image,
        stock,
        sku,
        brand,
        fit,
        sleeve_type,
        neck_type,
        pattern_type,
        section,
        featured_section,
        school_category,
        school_subcategory
    )

    VALUES
    (
        '$product_name',
        '$category',
        '$sub_category',
        '$collection',
    '$collection_type',
        '$gender',
        '$price',
        '$old_price',
        '$description',
        '$care_instructions',
        '$shipping_info',
        '$return_policy',
        '$material',
        '$badge',
        '$image_name',
        '$stock',
        '$sku',
        '$brand',
        '$fit',
        '$sleeve_type',
        '$neck_type',
        '$pattern_type',
        '$section',
        '$featured_section',
        '$school_category',
        '$school_subcategory'
    )";


    if (mysqli_query($conn, $query)) {

        header("Location: products.php");
        exit();

    } else {

        die(
            "SQL Error: " .
            mysqli_error($conn)
        );

    }

}

?>


<!DOCTYPE html>

<html>

<head>

    <title>Add Product</title>

</head>


<body>


<h2>Add Product</h2>


<form
    action=""
    method="POST"
    enctype="multipart/form-data"
>


<!-- =====================================================
     PRODUCT NAME
====================================================== -->

<label>Product Name</label><br>

<input
    type="text"
    name="product_name"
    required
>

<br><br>


<!-- =====================================================
     CATEGORY
====================================================== -->

<label>Category</label><br>

<select
    name="category"
    id="category"
>

    <option value="">
        Select Category
    </option>

    <?php foreach ($loomwear_categories as $category => $subcategories): ?>

        <option value="<?= htmlspecialchars($category); ?>">

            <?= htmlspecialchars($category); ?>

        </option>

    <?php endforeach; ?>

</select>

<br><br>


<!-- =====================================================
     SUB CATEGORY
====================================================== -->

<label>Sub Category</label><br>

<select
    name="sub_category"
    id="sub_category"
>

    <option value="">
        Select Sub Category
    </option>

</select>

<br><br>


<!-- =====================================================
     GENDER
====================================================== -->

<label>Gender</label><br>

<select name="gender">

    <option value="Male">
        Male
    </option>

    <option value="Female">
        Female
    </option>

    <option value="Unisex">
        Unisex
    </option>

</select>

<br><br>


<!-- =====================================================
     PRICE
====================================================== -->

<label>Price</label><br>

<input
    type="number"
    name="price"
    required
>

<br><br>


<!-- =====================================================
     OLD PRICE
====================================================== -->

<label>Old Price</label><br>

<input
    type="number"
    name="old_price"
>

<br><br>


<!-- =====================================================
     DESCRIPTION
====================================================== -->

<label>Description</label><br>

<textarea
    name="description"
></textarea>

<br><br>


<!-- =====================================================
     MATERIAL
====================================================== -->

<label>Material</label><br>

<input
    type="text"
    name="material"
>

<br><br>


<!-- =====================================================
     BADGE
====================================================== -->

<label>Badge</label><br>

<select name="badge">

    <option value="">
        None
    </option>

    <option value="NEW">
        NEW
    </option>

    <option value="SALE">
        SALE
    </option>

    <option value="FEATURED">
        FEATURED
    </option>

</select>

<br><br>


<!-- =====================================================
     PRODUCT PLACEMENT
===================================================== -->

<hr>

<h3>Product Placement</h3>

<br>


<!-- =====================================================
     MAIN SECTION
===================================================== -->

<label>Product Section</label><br>

<select
    name="section"
    id="section"
    required
>

    <option value="">
        Select Product Section
    </option>

    <option value="every_generation">
        Every Generation - Find Your Style
    </option>

    <option value="new_arrival">
        New Arrivals
    </option>

    <option value="school">
        Back to School
    </option>

</select>

<br><br>

<!-- =====================================================
     COLLECTION
===================================================== -->

<hr>

<h3>Collection</h3>

<label>Collection</label><br>

<select
    name="collection"
    id="collection"
>

    <option value="">
        None
    </option>

    <option value="Collaborations">
        Collaborations
    </option>

    <option value="Licensed Collection">
        Licensed Collection
    </option>

    <option value="LoomWearX">
        LoomWearX
    </option>

</select>

<br><br>


<!-- =====================================================
     COLLECTION TYPE
===================================================== -->

<label>Collection Type</label><br>

<select
    name="collection_type"
    id="collection_type"
>

    <option value="">
        None
    </option>

</select>

<br><br>


<!-- =====================================================
     NEW & FEATURED PLACEMENT
===================================================== -->

<label>New & Featured Placement</label><br>

<select
    name="featured_section"
    id="featured_section"
>

    <option value="">
        None
    </option>

    <option value="new_arrivals">
        New Arrivals
    </option>

    <option value="trending">
        Trending Now
    </option>

    <option value="best_sellers">
        Best Sellers
    </option>

    <option value="matching_sets">
        Matching Sets
    </option>

    <option value="online_exclusives">
        Online Exclusives
    </option>

    <option value="back_in_stock">
        Back In Stock
    </option>

</select>

<br><br>


<!-- =====================================================
     SCHOOL CATEGORY
===================================================== -->

<div
    id="school-category-box"
    style="display:none;"
>

    <label>School Category</label><br>

    <select
        name="school_category"
        id="school_category"
    >

        <option value="">
            Select School Category
        </option>

        <option value="Girls">
            Girls
        </option>

        <option value="Boys">
            Boys
        </option>

        <option value="Toddler Girl">
            Toddler Girl
        </option>

        <option value="Toddler Boy">
            Toddler Boy
        </option>

    </select>

    <br><br>


    <label>School Subcategory</label><br>

    <select
        name="school_subcategory"
        id="school_subcategory"
    >

        <option value="">
            Select School Subcategory
        </option>

    </select>

</div>

<br>


<!-- =====================================================
     STOCK
===================================================== -->

<label>Stock</label><br>

<input
    type="number"
    name="stock"
    value="0"
>

<br><br>


<!-- =====================================================
     SKU
===================================================== -->

<label>SKU</label><br>

<input
    type="text"
    name="sku"
    placeholder="LW-H001"
>

<br><br>


<!-- =====================================================
     BRAND
===================================================== -->

<label>Brand</label><br>

<input
    type="text"
    name="brand"
    value="LoomWear"
>

<br><br>


<!-- =====================================================
     FIT
===================================================== -->

<label>Fit</label><br>

<select name="fit">

    <option value="">
        Not Applicable
    </option>

    <option value="Regular Fit">
        Regular Fit
    </option>

    <option value="Slim Fit">
        Slim Fit
    </option>

    <option value="Oversized Fit">
        Oversized Fit
    </option>

    <option value="Relaxed Fit">
        Relaxed Fit
    </option>

</select>

<br><br>


<!-- =====================================================
     SLEEVE TYPE
===================================================== -->

<label>Sleeve Type</label><br>

<select name="sleeve_type">

    <option value="">
        Not Applicable
    </option>

    <option value="Half Sleeve">
        Half Sleeve
    </option>

    <option value="Full Sleeve">
        Full Sleeve
    </option>

    <option value="Sleeveless">
        Sleeveless
    </option>

</select>

<br><br>


<!-- =====================================================
     NECK TYPE
===================================================== -->

<label>Neck Type</label><br>

<select name="neck_type">

    <option value="">
        Not Applicable
    </option>

    <option value="Round Neck">
        Round Neck
    </option>

    <option value="Polo Neck">
        Polo Neck
    </option>

    <option value="Hooded">
        Hooded
    </option>

    <option value="V Neck">
        V Neck
    </option>

    <option value="Collar Neck">
        Collar Neck
    </option>

</select>

<br><br>


<!-- =====================================================
     PATTERN
===================================================== -->

<label>Pattern</label><br>

<input
    type="text"
    name="pattern_type"
>

<br><br>


<!-- =====================================================
     CARE
===================================================== -->

<label>Care Instructions</label><br>

<textarea
    name="care_instructions"
></textarea>

<br><br>


<!-- =====================================================
     SHIPPING
===================================================== -->

<label>Shipping Information</label><br>

<textarea
    name="shipping_info"
></textarea>

<br><br>


<!-- =====================================================
     RETURN POLICY
===================================================== -->

<label>Return Policy</label><br>

<textarea
    name="return_policy"
></textarea>

<br><br>


<!-- =====================================================
     PRODUCT IMAGE
===================================================== -->

<label>Product Image</label><br>

<input
    type="file"
    name="image"
    required
>

<br><br>


<!-- =====================================================
     SUBMIT
===================================================== -->

<button
    type="submit"
    name="add_product"
>

    Add Product

</button>


</form>


<script>

document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       LOOMWEAR CATEGORIES
    ===================================================== */

    const loomwearCategories =
        <?= json_encode($loomwear_categories); ?>;

        const loomwearAccessories =
    <?= json_encode($loomwear_accessories); ?>;


    /* =====================================================
       ELEMENTS
    ===================================================== */

    const categorySelect =
        document.getElementById("category");

    const subCategorySelect =
        document.getElementById("sub_category");

    const sectionSelect =
        document.getElementById("section");

    const schoolBox =
        document.getElementById("school-category-box");

    const schoolCategorySelect =
        document.getElementById("school_category");

    const schoolSubcategorySelect =
        document.getElementById("school_subcategory");


    /* =====================================================
   LOAD NORMAL + ACCESSORY SUBCATEGORIES
===================================================== */

categorySelect.addEventListener("change", function () {

    const category = this.value;

    subCategorySelect.innerHTML =
        '<option value="">Select Sub Category</option>';

    if (!loomwearCategories[category]) {
        return;
    }


    loomwearCategories[category].forEach(
        function (subcategory) {

            /* =========================
               IGNORE "ALL"
            ========================= */

            if (subcategory === "All") {
                return;
            }


            /* =========================
               ACCESSORIES
            ========================= */

            if (
                subcategory === "Accessories" &&
                loomwearAccessories[category]
            ) {

                const accessoriesGroup =
                    document.createElement("optgroup");

                accessoriesGroup.label =
                    "Accessories";


                loomwearAccessories[category].forEach(
                    function (accessory) {

                        const option =
                            document.createElement("option");

                        option.value =
                            accessory;

                        option.textContent =
                            accessory;

                        accessoriesGroup.appendChild(
                            option
                        );

                    }
                );


                subCategorySelect.appendChild(
                    accessoriesGroup
                );

                return;
            }


            /* =========================
               NORMAL SUBCATEGORY
            ========================= */

            const option =
                document.createElement("option");

            option.value =
                subcategory;

            option.textContent =
                subcategory;

            subCategorySelect.appendChild(
                option
            );

        }
    );

});

    /* =====================================================
       SCHOOL SUBCATEGORIES
    ===================================================== */

    const schoolSubcategories = {

        "Girls": [
            "School Uniforms",
            "School Shirts & Blouses",
            "School Skirts & Bottoms",
            "Sweaters & Cardigans",
            "Backpacks"
        ],

        "Boys": [
            "School Uniforms",
            "School Shirts",
            "School Pants & Trousers",
            "Sweaters & Cardigans",
            "Backpacks"
        ],

        "Toddler Girl": [
            "School Dresses",
            "School Skirts",
            "Pants & Leggings",
            "Sweaters & Cardigans",
            "Backpacks"
        ],

        "Toddler Boy": [
            "School Shirts & Polos",
            "School Pants & Shorts",
            "Joggers & Sweatpants",
            "Sweaters & Cardigans",
            "Backpacks"
        ]

    };


    /* =====================================================
       LOAD SCHOOL SUBCATEGORIES
    ===================================================== */

    schoolCategorySelect.addEventListener(
        "change",
        function () {

            const schoolCategory =
                this.value;

            schoolSubcategorySelect.innerHTML =
                '<option value="">Select School Subcategory</option>';


            if (
                schoolSubcategories[
                    schoolCategory
                ]
            ) {

                schoolSubcategories[
                    schoolCategory
                ].forEach(function (subcategory) {

                    const option =
                        document.createElement("option");

                    option.value =
                        subcategory;

                    option.textContent =
                        subcategory;

                    schoolSubcategorySelect.appendChild(
                        option
                    );

                });

            }

        }
    );


    /* =====================================================
       SHOW / HIDE SCHOOL FIELDS
    ===================================================== */

    function updateSectionFields() {

        if (sectionSelect.value === "school") {

            schoolBox.style.display =
                "block";

        } else {

            schoolBox.style.display =
                "none";

            schoolCategorySelect.value =
                "";

            schoolSubcategorySelect.innerHTML =
                '<option value="">Select School Subcategory</option>';

        }

    }


    sectionSelect.addEventListener(
        "change",
        updateSectionFields
    );


    updateSectionFields();

});

/* =====================================================
   COLLECTION TYPES
===================================================== */

const collectionSelect =
    document.getElementById("collection");

const collectionTypeSelect =
    document.getElementById("collection_type");


const collectionTypes = {

    "Collaborations": [
        "Artist",
        "Designer",
        "Brand",
        "Limited Edition"
    ],

    "Licensed Collection": [
        "Characters",
        "Entertainment",
        "Sports",
        "Limited Edition"
    ],

    "LoomWearX": [
        "Men",
        "Women",
        "Kids",
        "Performance",
        "Limited Drops"
    ]

};


/* =====================================================
   LOAD COLLECTION TYPES
===================================================== */

collectionSelect.addEventListener(
    "change",
    function () {

        const collection =
            this.value;

        collectionTypeSelect.innerHTML =
            '<option value="">None</option>';

        if (collectionTypes[collection]) {

            collectionTypes[collection].forEach(
                function (type) {

                    const option =
                        document.createElement("option");

                    option.value = type;

                    option.textContent = type;

                    collectionTypeSelect.appendChild(
                        option
                    );

                }
            );

        }

    }
);

</script>

<script src="assets/js/admin.js"></script>


</body>

</html>