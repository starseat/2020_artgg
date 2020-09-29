$(document).ready(function () {
    initTextForm();

    const notice_seq = getNoticeSeq();
    if(notice_seq > 0) {
        getNoticeInfo(notice_seq);
    }
});

function initTextForm() {
    let option = getSummernoteDefaultOption();
    option.placeholder = '공지사항 내용을 입력해 주세요.';
    $('#notice_contents').summernote(option);
}

function getNoticeSeq() {
    const seq = getParameter('seq');
    if (isEmpty(seq) || !isNumeric(seq)) {
        return 0;
    }

    return seq;
}

function getNoticeInfo(notice_seq) {
     $.ajax({
        type: 'get',
        data: {seq: notice_seq},
        url: './action/notice_get.php',
        success: function (result) {
            //console.log('[getNoticeInfo] result:: ', result);
            const resultObj = JSON.parse(result);
            //console.log('[getNoticeInfo] resultObj:: ', resultObj);
            setNoticeInfo(resultObj.notice_info);
        }, 
        error: function (xhr, status, error) {
            console.error('[getNoticeInfo] ajax error:: ', error);
        },
        
    });
}

function setNoticeInfo(noticeInfo) {
    $('#notice_form_reset_btn').hide();

    $('#notice_date_box').show();
    $('#notice_created_at').val(noticeInfo.created_at);
    $('#notice_updated_at').val(noticeInfo.updated_at);

    $('#notice_seq').val(noticeInfo.seq);
    $('#notice_title').val(noticeInfo.title);
    $('#notice_level').val(noticeInfo.level);
    $('#notice_contents').summernote('code', noticeInfo.contents);
}

function doReset(event) {
    event.preventDefault();
    event.stopPropagation();

    $('#notice_title').val('');
    $('#notice_level').val('1');
    $('#notice_contents').summernote('reset');
}

function doSubmit(event) {
    event.preventDefault();
    event.stopPropagation();

    const notice_seq = parseInt($('#notice_seq').val(), 10);
    const notice_level = parseInt($('#notice_level').val(), 10);
    const notice_title = $('#notice_title').val();
    if (notice_title == '') {
        alert('공자사항 제목을 입력해주세요.');
        return false;
    }
    if ($('#notice_contents').summernote('isEmpty')) {
        alert('공지사항 내용을 입력해주세요.');
        return false;
    }
    const notice_contents = $('#notice_contents').summernote('code');
    
    $.ajax({
        type: 'post',
        url: './action/notice_submit.php',
        data: { seq: notice_seq, level: notice_level, title: notice_title, contents: notice_contents },
        dataType: 'json',
        success: function (result) {
            console.log('[doSubmit] result:: ', result);
            alert(result.message);
            location.href = './notice.php';
        }, 
        error: function (xhr, status, error) {
            console.error('[doSubmit] ajax error:: ', error);
        },
        
    });
}

function goNoticeList(event) {
    event.preventDefault();
    event.stopPropagation();

    location.href = './notice.php';
}