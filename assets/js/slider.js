let slider = document.getElementById("productSlider");

let position = 0;

let cardWidth = 330;


function slideNext(){

    let maxScroll = slider.scrollWidth - slider.parentElement.offsetWidth;


    if(position < maxScroll){

        position += cardWidth;

        slider.style.transform = `translateX(-${position}px)`;

    }

}



function slidePrev(){


    if(position > 0){

        position -= cardWidth;

        slider.style.transform = `translateX(-${position}px)`;

    }

}