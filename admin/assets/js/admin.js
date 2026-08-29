// Category -> Sub Category

const subCategories = {

    "Men":[
        "Shop All",
        "Jeans",
        "LoomWear Sweats",
        "Tees",
        "Shirts",
        "Pants",
        "Outerwear",
        "Polos",
        "Sweaters",
        "Pajamas",
        "Underwear",
        "Accessories"
    ],

    "Women":[
        "Shop All",
        "New Arrivals",
        "Dresses",
        "Tops",
        "Jeans",
        "Pants",
        "Skirts",
        "Hoodies",
        "Sweaters",
        "Activewear",
        "Sleepwear",
        "Accessories"
    ],

    "Girls":[
        "Shop All",
        "New Arrivals",
        "Tops",
        "Jeans",
        "Dresses",
        "Leggings",
        "Hoodies",
        "Accessories"
    ],

    "Boys":[
        "Shop All",
        "New Arrivals",
        "Tees",
        "Jeans",
        "Pants",
        "Hoodies",
        "Outerwear",
        "Accessories"
    ],

    "Baby & Toddler":[
        "Shop All",
        "Baby Girl",
        "Baby Boy",
        "Toddler Girl",
        "Toddler Boy",
        "Sleepwear",
        "Accessories"
    ]

};

const categorySelect = document.getElementById("category");
const subCategorySelect = document.getElementById("sub_category");

if (categorySelect && subCategorySelect) {

    categorySelect.addEventListener("change", function () {

        const category = this.value;

        subCategorySelect.innerHTML =
            '<option value="">Select Sub Category</option>';

        if (subCategories[category]) {

            subCategories[category].forEach(function (item) {

                const option = document.createElement("option");

                option.value = item;
                option.textContent = item;

                subCategorySelect.appendChild(option);

            });

        }

    });

}

const newArrival =
    document.getElementById("is_new_arrival");

const backToSchool =
    document.getElementById("is_back_to_school");

const schoolBox =
    document.getElementById("school-category-box");

const schoolCategory =
    document.getElementById("school_category");


/* Show / hide school category */

function updateSchoolFields() {

    if (backToSchool.value === "1") {

        schoolBox.style.display = "block";

        /*
         * School products must NOT
         * be New Arrivals.
         */

        newArrival.value = "0";

        schoolCategory.required = true;

    } else {

        schoolBox.style.display = "none";

        schoolCategory.value = "";

        schoolCategory.required = false;

    }

}


/* When Back to School changes */

backToSchool.addEventListener(
    "change",
    updateSchoolFields
);


/* When New Arrival changes */

newArrival.addEventListener(
    "change",
    function () {

        if (newArrival.value === "1") {

            /*
             * New Arrival products
             * cannot be Back to School.
             */

            backToSchool.value = "0";

            schoolBox.style.display = "none";

            schoolCategory.value = "";

            schoolCategory.required = false;

        }

    }
);


/* Initial state */

updateSchoolFields();


document.addEventListener("DOMContentLoaded", function () {

    const backToSchool =
        document.getElementById("is_back_to_school");

    const schoolCategoryBox =
        document.getElementById("school-category-box");

    const schoolCategory =
        document.getElementById("school_category");

    const schoolSubcategory =
        document.getElementById("school_subcategory");


    /* ==========================================
       SCHOOL SUBCATEGORIES
    ========================================== */

    const schoolSubcategories = {

        "Girls": [

            "School Uniforms",
            "School Dresses",
            "School Shirts & Blouses",
            "School Skirts",
            "Sweaters & Cardigans",
            "Backpacks"

        ],

        "Boys": [

            "School Uniforms",
            "School Shirts",
            "School Polo Shirts",
            "School Pants & Trousers",
            "Sweaters & Cardigans",
            "Backpacks"

        ],

        "Toddler Girl": [

            "School Dresses",
            "School Tops",
            "School Skirts",
            "Pants & Leggings",
            "Sweaters & Cardigans",
            "Backpacks"

        ],

        "Toddler Boy": [

            "School Shirts & Polos",
            "School T-Shirts",
            "School Pants & Shorts",
            "Joggers & Sweatpants",
            "Sweaters & Cardigans",
            "Backpacks"

        ]

    };


    /* ==========================================
       SHOW / HIDE SCHOOL CATEGORY
    ========================================== */

    function updateSchoolFields() {

        if (backToSchool.value === "1") {

            schoolCategoryBox.style.display = "block";

        } else {

            schoolCategoryBox.style.display = "none";

            schoolCategory.value = "";

            schoolSubcategory.innerHTML = `
                <option value="">
                    Select School Subcategory
                </option>
            `;

        }

    }


    /* ==========================================
       UPDATE SUBCATEGORIES
    ========================================== */

    schoolCategory.addEventListener(
        "change",
        function () {

            const category =
                this.value;


            schoolSubcategory.innerHTML = `
                <option value="">
                    Select School Subcategory
                </option>
            `;


            if (
                category &&
                schoolSubcategories[category]
            ) {

                schoolSubcategories[category]
                    .forEach(function (subcategory) {

                        const option =
                            document.createElement("option");

                        option.value =
                            subcategory;

                        option.textContent =
                            subcategory;

                        schoolSubcategory
                            .appendChild(option);

                    });

            }

        }
    );


    /* ==========================================
       BACK TO SCHOOL CHANGE
    ========================================== */

    backToSchool.addEventListener(
        "change",
        updateSchoolFields
    );


    /* ==========================================
       INITIAL STATE
    ========================================== */

    updateSchoolFields();

});

