window.addEventListener("scroll", function () {

    const header = document.querySelector(".header");

    if(window.scrollY > 50){

        header.classList.add("sticky");

    }else{

        header.classList.remove("sticky");

    }

});

const topBtn = document.querySelector(".back-to-top");

window.addEventListener("scroll", ()=>{

    if(window.scrollY > 500){

        topBtn.classList.add("show");

    }else{

        topBtn.classList.remove("show");

    }

});

topBtn.addEventListener("click",()=>{

    window.scrollTo({

        top:0,

        behavior:"smooth"

    });

});

const newsletter = document.querySelector(".newsletter");

if(newsletter){

newsletter.addEventListener("submit",(e)=>{

const email = newsletter.querySelector("input").value.trim();

if(email===""){

e.preventDefault();

alert("Please enter your email.");

}

});

}

function formatPrice(price){

return new Intl.NumberFormat("en-PK").format(price);

}

function slideWomenNext(){

    const slider = document.getElementById("womenProductSlider");

    slider.scrollBy({
        left: 300,
        behavior: "smooth"
    });

}


function slideWomenPrev(){

    const slider = document.getElementById("womenProductSlider");

    slider.scrollBy({
        left: -300,
        behavior: "smooth"
    });

}

const schoolVideo = document.querySelector(".school-video");
const pauseButton = document.getElementById("schoolVideoPause");

if (schoolVideo && pauseButton) {

    pauseButton.addEventListener("click", function () {

        if (schoolVideo.paused) {

            schoolVideo.play();

            pauseButton.textContent = "❚❚";

        } else {

            schoolVideo.pause();

            pauseButton.textContent = "▶";

        }

    });

}

function slideGirlsNext() {

    const slider = document.getElementById("girlsProductSlider");

    slider.scrollBy({
        left: 300,
        behavior: "smooth"
    });

}


function slideGirlsPrev() {

    const slider = document.getElementById("girlsProductSlider");

    slider.scrollBy({
        left: -300,
        behavior: "smooth"
    });

}

function slideBoysNext() {

    const slider =
        document.getElementById("boysProductSlider");

    slider.scrollBy({

        left: 300,

        behavior: "smooth"

    });

}


function slideBoysPrev() {

    const slider =
        document.getElementById("boysProductSlider");

    slider.scrollBy({

        left: -300,

        behavior: "smooth"

    });

}

function slideBabyNext() {

    const slider =
        document.getElementById("babyProductSlider");

    slider.scrollBy({

        left: 300,

        behavior: "smooth"

    });

}


function slideBabyPrev() {

    const slider =
        document.getElementById("babyProductSlider");

    slider.scrollBy({

        left: -300,

        behavior: "smooth"

    });

}

function showPaymentDetails(method) {

    document.getElementById('cod-details').style.display = 'none';

    document.getElementById('jazzcash-details').style.display = 'none';

    document.getElementById('easypaisa-details').style.display = 'none';

    document.getElementById('bank-details').style.display = 'none';


    if (method === 'cod') {

        document.getElementById('cod-details').style.display = 'block';

    }

    else if (method === 'jazzcash') {

        document.getElementById('jazzcash-details').style.display = 'block';

    }

    else if (method === 'easypaisa') {

        document.getElementById('easypaisa-details').style.display = 'block';

    }

    else if (method === 'bank') {

        document.getElementById('bank-details').style.display = 'block';

    }

}