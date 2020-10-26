$(document).ready(function () {
    setActiveNavMenu('press_release.php');
    initTextForm();
    
    const press_release_seq = getPressReleaseSeq();
    if(press_release_seq > 0) {
        getPressReleaseInfo(press_release_seq);
    }
});

function initTextForm() {
    let option = getSummernoteDefaultOption();
    option.placeholder = '보도자료 내용을 입력해 주세요.';
    option.toolbar.push(['insert', ['link', 'picture', 'video']]);
    $('#press_release_contents').summernote(option);
}

function getPressReleaseSeq() {
    const seq = getParameter('seq');
    if (isEmpty(seq) || !isNumeric(seq)) {
        return 0;
    }

    return seq;
}

function getPressReleaseInfo(press_release_seq) {
     $.ajax({
        type: 'get',
        data: {seq: press_release_seq},
        url: './action/press_release_get.php',
        success: function (result) {
            //console.log('[getPressReleaseInfo] result:: ', result);
            const resultObj = JSON.parse(result);
            //console.log('[getPressReleaseInfo] resultObj:: ', resultObj);
            setPressReleaseInfo(resultObj.press_release_info);
        }, 
        error: function (xhr, status, error) {
            console.error('[getPressReleaseInfo] ajax error:: ', error);
        },
        
    });
}

function setPressReleaseInfo(pressReleaseInfo) {
    $('#press_release_form_reset_btn').hide();
    $('#press_release_form_delete_btn').show();

    $('#press_release_date_box').show();
    $('#press_release_created_at').val(pressReleaseInfo.created_at);
    $('#press_release_updated_at').val(pressReleaseInfo.updated_at);

    $('#press_release_seq').val(pressReleaseInfo.seq);

    $('#press_release_title').val(pressReleaseInfo.title);
    $('#press_release_link').val(pressReleaseInfo.link);

    $('#press_release_news_date').val(pressReleaseInfo.news_date);
    $('#press_release_news_media').val(pressReleaseInfo.news_media);
    $('#press_release_news_author').val(pressReleaseInfo.news_author);

    $('#press_release_contents').summernote('code', pressReleaseInfo.contents);
}

function doReset(event) {
    event.preventDefault();
    event.stopPropagation();

    $('#press_release_title').val('');
    $('#press_release_link').val('');

    $('#press_release_news_date').val('');
    $('#press_release_news_media').val('');
    $('#press_release_news_author').val('');

    $('#press_release_contents').summernote('reset');
}

function doSubmit(event) {
    event.preventDefault();
    event.stopPropagation();
    
    const press_release_title = $('#press_release_title').val();
    if (press_release_title == '') {
        alert('보도자료 제목을 입력해주세요.');
        return false;
    }
    if ($('#press_release_contents').summernote('isEmpty')) {
        alert('보도자료 내용을 입력해주세요.');
        return false;
    }
    
    const param = {
        seq: parseInt($('#press_release_seq').val(), 10), 
        title: press_release_title, 
        link: $('#press_release_link').val(), 
        news_date: $('#press_release_news_date').val(), 
        news_media: $('#press_release_news_media').val(), 
        news_author: $('#press_release_news_author').val(), 
        contents: $('#press_release_contents').summernote('code')
    };

    $.ajax({
        type: 'post',
        url: './action/press_release_submit.php',
        data: param,
        dataType: 'json',
        success: function (result) {
            console.log('[doSubmit] result:: ', result);
            alert(result.message);
            location.href = './press_release.php';
        }, 
        error: function (xhr, status, error) {
            console.error('[doSubmit] ajax error:: ', error);
        },
        
    });
}

function goPressReleaseList(event) {
    event.preventDefault();
    event.stopPropagation();

    location.href = './press_release.php';
}

function doDelete(event) {
    event.preventDefault();
    event.stopPropagation();

    const press_release_seq = parseInt($('#press_release_seq').val(), 10);
    if (press_release_seq == 0) {
        alert('잘못된 접근 입니다.');
        location.href = './press_release.php';
        return false;
    }

    if(confirm('보도자료글을 정말로 삭제하시겠습니까?')) {
        $.ajax({
            type: 'post',
            url: './action/press_release_delete.php',
            data: { seq: press_release_seq },
            dataType: 'json',
            success: function (result) {
                console.log('[doDelete] result:: ', result);
                alert(result.message);
                location.href = './press_release.php';
            },
            error: function (xhr, status, error) {
                console.error('[doDelete] ajax error:: ', error);
            },

        });
    }    
}

