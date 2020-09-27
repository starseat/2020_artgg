$(document).ready(function () {
    initTextForm();

    const seq = getParameter('seq');
    if( isEmpty(seq) || !isNumeric(seq) ) {        
        alert('잘못된 접근입니다.');
        history.back();
    }

    getArtistInfo(seq, function(artist_info) {
        initArtistInfo(artist_info)
    });
});

function initTextForm() {
    const textFormOption = {
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
    };

    textFormOption.placeholder = '작가님의 소개글을 입려해 주세요.';
    $('#artist_introduction').summernote(textFormOption);

    textFormOption.placeholder = '작가님의 학력을 입려해 주세요.';
    $('#artist_academic').summernote(textFormOption);

    textFormOption.placeholder = '작가님의 주요 개인전 이력을 입려해 주세요.';
    $('#artist_individual_exhibition').summernote(textFormOption);

    textFormOption.placeholder = '작가님의 주요 단체전 이력을 입려해 주세요.';
    $('#artist_team_competition').summernote(textFormOption);

    textFormOption.placeholder = '작가님의 인터뷰 내용을 입려해 주세요.';
    $('#artist_interview').summernote(textFormOption);
}


function getArtistInfo(artist_seq, callback) {
    $.ajax({
        type: 'get',
        data: {seq: artist_seq},
        url: './action/artist_get.php',
        success: function (result) {
            //console.log('[getArtistInfo] result:: ', result);
            let resultObj = JSON.parse(result);
            console.log('[getArtistInfo] resultObj:: ', resultObj);
            callback(resultObj);
        }, 
        error: function (xhr, status, error) {
            console.error('[getArtistInfo] ajax error:: ', error);
        },        
    });

}

function initArtistInfo(artistInfo) {
    //console.log('[initArtistInfo] artistInfo:: ', artistInfo );
    $('#artist_name').val(artistInfo.artist_info.name);
    $('#artist_name_en').val(artistInfo.artist_info.en_name);
    $('#artist_year').val(artistInfo.artist_info.year);

    $('#artist_introduction').summernote('code', artistInfo.artist_info.introduction);
    $('#artist_academic').summernote('code', artistInfo.artist_info.academic);
    $('#artist_individual_exhibition').summernote('code', artistInfo.artist_info.individual_exhibition);
    $('#artist_team_competition').summernote('code', artistInfo.artist_info.team_competition);
    $('#artist_interview').summernote('code', artistInfo.artist_info.interview); 

    $('#artist_thumbnail').hide();
    $('#artist_thumbnail_saved').attr('src', artistInfo.artist_info.thumbnail);

    const image_list = artistInfo.image_list;
    const image_is_show_list = [false, false, false, false];
    const imageElId = '#artist_image';
    for(let i=0; i<image_list.length; i++) {
        let targetElId = imageElId + (i + 1);
        $(targetElId).hide();
        $(targetElId + '_saved').attr('src', image_list[i].upload_path).show();
        $(targetElId + '_caption').val(image_list[i].caption);
        image_is_show_list[i] = true;
    }

    let artist_image_option = {
        label: '작가님의 이미지를 업로드 해주세요.',
        extensions: [
            '.jpg', '.jpeg', '.png', '.gif',
            '.JPG', '.JPEG', '.PNG', '.GIF'
        ],
        mimes: ['image/jpeg', 'image/png', 'image/gif'],
        maxFiles: 1,
    };

    for(let i=0; i<image_is_show_list.length; i++) {
        let targetElId = imageElId + (i + 1);
        if (image_is_show_list[i]) {
            continue;
        }

        $(targetElId + '_saved').hide();
        $(targetElId + '_delete_btn').hide();
        artist_image_option.imagesInputName = 'artist_image' + (i + 1);
        $(targetElId).imageUploader(artist_image_option);
    }
}

function doDeleteImage(event, sort) {
    if (typeof event != 'undefined') {
        event.preventDefault();
        event.stopPropagation();
    }

    if(confirm(sort + ' 번째 이미지를 정말로 삭제하시겠습니까?')) {
        alert('[doDeleteImage] ' + sort + '번 이미지 삭제');
    }
}

