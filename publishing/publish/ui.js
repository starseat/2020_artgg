/** 퍼블리셔용 **/
// 스크롤시 이벤트 클래스 추가
var scrollobj=".titleline_cont, .history_box";
var active_once=true;

// 메인 타이틀텍스트 스크롤 효과
function scrollContainer() {
    var scrollPos = $(document).scrollTop();
    var activePoint = parseInt($(window).height()-$(window).height()/6);
    var removePoint = parseInt(0);
    $(scrollobj).each(function(e){
        var currLink = $(this)
        if (currLink.offset().top - activePoint <= scrollPos && currLink.offset().top + currLink.height()  > scrollPos + removePoint) {
            currLink.addClass("hover_event");
        } else {
            if(active_once==false){
                currLink.removeClass("hover_event");
            }
        }
    });
    
}

function portfoliowriter() {
    $(window).load(function(){
        $('.writer_list_w').imagesLoaded(function() {
            $('.porfolio_post_w').masonry({
                itemSelector: '.post_img',
                columnWidth: 148,
                gutter: 18
            });
            $(".writer_list_w").masonry({
                itemSelector: '.writer_cont',
                columnWidth: 378,
                gutter: 18
            });
        });
    });
}

// 포토갤러리 롤링 배너
function photogallerybanner() {
    $('.end_photogallery_w').slick({
        infinite: false,
        speed: 300,
        slidesToShow: 1,
        adaptiveHeight: true,
        prevArrow:$('.slide_list_button').find('.sl_btn_prev'),
        nextArrow:$('.slide_list_button').find('.sl_btn_next')
    });

}// 포토갤러리 레이어팝업 롤링
function photolayerbanner() {
    $('.layer_img_box').slick({
        infinite: false,
        speed: 300,
        slidesToShow: 1,
        adaptiveHeight: true,
        prevArrow:$('.layerbtn_prev'),
        nextArrow:$('.layerbtn_next')
    });
}

function layerpopup() {

    photolayerbanner();
    // $('.photogallery_layer_w').show();
    // var windowW = $( window ).width();
    // var windowH = $( window ).height();
    var popupW =$('.layer_gallery_cont').width();
    var popupH =$('.layer_gallery_cont').height();
    var windowH = $(window).height();
    // $('.sub_content_w').css('width',windowW);
    // $('.sub_content_w').css('height',windowH);
    // $('.layer_gallery_cont').css('height',popupH);
    $('.layer_gallery_cont').css('margin-left',-popupW/2);
    $('.layer_gallery_cont').css('margin-top',-popupH/2);


    $('.layer_close_btn').click(function () {
        $('.photogallery_layer_w').hide();
    });

    // 비디오팝업 디바이스높이
    $('.videogallery_layer_w').css('height',windowH);
}

// 오픈 안내페이지 중앙 정렬
function homeinfoCenter() {
    var windowW = $( window ).width();
    var windowH = $( window ).height();
    $('.home_info_w').css('width',windowW);
    $('.home_info_w').css('height',windowH);
}

// lnb 메뉴
function studioLnb() {
    var snbBg = $('.snb_bg');
    var snbHeight = null;
    var lnbMenu = $('.slnb_inner');
    // 선택 메뉴 이벤트
    function snbBgHeight() {
        snbBg.css('height', snbHeight);
        snbBg.addClass('snb_current');
    }

    // 선택된 메뉴가 있는 지 검색
    for (var i = 0; i < lnbMenu.length; ++i) {
        var items = $.find('#lnb > li.current > ul.studio_snb')[i];
        /*if (items != undefined){
         snbHeight = items.offsetHeight;
         snbBgHeight ();
         }*/
    }
    //호버했을때 이벤트
    $('.slnb_inner').hover(
        function () {
            //호버했음
            //1.클릭한 놈 lnb에 활성화
            // $('.slnb_inner').removeClass('menu_hover');
            $('.slnb_inner').addClass('menu_hover');
            //2.클릭한 놈lnb의 자식 snb찾기
            snbHeight = $(this).children('.studio_snb').outerHeight();
            $('.studio_snb').css('height', snbHeight);
            snbBgHeight();
        }, function () {
            //아웃했음
            $('.slnb_link').parents('.slnb_inner').removeClass('menu_hover');
            snbBg.css('height', '');
            snbBg.removeClass('snb_current');
            $('.studio_snb').css('height', '');
        }
    );
    /*
     1. li의 top값을 구한다.
     2. li의 top값이 0이 아닌놈은 display:none한다.
     */
    var lastNode = null;
    var toMuchMenu = false;
    $.each(lnbMenu, function () {
        var lnbMenuPostionTop = $(this).position().top;
        if (lnbMenuPostionTop != 0) {
            $(this).css('display', 'none');
            toMuchMenu = true;
        } else {
            lastNode = $(this);
        }
    });
    if (toMuchMenu == true) {
        lastNode.addClass('last');
    } else if ($('.slnb_inner:last-child').position().left > 1000) {
        lastNode.addClass('last');
    }
}
// gnb 스크롤 Sticky
function gnbSticky(){
    var scrollHeight = $(document).scrollTop();
    if(scrollHeight > 1125){
        $('.common_gnb_w').addClass('sticky');
        $('.common_gnb_w').removeClass('lnbtype_main');
    }else if(scrollHeight < 1125){
        $('.common_gnb_w').removeClass('sticky');
    }
}


// 연혁 스크롤 효과
function scrollhistory() {
    var scrollPos = $(document).scrollTop();
    var activePoint = parseInt($(window).height()-$(window).height()/4);
    var removePoint = parseInt(0);
    $(scrollobj).each(function(e){
        var currLink = $(this)
        if (currLink.offset().top - activePoint <= scrollPos && currLink.offset().top + currLink.height()  > scrollPos + removePoint) {
            currLink.addClass("current");
        } else {
            if(active_once==false){
                currLink.removeClass("current");
            }
        }
    });
}

function historyCurrent() {
    $('.history_list_inner li:nth-child(1)').addClass('current');
    $('.history_list_inner li:nth-child(2)').addClass('current');
}
