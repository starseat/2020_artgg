/** 퍼블리셔용 **/

// lnb 메뉴
function artggLnb() {
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
        var items = $.find('#lnb > li.current > ul.artgg_snb')[i];
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
            snbHeight = $(this).children('.artgg_snb').outerHeight();
            $('.artgg_snb').css('height', snbHeight);
            snbBgHeight();
        }, function () {
            //아웃했음
            $('.slnb_link').parents('.slnb_inner').removeClass('menu_hover');
            snbBg.css('height', '');
            snbBg.removeClass('snb_current');
            $('.artgg_snb').css('height', '');
        }
    );
    /*
     1. li의 top값을 구한다.
     2. li의 top값이 0이 아닌놈은 display:none한다.

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
    */
}

// gnb 스크롤 Sticky
function gnbSticky(){
    $(window).scroll(function () {
        var scrollHeight = $(document).scrollTop();
        if (scrollHeight > 158) {
            $('.common_gnb_w').addClass('sticky');
        } else if (scrollHeight < 157) {
            $('.common_gnb_w').removeClass('sticky');
        }
    });
}

function mainvisualSlick(){
    $('.slick_slide_list').slick({
        dots: true,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear'
    });
}

function mobileGnb(){
    $('.btn_allmenu').click( function() {
        $('.artgg_lnb_w').addClass('gnb_open');
    } );
    $('.btn_allmenu_x').click( function() {
        $('.artgg_lnb_w').removeClass('gnb_open');
    } );
}
function mobilelnbOpen(){
    $('.slnb_link').click( function() {
        $('.slnb_link').parents('.slnb_inner').removeClass('menu_hover');
        $(this).parents('.slnb_inner').addClass('menu_hover');
    } );
}

function vodlistHeight(){
    var vodboxHeight = $('.mediaroom_vod_w').outerHeight();
    $('.module_media_list_w').css('height',vodboxHeight);

    if (document.body.clientWidth < 970) {
        $('.module_media_list_w').css('height','auto');
    }

}

function layerpopupBtn(){
    $('.btn_popup_close').click( function(){
        $('.layer_popup_w').css('display','none');
    });
}
