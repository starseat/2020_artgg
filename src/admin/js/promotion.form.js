$(document).ready(function () {
    setActiveNavMenu('promotion.php');
    initTextForm();

    const promotion_seq = getPromotionSeq();
    if(promotion_seq > 0) {
        getPromotionInfo(promotion_seq);
    }
});

function initTextForm() {
    let option = getSummernoteDefaultOption();
    option.placeholder = '홍보자료 내용을 입력해 주세요.';
    $('#promotion_contents').summernote(option);
}

function getPromotionSeq() {
    const seq = getParameter('seq');
    if (isEmpty(seq) || !isNumeric(seq)) {
        return 0;
    }

    return seq;
}

function getPromotionInfo(promotion_seq) {
     $.ajax({
        type: 'get',
        data: {seq: promotion_seq},
        url: './action/promotion_get.php',
        success: function (result) {
            //console.log('[getPromotionInfo] result:: ', result);
            const resultObj = JSON.parse(result);
            //console.log('[getPromotionInfo] resultObj:: ', resultObj);
            setPromotionInfo(resultObj.promotion_info);
        }, 
        error: function (xhr, status, error) {
            console.error('[getPromotionInfo] ajax error:: ', error);
        },
        
    });
}

function setPromotionInfo(promotionInfo) {
    $('#promotion_form_reset_btn').hide();
    $('#promotion_form_delete_btn').show();

    $('#promotion_date_box').show();
    $('#promotion_created_at').val(promotionInfo.created_at);
    $('#promotion_updated_at').val(promotionInfo.updated_at);

    $('#promotion_seq').val(promotionInfo.seq);
    $('#promotion_title').val(promotionInfo.title);
    $('#promotion_contents').summernote('code', promotionInfo.contents);
}

function doReset(event) {
    event.preventDefault();
    event.stopPropagation();

    $('#promotion_title').val('');
    $('#promotion_contents').summernote('reset');
}

function doSubmit(event) {
    event.preventDefault();
    event.stopPropagation();

    const promotion_seq = parseInt($('#promotion_seq').val(), 10);
    const promotion_title = $('#promotion_title').val();
    if (promotion_title == '') {
        alert('홍보자료 제목을 입력해주세요.');
        return false;
    }
    if ($('#promotion_contents').summernote('isEmpty')) {
        alert('홍보자료 내용을 입력해주세요.');
        return false;
    }
    const promotion_contents = $('#promotion_contents').summernote('code');
    
    $.ajax({
        type: 'post',
        url: './action/promotion_submit.php',
        data: { seq: promotion_seq, title: promotion_title, contents: promotion_contents },
        dataType: 'json',
        success: function (result) {
            console.log('[doSubmit] result:: ', result);
            alert(result.message);
            location.href = './promotion.php';
        }, 
        error: function (xhr, status, error) {
            console.error('[doSubmit] ajax error:: ', error);
        },
        
    });
}

function goPromotionList(event) {
    event.preventDefault();
    event.stopPropagation();

    location.href = './promotion.php';
}

function doDelete(event) {
    event.preventDefault();
    event.stopPropagation();

    const promotion_seq = parseInt($('#promotion_seq').val(), 10);
    if (promotion_seq == 0) {
        alert('잘못된 접근 입니다.');
        location.href = './promotion.php';
        return false;
    }

    if(confirm('홍보자료글을 정말로 삭제하시겠습니까?')) {
        $.ajax({
            type: 'post',
            url: './action/promotion_delete.php',
            data: { seq: promotion_seq },
            dataType: 'json',
            success: function (result) {
                console.log('[doDelete] result:: ', result);
                alert(result.message);
                location.href = './promotion.php';
            },
            error: function (xhr, status, error) {
                console.error('[doDelete] ajax error:: ', error);
            },

        });
    }    
}

