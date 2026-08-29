<?php

include "../includes/db.php";
include "../includes/categories.php";
include "includes/header.php";

/* =====================================================
   GET PRODUCT ID
===================================================== */

if (!isset($_GET['id'])) {
    die("Product ID not found.");
}

$id = (int) $_GET['id'];


/* =====================================================
   GET PRODUCT
===================================================== */

$result = mysqli_query(
    $conn,
    "SELECT * FROM products WHERE id='$id'"
);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Product not found.");
}

$product = mysqli_fetch_assoc($result);


/* =====================================================
   UPDATE PRODUCT
===================================================== */

if (isset($_POST['update_product'])) {


    /* BASIC INFORMATION */

    $product_name = mysqli_real_escape_string(
        $conn,
        $_POST['product_name']
    );

    $category = mysqli_real_escape_string(
        $conn,
        $_POST['category']
    );

    $sub_category = mysqli_real_escape_string(
        $conn,
        $_POST['sub_category']
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
        $_POST['gender']
    );


    /* PRICE */

    $price = $_POST['price'];

    $old_price = $_POST['old_price'];


    /* DESCRIPTION */

    $description = mysqli_real_escape_string(
        $conn,
        $_POST['description']
    );


    /* PRODUCT DETAILS */

    $material = mysqli_real_escape_string(
        $conn,
        $_POST['material']
    );

    $badge = mysqli_real_escape_string(
        $conn,
        $_POST['badge']
    );

    $stock = $_POST['stock'];

    $sku = mysqli_real_escape_string(
        $conn,
        $_POST['sku']
    );

    $brand = mysqli_real_escape_string(
        $conn,
        $_POST['brand']
    );

    $fit = mysqli_real_escape_string(
        $conn,
        $_POST['fit']
    );

    $sleeve_type = mysqli_real_escape_string(
        $conn,
        $_POST['sleeve_type']
    );

    $neck_type = mysqli_real_escape_string(
        $conn,
        $_POST['neck_type']
    );

    $pattern_type = mysqli_real_escape_string(
        $conn,
        $_POST['pattern_type']
    );


    /* POLICIES */

    $care_instructions = mysqli_real_escape_string(
        $conn,
        $_POST['care_instructions']
    );

    $shipping_info = mysqli_real_escape_string(
        $conn,
        $_POST['shipping_info']
    );

    $return_policy = mysqli_real_escape_string(
        $conn,
        $_POST['return_policy']
    );


    /* =================================================
       NEW ARRIVAL
    ================================================= */

    $is_new_arrival = isset($_POST['is_new_arrival'])
        ? 1
        : 0;


    /* =================================================
       BACK TO SCHOOL
    ================================================= */

    $is_back_to_school = isset($_POST['is_back_to_school'])
        ? 1
        : 0;


    /* =================================================
       SCHOOL CATEGORY
    ================================================= */

    /* =================================================
   SCHOOL CATEGORY
================================================= */

$school_category = '';
$school_subcategory = '';

if ($is_back_to_school == 1) {

    $school_category = isset($_POST['school_category'])
        ? mysqli_real_escape_string(
            $conn,
            $_POST['school_category']
        )
        : '';

    $school_subcategory = isset($_POST['school_subcategory'])
        ? mysqli_real_escape_string(
            $conn,
            $_POST['school_subcategory']
        )
        : '';

}

/* =================================================
   PRODUCT SECTION
================================================= */

$section = isset($_POST['section'])
    ? mysqli_real_escape_string(
        $conn,
        $_POST['section']
    )
    : 'every_generation';


/* =================================================
   FEATURED SECTION
================================================= */

$featured_section = isset($_POST['featured_section'])
    ? mysqli_real_escape_string(
        $conn,
        $_POST['featured_section']
    )
    : '';

    /* =================================================
       IMAGE
    ================================================= */

    $image = $product['image'];


    if (!empty($_FILES['image']['name'])) {


        $new_image = $_FILES['image']['name'];

        $tmp = $_FILES['image']['tmp_name'];


        /* Create unique image name */

        $image_name =
            time() . "_" . $new_image;


        /* Correct product folder */

        $folder = "../uploads/products/";


        if (!is_dir($folder)) {

            mkdir(
                $folder,
                0777,
                true
            );

        }


        /* Upload new image */

        if (
            move_uploaded_file(
                $tmp,
                $folder . $image_name
            )
        ) {


            /* Delete old image */

            if (
                !empty($image)
                &&
                file_exists(
                    $folder . $image
                )
            ) {

                unlink(
                    $folder . $image
                );

            }


            $image = $image_name;

        }

    }


    /* =================================================
       UPDATE DATABASE
    ================================================= */

    $query = "

    UPDATE products SET

        product_name='$product_name',

        category='$category',

        sub_category='$sub_category',

        collection='$collection',

collection_type='$collection_type',

        gender='$gender',

        price='$price',

        old_price='$old_price',

        description='$description',

        care_instructions='$care_instructions',

        shipping_info='$shipping_info',

        return_policy='$return_policy',

        material='$material',

        badge='$badge',

        image='$image',

        stock='$stock',

        sku='$sku',

        brand='$brand',

        fit='$fit',

        sleeve_type='$sleeve_type',

        neck_type='$neck_type',

        pattern_type='$pattern_type',

       is_new_arrival='$is_new_arrival',

is_back_to_school='$is_back_to_school',

school_category='$school_category',

school_subcategory='$school_subcategory',

section='$section',

featured_section='$featured_section'
    WHERE id='$id'

    ";


    /* =================================================
       RUN UPDATE
    ================================================= */

    if (mysqli_query($conn, $query)) {

        header(
            "Location: products.php"
        );

        exit();

    } else {

        die(
            "SQL Error: " .
            mysqli_error($conn)
        );

    }

}

