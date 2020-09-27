$(document).ready(function () {
    initTextForm();
    getArtistGreeting('0', initPage);
    
    $('#artist_select_year').on('change', function() {
        getArtistGreeting($(this).val(), setGreetingInfo);
    });
});

function initTextForm() {
    $('#artist_greeting').summernote({
        placeholder: '작가페이지의 소개글을 입력해 주세요.',
        tabsize: 2,
        height: 200,
        toolbar: [
            ['style', ['style']],
            ['insert', ['link', 'table', 'hr']],
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ], 
        lang: 'ko-KR'
    });
}

function getArtistGreeting(req_year, callback) {
    $.ajax({
        type: 'get',
        data: {year: req_year},
        url: './action/artist_gretting_get.php',
        success: function (result) {
            console.log('[getArtistGreeting] result:: ', result);
            let resultObj = JSON.parse(result);
            console.log('[getArtistGreeting] resultObj:: ', resultObj);
            callback(resultObj);
        }, 
        error: function (xhr, status, error) {
            console.error('[getArtistGreeting] ajax error:: ', error);
        },
        
    });
}

function initPage(data) {
    console.log('[initPage] data:: ', data);
    if (data.year_list.length == 0) {
        doNewWrite();
        return;
    }

    let $select_year = $('#artist_select_year');
    $select_year.empty();
    for(let i=0; i<data.year_list.length; i++) {
        let $option = '<option value="' + data.year_list[i].year + '">' + data.year_list[i].year + '</option>';
        $select_year.append($option);
    }

    setGreetingInfo(data);
}

function setGreetingInfo(data) {
    $('#artist_seq').val(data.artist_greeting.seq);
    $('#artist_year').val(data.artist_greeting.year);
    $('#artist_greeting').summernote('code', data.artist_greeting.introduction);
}

function doNewWrite(event) {
    if(typeof event != 'undefined') {
        event.preventDefault();
        event.stopPropagation();
    }

    $('#artist_seq').val(0);
    $('#artist_year').val(0);
    $('#artist_greeting').summernote('reset');
}

function doSubmit(event) {
    event.preventDefault();
    event.stopPropagation();

    const artist_seq = $('#artist_seq').val();
    const artist_year = $('#artist_year').val();
    if (artist_year == null || artist_year == '') {
        alert('년도를 입력해 주세요.');
        return false;
    }
    if(artist_year.length != 4) {
        alert('년도를 정확하게 입력해 주세요. (4자리)');
        return false;
    }

    const artist_greeting = $('#artist_greeting').summernote('code');
    if (artist_greeting == '') {
        alert('소개글을 입력해 주세요.');
        return false;
    }

    $.ajax({
        type: 'post',
        url: './action/artist_gretting_submit.php',
        data: { seq: artist_seq, year: artist_year, greeting: artist_greeting },
        dataType: 'json',
        success: function (result) {
            console.log('[doSubmit] result:: ', result);

            alert(result.message);
            $('#artist_select_year option[value="0"]').remove();
            $('#artist_select_year').append('<option value="' + artist_year + '">' + artist_year + '</option>');
            $('#artist_select_year').val(artist_year).prop('selected', true);
            $('#artist_seq').val(result.seq);
        }, 
        error: function (xhr, status, error) {
            console.error('[doSubmit] ajax error:: ', error);
        },
        
    });
}

function doDelete(event) {
    event.preventDefault();
    event.stopPropagation();

    const artist_seq = parseInt($('#artist_seq').val(), 10);
    if(artist_seq == 0) {
        alert('등록된 글만 삭제할 수 있습니다.');
        return false;
    }

    $.ajax({
        type: 'post',
        url: './action/artist_gretting_delete.php',
        data: { seq: artist_seq },
        dataType: 'json',
        success: function (result) {
            console.log('[doDelete] result:: ', result);
            alert(result.message);
            if (result.result > 0) {
                location.reload();
            }            
        }, 
        error: function (xhr, status, error) {
            console.error('[doDelete] ajax error:: ', error);
        },
        
    });
}
