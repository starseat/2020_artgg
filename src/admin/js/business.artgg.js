$(document).ready(function () {
    initTextForm();
    initSwiper('youtube');
    initImageForm();
});

function initTextForm() {
    let option = getSummernoteDefaultOption();
    option.placeholder = '아트경기의 소개글을 입력해 주세요.';
    $('#artgg_introduction_textform').summernote(option);
    $('#artgg_introduction_textform').summernote('code', $('#artgg_introduction').text());
}

function initSwiper(mode) {
    const swiperOption = {
        // spaceBetween: 30,
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

        // Enable debugger
        //debugger: true,
    };

    var swiper = null;
    if(mode == 'youtube') {
        initSwiper_youtube();
        
        swiper = new Swiper('.swiper-container', swiperOption).on('slideChange', function () {
            var isVideo = swiper.slides[swiper.previousIndex].querySelector('.swiper-video-container');
            if (isVideo) {
                YT.get(isVideo.querySelector('iframe').id).stopVideo();
                //console.log(isVideo.querySelector('iframe').id);
            }
        });        
    }
    else {
         // Init Swiper
        swiper = new Swiper('.swiper-container', swiperOption);
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

function initImageForm() {
    let image_option = getImageUploadDefaultOption();
    image_option.imagesInputName = 'artgg_images';
    image_option.label = '아트경기 이미지를 업로드 해주세요.';
    image_option.maxFiles = undefined;

    $('#artgg_images').imageUploader(image_option);
}

function showInsertImageModal() {
    $('#insertImageModal').modal('show');
}

function showInsertLinkModal() {
    $('#insertLinkModal').modal('show');
}

function showModifyContentsModal() {
    $('#modifyContentsModal').modal('show');
}

function doSubmit_insertTextForm(event) {
    event.preventDefault();
    event.stopPropagation();

    $('#artgg_introduction').html($('#artgg_introduction_textform').summernote('code'));
    $('#insert_type_introduction').val('text');
    $('#insertTextForm').submit();
}

function doSubmit_insertImageModalForm(event) {
    event.preventDefault();
    event.stopPropagation();

    $('#insert_type_image').val('image');
    $('#insertImageModalForm').submit();
}

function doSubmit_insertLinkModalForm(event) {
    event.preventDefault();
    event.stopPropagation();

    const artgg_link = $('#artgg_link').val();
    if( !(artgg_link.indexOf('https://youtu.be') >= 0 || artgg_link.indexOf('https://www.youtube.com') >= 0) ) {
        alert('Youtube 링크를 정확히 입력해 주세요.');
        return false;
    }
    const youtube_id = getYoutubeId(artgg_link);
    if (youtube_id == '') {
        alert('Youtube 의 동영상을 찾지 못했습니다.');
        return false;
    }

    $('#artgg_link_youtube_id').val(youtube_id);
    $('#insertLinkModalForm').submit();
}

function doSubmit_modifyContentsModalForm(event) {
    event.preventDefault();
    event.stopPropagation();

    const artgg_content_list = [];
    let $list = $('.artgg-contents-list');
    for(let i=0; i<$list.length; i++) {
        let $item = $($list[i]);

        artgg_content_list.push({
            seq: parseInt($item.find('.contents-seq').text(), 10), 
            sort: parseInt($item.find('.contents-sort').val(), 10),
        });
    }
    
    $.ajax({
        url: './action/business_artgg_modify_contents.php',
        type: 'post',
        dataType: 'json',
        data: { artgg_content_list: artgg_content_list },
        success: function (result) {
            console.log('[doSubmit_modifyContentsModalForm] ajax success result:: ', result);            
            alert(result.message);
            location.reload(true);
        }, 
        error: function (xhr, status, error) {
            console.error('[doSubmit_modifyContentsModalForm] ajax error:: ', error);
            alert('컨텐츠 정보 수정중 오류가 발생하였습니다.');
            location.reload(true);
        },
    });

}

function doDeleteContents(event, artgg_file_seq) {
    event.preventDefault();
    event.stopPropagation();

    if (confirm('해당 컨텐츠를 정말 삭제하시겠습니까?')) {
        $.ajax({
            url: './action/image_delete.php',
            type: 'post',
            dataType: 'json',
            data: { seq: artgg_file_seq },
            success: function (result) {
                console.log('[doDeleteContents] ajax success result:: ', result);
                alert('해당 컨텐츠가 삭제되었습니다.');
                location.reload(true);
            }, 
            error: function (xhr, status, error) {
                console.error('[doDeleteContents] ajax error:: ', error);
            },
        });
    }
}