?>



<div class="content">


<h1>
    Edit Product
</h1>


<form
    method="POST"
    enctype="multipart/form-data"
>


<!-- =====================================================
     PRODUCT NAME
===================================================== -->

<label>
    Product Name
</label>

<input
    type="text"
    name="product_name"
    value="<?= htmlspecialchars($product['product_name']); ?>"
    required
>



<!-- =====================================================
     CATEGORY
===================================================== -->

<label>Category</label><br>

<select
    name="category"
    id="category"

>

    <option value="">
        Select Category
    </option>

    <?php foreach ($loomwear_categories as $category => $subcategories): ?>

        <option
            value="<?= htmlspecialchars($category); ?>"
            <?= ($product['category'] == $category) ? 'selected' : ''; ?>
        >
            <?= htmlspecialchars($category); ?>
        </option>

    <?php endforeach; ?>

</select>

<br><br>

<!-- =====================================================
     SUB CATEGORY
===================================================== -->

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
     COLLECTION
===================================================== -->

<hr>

<h3>Collection</h3>

<label>Collection</label><br>

<select
    name="collection"
    id="collection"
>

    <option value=""
        <?= empty($product['collection']) ? 'selected' : ''; ?>>
        None
    </option>

    <option value="Collaborations"
        <?= $product['collection'] == 'Collaborations' ? 'selected' : ''; ?>>
        Collaborations
    </option>

    <option value="Licensed Collection"
        <?= $product['collection'] == 'Licensed Collection' ? 'selected' : ''; ?>>
        Licensed Collection
    </option>

    <option value="LoomWearX"
        <?= $product['collection'] == 'LoomWearX' ? 'selected' : ''; ?>>
        LoomWearX
    </option>

</select>

<br><br>


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
     GENDER
===================================================== -->

<label>
    Gender
</label>

<select name="gender">

    <option value="Male"
        <?= $product['gender'] == 'Male' ? 'selected' : ''; ?>>
        Male
    </option>

    <option value="Female"
        <?= $product['gender'] == 'Female' ? 'selected' : ''; ?>>
        Female
    </option>

    <option value="Unisex"
        <?= $product['gender'] == 'Unisex' ? 'selected' : ''; ?>>
        Unisex
    </option>

</select>



<!-- =====================================================
     PRICE
===================================================== -->

<label>
    Price
</label>

<input
    type="number"
    name="price"
    value="<?= htmlspecialchars($product['price']); ?>"
>



<label>
    Old Price
</label>

<input
    type="number"
    name="old_price"
    value="<?= htmlspecialchars($product['old_price']); ?>"
>



<!-- =====================================================
     DESCRIPTION
===================================================== -->

<label>
    Description
</label>

<textarea name="description"><?= htmlspecialchars($product['description']); ?></textarea>



<!-- =====================================================
     MATERIAL
===================================================== -->

<label>
    Material
</label>

<input
    type="text"
    name="material"
    value="<?= htmlspecialchars($product['material']); ?>"
>



<!-- =====================================================
     BADGE
===================================================== -->

<label>
    Badge
</label>

