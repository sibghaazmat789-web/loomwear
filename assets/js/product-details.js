/* =========================================================
   LOOMWEAR PRODUCT DETAILS JS
========================================================= */

document.addEventListener("DOMContentLoaded", function () {


    /* =====================================================
       COLOUR SELECTION
    ===================================================== */

    const colourOptions =
        document.querySelectorAll(".colour-option");

    const selectedColour =
        document.getElementById("selectedColor");

    const mainImage =
        document.getElementById("mainImage");


    colourOptions.forEach(function (option) {

        option.addEventListener("click", function () {

            colourOptions.forEach(function (item) {

                item.classList.remove("active");

            });


            this.classList.add("active");


            if (selectedColour) {

                selectedColour.value =
                    this.dataset.color;

            }


            /*
             Change product image if
             colour image exists
            */

            const image =
                this.dataset.image;


            if (
                image &&
                mainImage
            ) {

                mainImage.src = image;

            }

        });

    });



    /* =====================================================
       SIZE SELECTION
    ===================================================== */

    const sizeButtons =
        document.querySelectorAll(".size-btn");

    const selectedSize =
        document.getElementById("selectedSize");


    sizeButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            if (this.disabled) {

                return;

            }


            sizeButtons.forEach(function (btn) {

                btn.classList.remove("active");

            });


            this.classList.add("active");


            if (selectedSize) {

                selectedSize.value =
                    this.dataset.size;

            }

        });

    });



    /* =====================================================
       QUANTITY
    ===================================================== */

    window.increaseQty = function () {

        const qty =
            document.getElementById("qty");


        if (!qty) {

            return;

        }


        const maxStock =
            parseInt(
                qty.dataset.maxStock || "999",
                10
            );


        let current =
            parseInt(qty.value || "1", 10);


        if (current < maxStock) {

            current++;

            qty.value = current;

        }

    };


    window.decreaseQty = function () {

        const qty =
            document.getElementById("qty");


        if (!qty) {

            return;

        }


        let current =
            parseInt(qty.value || "1", 10);


        if (current > 1) {

            current--;

            qty.value = current;

        }

    };



    /* =====================================================
       FORM VALIDATION
    ===================================================== */

    const cartForm =
        document.getElementById("cartForm");


    if (cartForm) {

        cartForm.addEventListener("submit", function (event) {

            /*
             Only validate when product
             is actually being purchased.
            */

            const colour =
                selectedColour
                    ? selectedColour.value.trim()
                    : "";


            const size =
                selectedSize
                    ? selectedSize.value.trim()
                    : "";


            /*
             Check colour
            */

            if (
                colourOptions.length > 0 &&
                colour === ""
            ) {

                event.preventDefault();

                alert("Please select a colour.");

                return;

            }


            /*
             Check size
            */

            if (
                sizeButtons.length > 0 &&
                size === ""
            ) {

                event.preventDefault();

                alert("Please select a size.");

                return;

            }

        });

    }

});

document.addEventListener("DOMContentLoaded", function () {

    /* ==========================================
       SIZE GUIDE
    ========================================== */

    const openSizeGuide = document.getElementById("openSizeGuide");
    const closeSizeGuide = document.getElementById("closeSizeGuide");
    const sizeGuideModal = document.getElementById("sizeGuideModal");
    const sizeGuideOverlay = document.getElementById("sizeGuideOverlay");


    /* OPEN SIZE GUIDE */

    if (openSizeGuide && sizeGuideModal) {

        openSizeGuide.addEventListener("click", function () {

            sizeGuideModal.classList.add("active");

            document.body.classList.add("size-guide-open");

        });

    }


    /* CLOSE SIZE GUIDE */

    function closeSizeGuideModal() {

        if (sizeGuideModal) {

            sizeGuideModal.classList.remove("active");

            document.body.classList.remove("size-guide-open");

        }

    }


    if (closeSizeGuide) {

        closeSizeGuide.addEventListener(
            "click",
            closeSizeGuideModal
        );

    }


    /* CLOSE WHEN CLICKING OUTSIDE */

    if (sizeGuideOverlay) {

        sizeGuideOverlay.addEventListener(
            "click",
            closeSizeGuideModal
        );

    }


    /* CLOSE WITH ESCAPE KEY */

    document.addEventListener("keydown", function (event) {

        if (
            event.key === "Escape" &&
            sizeGuideModal &&
            sizeGuideModal.classList.contains("active")
        ) {

            closeSizeGuideModal();

        }

    });


    /* ==========================================
       SIZE GUIDE CATEGORY TABS
    ========================================== */

    const sizeTabs =
        document.querySelectorAll(".size-tab");

    const sizeCategories =
        document.querySelectorAll(".size-category");


    sizeTabs.forEach(function (tab) {

        tab.addEventListener("click", function () {

            const category =
                this.dataset.category;


            /* Remove active from tabs */

            sizeTabs.forEach(function (item) {

                item.classList.remove("active");

            });


            /* Activate clicked tab */

            this.classList.add("active");


            /* Hide all tables */

            sizeCategories.forEach(function (section) {

                section.style.display = "none";

            });


            /* Show selected table */

            const selected =
                document.getElementById(
                    "size-" + category
                );


            if (selected) {

                selected.style.display = "block";

            }

        });

    });


    /* ==========================================
       DEFAULT SIZE GUIDE
       SHOW MEN FIRST
    ========================================== */

    sizeCategories.forEach(function (section) {

        section.style.display = "none";

    });


    const defaultCategory =
        document.getElementById("size-men");


    if (defaultCategory) {

        defaultCategory.style.display = "block";

    }

});