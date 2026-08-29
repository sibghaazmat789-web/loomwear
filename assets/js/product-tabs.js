/* =========================================================
   PRODUCT TABS
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    const tabButtons =
        document.querySelectorAll(".tab-btn");

    const tabContents =
        document.querySelectorAll(".tab-content");


    tabButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            const target =
                this.dataset.tab;


            tabButtons.forEach(function (btn) {

                btn.classList.remove("active");

            });


            tabContents.forEach(function (tab) {

                tab.classList.remove("active");

            });


            this.classList.add("active");


            const content =
                document.getElementById(target);


            if (content) {

                content.classList.add("active");

            }

        });

    });

});