<select name="badge">

    <option value="NEW"
        <?= $product['badge'] == 'NEW' ? 'selected' : ''; ?>>
        NEW
    </option>

    <option value="SALE"
        <?= $product['badge'] == 'SALE' ? 'selected' : ''; ?>>
        SALE
    </option>

    <option value="FEATURED"
        <?= $product['badge'] == 'FEATURED' ? 'selected' : ''; ?>>
        FEATURED
    </option>

</select>



<!-- =====================================================
     STOCK
===================================================== -->

<label>
    Stock
</label>

<input
    type="number"
    name="stock"
    value="<?= htmlspecialchars($product['stock']); ?>"
>



<!-- =====================================================
     SKU
===================================================== -->

<label>
    SKU
</label>

<input
    type="text"
    name="sku"
    value="<?= htmlspecialchars($product['sku']); ?>"
>



<!-- =====================================================
     BRAND
===================================================== -->

<label>
    Brand
</label>

<input
    type="text"
    name="brand"
    value="<?= htmlspecialchars($product['brand']); ?>"
>



<!-- =====================================================
     FIT
===================================================== -->

<label>
    Fit
</label>

<select name="fit">

    <option value="Regular Fit"
        <?= $product['fit'] == 'Regular Fit' ? 'selected' : ''; ?>>
        Regular Fit
    </option>

    <option value="Slim Fit"
        <?= $product['fit'] == 'Slim Fit' ? 'selected' : ''; ?>>
        Slim Fit
    </option>

    <option value="Oversized Fit"
        <?= $product['fit'] == 'Oversized Fit' ? 'selected' : ''; ?>>
        Oversized Fit
    </option>

    <option value="Relaxed Fit"
        <?= $product['fit'] == 'Relaxed Fit' ? 'selected' : ''; ?>>
        Relaxed Fit
    </option>

</select>



<!-- =====================================================
     SLEEVE
===================================================== -->

<label>
    Sleeve Type
</label>

<select name="sleeve_type">

    <option value="">
        Not Applicable
    </option>

    <option value="Half Sleeve"
        <?= $product['sleeve_type'] == 'Half Sleeve' ? 'selected' : ''; ?>>
        Half Sleeve
    </option>

    <option value="Full Sleeve"
        <?= $product['sleeve_type'] == 'Full Sleeve' ? 'selected' : ''; ?>>
        Full Sleeve
    </option>

    <option value="Sleeveless"
        <?= $product['sleeve_type'] == 'Sleeveless' ? 'selected' : ''; ?>>
        Sleeveless
    </option>

</select>



<!-- =====================================================
     NECK
===================================================== -->

<label>
    Neck Type
</label>

<select name="neck_type">

    <option value="">
        Not Applicable
    </option>

    <option value="Round Neck"
        <?= $product['neck_type'] == 'Round Neck' ? 'selected' : ''; ?>>
        Round Neck
    </option>

    <option value="Polo Neck"
        <?= $product['neck_type'] == 'Polo Neck' ? 'selected' : ''; ?>>
        Polo Neck
    </option>

    <option value="Hooded"
        <?= $product['neck_type'] == 'Hooded' ? 'selected' : ''; ?>>
        Hooded
    </option>

    <option value="V Neck"
        <?= $product['neck_type'] == 'V Neck' ? 'selected' : ''; ?>>
        V Neck
    </option>

</select>



<!-- =====================================================
     PATTERN
===================================================== -->

<label>
    Pattern
</label>

<input
    type="text"
    name="pattern_type"
    value="<?= htmlspecialchars($product['pattern_type']); ?>"
>



<!-- =====================================================
     CARE
===================================================== -->

<label>
    Care Instructions
</label>

<textarea name="care_instructions"><?= htmlspecialchars($product['care_instructions']); ?></textarea>



<!-- =====================================================
     SHIPPING
===================================================== -->

<label>
    Shipping Information
</label>

<textarea name="shipping_info"><?= htmlspecialchars($product['shipping_info']); ?></textarea>



<!-- =====================================================
     RETURN
===================================================== -->

<label>
    Return Policy
</label>

<textarea name="return_policy"><?= htmlspecialchars($product['return_policy']); ?></textarea>



<!-- =====================================================
     NEW ARRIVAL
===================================================== -->

<hr>

<h3>
    Product Placement
</h3>


<label>

    <input
        type="checkbox"
        name="is_new_arrival"
        value="1"
        <?= $product['is_new_arrival'] == 1 ? 'checked' : ''; ?>
    >

    Show in New Arrivals