const categorySelect = document.getElementById("category");
const subCategorySelect = document.getElementById("sub_category");


const subCategories = {

    "Men": [
        "Shop All",
        "Jeans",
        "LoomWear Sweats",
        "Tees",
        "Shirts",
        "Pants",
        "Outerwear",
        "Polos",
        "Sweaters",
        "Pajamas",
        "Underwear",
        "Accessories"
    ],


    "Women": [
        "Shop All",
        "Dresses",
        "Tops",
        "Jeans",
        "Pants",
        "Skirts",
        "Shirts & Blouses",
        "Sweaters",
        "Hoodies & Sweatshirts",
        "Outerwear",
        "Activewear",
        "Accessories"
    ],


    "Girls": [
        "Shop All",
        "Dresses",
        "Tops",
        "Jeans",
        "Pants",
        "Skirts",
        "Shirts & Blouses",
        "Sweaters",
        "Hoodies & Sweatshirts",
        "Outerwear",
        "Activewear",
        "Accessories"
    ],


    "Boys": [
        "Shop All",
        "Tees",
        "Shirts",
        "Jeans",
        "Pants",
        "Shorts",
        "Polos",
        "Sweaters",
        "Hoodies & Sweatshirts",
        "Outerwear",
        "Activewear",
        "Accessories"
    ],


    "Baby & Toddler": [
        "Shop All",
        "Bodysuits",
        "Dresses",
        "Tops",
        "Bottoms",
        "Rompers",
        "Sets",
        "Pajamas",
        "Sweaters",
        "Hoodies",
        "Outerwear",
        "Accessories"
    ]

};


categorySelect.addEventListener("change", function() {

    const selectedCategory = this.value;

    subCategorySelect.innerHTML =
        '<option value="">Select Sub Category</option>';


    if (
        subCategories[selectedCategory]
    ) {

        subCategories[selectedCategory].forEach(
            function(subCategory) {

                const option =
                    document.createElement("option");

                option.value = subCategory;

                option.textContent = subCategory;

                subCategorySelect.appendChild(option);

            }
        );

    }

});

/* =====================================================
   BACK TO SCHOOL SUBCATEGORIES
===================================================== */

const schoolCategory =
    document.getElementById("school_category");

const schoolSubcategory =
    document.getElementById("school_subcategory");

const schoolBox =
    document.getElementById("school-category-box");

const schoolSubcategories = {

    "Girls": [

        "School Uniforms",
        "School Dresses",
        "School Tops & Shirts",
        "School Skirts",
        "School Pants & Trousers",
        "Backpacks"

    ],

    "Boys": [

        "School Uniforms",
        "School Shirts",
        "School T-Shirts",
        "School Pants & Trousers",
        "School Shorts",
        "Backpacks"

    ],

    "Toddler Girl": [

        "School Dresses",
        "School Tops",
        "School Bottoms",
        "School Sets",
        "School Sweaters & Jackets",
        "Backpacks"

    ],

    "Toddler Boy": [

        "School Shirts",
        "School T-Shirts",
        "School Pants",
        "School Shorts",
        "School Sets",
        "Backpacks"

    ]

};


/* =====================================================
   UPDATE SUBCATEGORIES
===================================================== */

function updateSchoolSubcategories() {

    const category =
        schoolCategory.value;


    schoolSubcategory.innerHTML =
        '<option value="">Select School Subcategory</option>';


    if (
        schoolSubcategories[category]
    ) {

        schoolSubcategories[category].forEach(
            function(subcategory) {

                const option =
                    document.createElement("option");

                option.value =
                    subcategory;

                option.textContent =
                    subcategory;

                schoolSubcategory.appendChild(
                    option
                );

            }
        );

    }

}


/* =====================================================
   SCHOOL CATEGORY CHANGE
===================================================== */

schoolCategory.addEventListener(
    "change",
    updateSchoolSubcategories
);


/* =====================================================
   SHOW / HIDE SCHOOL FIELDS
===================================================== */

function updateSchoolBox() {

    if (
        document.getElementById(
            "is_back_to_school"
        ).value == "1"
    ) {

        schoolBox.style.display =
            "block";

    } else {

        schoolBox.style.display =
            "none";

        schoolCategory.value = "";

        schoolSubcategory.innerHTML =
            '<option value="">Select School Subcategory</option>';

    }

}


document.getElementById(
    "is_back_to_school"
).addEventListener(
    "change",
    updateSchoolBox
);


updateSchoolBox();
