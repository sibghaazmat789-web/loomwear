/* =========================================================
   PRODUCT GALLERY
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    const mainImage =
        document.getElementById("mainImage");

    const thumbnails =
        document.querySelectorAll(".thumbnail-gallery .thumb");


    if (!mainImage || thumbnails.length === 0) {

        return;

    }


    /* =====================================================
       FIRST THUMBNAIL ACTIVE
    ===================================================== */

    thumbnails[0].classList.add("active");


    /* =====================================================
       THUMBNAIL CLICK
    ===================================================== */

    thumbnails.forEach(function (thumb) {

        thumb.addEventListener("click", function () {

            thumbnails.forEach(function (image) {

                image.classList.remove("active");

            });


            this.classList.add("active");


            mainImage.src =
                this.src;

        });

    });

});