</label>



<!-- =====================================================
     BACK TO SCHOOL
===================================================== -->

<label>

    <input
        type="checkbox"
        name="is_back_to_school"
        value="1"
        id="is_back_to_school"
        <?= $product['is_back_to_school'] == 1 ? 'checked' : ''; ?>
    >

    Show in Back to School

</label>



<!-- =====================================================
     SCHOOL CATEGORY
===================================================== -->

<div id="school-category-box">

    <label>
        School Category
    </label>

    <select
        name="school_category"
        id="school_category"
    >

        <option value="">
            Select School Category
        </option>

        <option
            value="Girls"
            <?= $product['school_category'] == 'Girls' ? 'selected' : ''; ?>
        >
            Girls
        </option>

        <option
            value="Boys"
            <?= $product['school_category'] == 'Boys' ? 'selected' : ''; ?>
        >
            Boys
        </option>

        <option
            value="Toddler Girl"
            <?= $product['school_category'] == 'Toddler Girl' ? 'selected' : ''; ?>
        >
            Toddler Girl
        </option>

        <option
            value="Toddler Boy"
            <?= $product['school_category'] == 'Toddler Boy' ? 'selected' : ''; ?>
        >
            Toddler Boy
        </option>

    </select>


    <br><br>


    <!-- SCHOOL SUBCATEGORY -->

    <label>
        School Subcategory
    </label>

    <select
        name="school_subcategory"
        id="school_subcategory"
    >

        <option value="">
            Select School Subcategory
        </option>

    </select>

</div>

<!-- =====================================================
     PRODUCT SECTION
===================================================== -->

<hr>

<h3>
    Product Placement
</h3>


<label>
    Product Section
</label>

<select
    name="section"
    id="section"
    required
>

    <option
        value="every_generation"
        <?= $product['section'] == 'every_generation'
            ? 'selected'
            : ''; ?>
    >
        Every Generation - Find Your Style
    </option>

    <option
        value="new_arrival"
        <?= $product['section'] == 'new_arrival'
            ? 'selected'
            : ''; ?>
    >
        New Arrivals
    </option>

    <option
        value="school"
        <?= $product['section'] == 'school'
            ? 'selected'
            : ''; ?>
    >
        Back to School
    </option>

</select>

<br><br>


<!-- =====================================================
     NEW & FEATURED
===================================================== -->

<label>
    New & Featured Placement
</label>

<select
    name="featured_section"
>

    <option
        value=""
        <?= empty($product['featured_section'])
            ? 'selected'
            : ''; ?>
    >
        None
    </option>

    <option
        value="new_arrivals"
        <?= $product['featured_section'] == 'new_arrivals'
            ? 'selected'
            : ''; ?>
    >
        New Arrivals
    </option>

    <option
        value="trending"
        <?= $product['featured_section'] == 'trending'
            ? 'selected'
            : ''; ?>
    >
        Trending Now
    </option>

    <option
        value="best_sellers"
        <?= $product['featured_section'] == 'best_sellers'
            ? 'selected'
            : ''; ?>
    >
        Best Sellers
    </option>

    <option
        value="matching_sets"
        <?= $product['featured_section'] == 'matching_sets'
            ? 'selected'
            : ''; ?>
    >
        Matching Sets
    </option>

    <option
        value="online_exclusives"
        <?= $product['featured_section'] == 'online_exclusives'
            ? 'selected'
            : ''; ?>
    >
        Online Exclusives
    </option>

    <option
        value="back_in_stock"
        <?= $product['featured_section'] == 'back_in_stock'
            ? 'selected'
            : ''; ?>
    >
        Back In Stock
    </option>

</select>

<br><br>


<!-- =====================================================
     CURRENT IMAGE
===================================================== -->

<label>
    Current Image
</label>

<br>


<img
    src="../uploads/products/<?= htmlspecialchars($product['image']); ?>"
    width="120"
    style="object-fit:cover;"
>


<br><br>



<!-- =====================================================
     CHANGE IMAGE
===================================================== -->

<label>
    Change Image
</label>

<input
    type="file"
    name="image"
>


<br><br>



<!-- =====================================================
     UPDATE
===================================================== -->

<button
    type="submit"
    name="update_product"
>

    Update Product

</button>


</form>


</div>


