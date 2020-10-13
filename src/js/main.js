$(document).ready(function () {
    initSwiper('youtube');
});

// $(window).resize(function () {});

function initSwiper(mode) {
    const swiperOption = {
        // spaceBetween: 30,
        // centeredSlides: true,
        lazy: true,
        loop: true,
        // watchSlidesVisibility: true,
        // watchSlidesProgress: true,
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

        // Enable debugger
        //debugger: true,
    };

    let mainSwiper = null;
    if (mode == 'youtube') {
        initSwiper_youtube();

        mainSwiper = new Swiper('#main-swiper-container', swiperOption).on('slideChange', function () {
            const isVideo = swiper.slides[swiper.previousIndex].querySelector('.swiper-video-container');
            if (isVideo) {
                YT.get(isVideo.querySelector('iframe').id).stopVideo();
                //console.log(isVideo.querySelector('iframe').id);
            }
        });
    } else {
        // Init Swiper
        mainSwiper = new Swiper('#main-swiper-container', swiperOption);
    }

    // artist swiper
    let artistSwiper = new Swiper('#artist-thumb-swiper-container', {
        effect: 'cube',         
        cubeEffect: {
            shadow: true,
            slideShadows: true,
            shadowOffset: 20,
            shadowScale: 0.94,
        },

        // effect: 'flip',

        loop: true,
        grabCursor: true,
        pagination: {
            el: '#artist-thumb-swiper-pagination',
            type: 'fraction',
        },
        navigation: {
            nextEl: '#artist-thumb-swiper-button-next',
            prevEl: '#artist-thumb-swiper-button-prev',
        },
    });
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
                'autoplay': 0, // 자동재생 off
                'modestbranding': 1, 
                'controls': 0, // 동영상 플레이어 컨트롤 표기
                'rel': 0,
                // 'cc_load_policy' : 0,  // 자막 0 : on, 1 : off
                // 'disablekb' : 0  // 키보드 컨트롤 사용 off
            },
            videoId: element.dataset.id
        });

        button.addEventListener('click', function () {
            //console.log(ytplayer);
            //console.log(ytplayer.getPlayerState());
            ytplayer.playVideo();
            switch (ytplayer.getPlayerState()) {
                case 1: {
                    ytplayer.stopVideo();
                }
                break;
            default: {
                ytplayer.playVideo();
            }
            break;
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

function goArtistDetail(artist_seq) {
    location.href = './artist_detail.php?seq=' + artist_seq;
}
