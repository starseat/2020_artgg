$(document).ready(function () {
    initSwiper('youtube');
});

function initSwiper(mode) {
    const swiperOption = {
        centeredSlides: true,
        lazy: true,
        loop: true,
        // loopFillGroupWithBlank: true,
        // autoplay: {
        //     delay: 2500,
        //     disableOnInteraction: false,
        // },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    };

    var swiper = null;
    if(mode == 'youtube') {
        initSwiper_youtube();
        
        swiper = new Swiper('#business-artgg-image-swiper-container', swiperOption).on('slideChange', function () {
            var isVideo = swiper.slides[swiper.previousIndex].querySelector('.swiper-video-container');
            if (isVideo) {
                YT.get(isVideo.querySelector('iframe').id).stopVideo();
                //console.log(isVideo.querySelector('iframe').id);
            }
        });        
    }
    else {
         // Init Swiper
        swiper = new Swiper('#business-artgg-image-swiper-container', swiperOption);
    }
}

function initSwiper_youtube() {
    // This code loads the IFrame Player API code asynchronously.
    let tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    let firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var initPlayer = function (element) {
        var player = element.querySelector('.swiper-video-iframe');
        var button = element.querySelector('.swiper-video-play');
        var ytplayer = new YT.Player(player, {
            playerVars: {
                'autoplay': 0,
                'modestbranding': 1,
                'controls': 0,
                'rel': 0,
            },
            videoId: element.dataset.id
        });

        button.addEventListener('click', function () {
            //console.log(ytplayer);
            //console.log(ytplayer.getPlayerState());
            ytplayer.playVideo();
            switch (ytplayer.getPlayerState()) {
                case 1: { ytplayer.stopVideo(); } break;
                default: { ytplayer.playVideo(); } break;
            }
        });
    };

    // This function creates an <iframe> (and YouTube player)
    //    after the API code downloads.
    window.onYouTubePlayerAPIReady = function () {
        var container = document.querySelectorAll('.swiper-video-container');
        for (var i = 0; i < container.length; i++) {
            initPlayer(container[i])
        }
    };
}
