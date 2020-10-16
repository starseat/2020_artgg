$(document).ready(function () {
    initSwiper();
});

function initSwiper(mode) {
    const swiperOption = {
        centeredSlides: true,
        lazy: true,
        loop: true,
        // loopFillGroupWithBlank: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    };

    var swiper = new Swiper('#business-artgg-image-swiper-container', swiperOption);

    $('.swiper-move-button').on('click', function () {
        const $swiper_youtube_list = $('.swiper-youtube-view');
        for (let i = 0; i < $swiper_youtube_list.length; i++) {
            $($swiper_youtube_list[i])[0].contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
        }
    })
}