/* =====================================================
   SCHOOL CATEGORY & SUBCATEGORY
===================================================== */

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
       MAIN ELEMENTS
    ===================================================== */

    const categorySelect =
        document.getElementById("category");

    const subCategorySelect =
        document.getElementById("sub_category");

    const currentSubCategory =
        <?= json_encode($product['sub_category'] ?? ''); ?>;


    /* =====================================================
       LOAD NORMAL + ACCESSORY SUBCATEGORIES
    ===================================================== */

    function loadSubcategories(
        category,
        selectedSubcategory = ''
    ) {

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


                            if (
                                accessory ===
                                selectedSubcategory
                            ) {

                                option.selected =
                                    true;

                            }


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


                if (
                    subcategory ===
                    selectedSubcategory
                ) {

                    option.selected =
                        true;

                }


                subCategorySelect.appendChild(
                    option
                );

            }
        );

    }


    /* =====================================================
       INITIAL SUBCATEGORY LOAD
    ===================================================== */

    loadSubcategories(
        categorySelect.value,
        currentSubCategory
    );


    /* =====================================================
       CATEGORY CHANGE
    ===================================================== */

    categorySelect.addEventListener(
        "change",
        function () {

            loadSubcategories(
                this.value
            );

        }
    );


    /* =====================================================
       BACK TO SCHOOL
    ===================================================== */

    const schoolCheckbox =
        document.getElementById(
            "is_back_to_school"
        );

    const schoolBox =
        document.getElementById(
            "school-category-box"
        );

    const schoolCategory =
        document.getElementById(
            "school_category"
        );

    const schoolSubcategory =
        document.getElementById(
            "school_subcategory"
        );


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


    const currentSchoolSubcategory =
        <?= json_encode(
            $product['school_subcategory'] ?? ''
        ); ?>;


    /* =====================================================
       LOAD SCHOOL SUBCATEGORIES
    ===================================================== */

    function loadSchoolSubcategories(
        selectedSubcategory = ''
    ) {

        const selectedCategory =
            schoolCategory.value;

        schoolSubcategory.innerHTML =
            '<option value="">Select School Subcategory</option>';


        if (
            selectedCategory &&
            schoolSubcategories[
                selectedCategory
            ]
        ) {

            schoolSubcategories[
                selectedCategory
            ].forEach(
                function (subcategory) {

                    const option =
                        document.createElement(
                            "option"
                        );

                    option.value =
                        subcategory;

                    option.textContent =
                        subcategory;


                    if (
                        subcategory ===
                        selectedSubcategory
                    ) {

                        option.selected =
                            true;

                    }


                    schoolSubcategory.appendChild(
                        option
                    );

                }
            );

        }

    }


    /* =====================================================
       SHOW / HIDE SCHOOL FIELDS
    ===================================================== */

    function updateSchoolFields() {

        if (
            schoolCheckbox.checked
        ) {

            schoolBox.style.display =
                "block";

            loadSchoolSubcategories(
                currentSchoolSubcategory
            );

        } else {

            schoolBox.style.display =
                "none";

        }

    }


    /* =====================================================
       SCHOOL CATEGORY CHANGE
    ===================================================== */

    schoolCategory.addEventListener(
        "change",
        function () {

            loadSchoolSubcategories();

        }
    );


    /* =====================================================
       SCHOOL CHECKBOX CHANGE
    ===================================================== */

    schoolCheckbox.addEventListener(
        "change",
        function () {

            updateSchoolFields();

        }
    );


    /* =====================================================
       INITIAL SCHOOL LOAD
    ===================================================== */

    updateSchoolFields();

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

function loadCollectionTypes(
    selectedType = ''
) {

    const collection =
        collectionSelect.value;

    collectionTypeSelect.innerHTML =
        '<option value="">None</option>';


    if (collectionTypes[collection]) {

        collectionTypes[collection].forEach(
            function (type) {

                const option =
                    document.createElement("option");

                option.value =
                    type;

                option.textContent =
                    type;


                if (
                    type ===
                    selectedType
                ) {

                    option.selected =
                        true;

                }


                collectionTypeSelect.appendChild(
                    option
                );

            }
        );

    }

}


const currentCollectionType =
    <?= json_encode(
        $product['collection_type'] ?? ''
    ); ?>;


/* =====================================================
   INITIAL COLLECTION TYPE
===================================================== */

loadCollectionTypes(
    currentCollectionType
);


/* =====================================================
   COLLECTION CHANGE
===================================================== */

collectionSelect.addEventListener(
    "change",
    function () {

        loadCollectionTypes();

    }
);

</script>


<script src="assets/js/admin.js"></script>