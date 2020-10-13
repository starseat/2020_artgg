$(document).ready(function () {
    initSwiper();
});

function initSwiper() {
    console.log('123');
    const artist_images = new Swiper('#artist_slide_swiper_container', {
        // effect: 'fade',
        loop: true, 
        spaceBetween: 30,
        centeredSlides: true,
        autoHeight: true, //enable auto height
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        // slidesPerView: 'auto',
        // effect: 'coverflow',
        // coverflowEffect: {
        //     rotate: 50,
        //     stretch: 0,
        //     depth: 100,
        //     modifier: 1,
        //     slideShadows: true,
        // },
        // grabCursor: true,
        
        
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
    
}