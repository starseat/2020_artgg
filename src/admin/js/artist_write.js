$(document).ready(function () {
    initImageForm();
    initTextForm();
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

function initImageForm() {
    let artist_image_option = {
        imagesInputName: 'artist_thumbnail',
        label: '작가님의 대표 이미지(썸네일)를 업로드 해주세요.',
        extensions: [
            '.jpg', '.jpeg', '.png', '.gif', 
            '.JPG', '.JPEG', '.PNG', '.GIF'
        ],
        mimes: ['image/jpeg', 'image/png', 'image/gif'],
        maxFiles: 1,
    };
    $('#artist_thumbnail').imageUploader(artist_image_option);

    artist_image_option.label = '작가님의 이미지를 업로드 해주세요.',
    artist_image_option.imagesInputName = 'artist_image1';
    $('#artist_image1').imageUploader(artist_image_option);

    artist_image_option.imagesInputName = 'artist_image2';
    $('#artist_image2').imageUploader(artist_image_option);

    artist_image_option.imagesInputName = 'artist_image3';
    $('#artist_image3').imageUploader(artist_image_option);

    artist_image_option.imagesInputName = 'artist_image4';
    $('#artist_image4').imageUploader(artist_image_option);
}

function readURL(input, previewElId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#' + previewElId).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

function doInsert(event) {
    event.preventDefault();
    event.stopPropagation();

    if ($('#artist_name').val() == '') {
        alert('작가명은 필수 입력사항 입니다.');
        $('#artist_name').focus();
        return false;
    }

    if ($('#artist_name_en').val() == '') {
        alert('작가명 (영문) 은 필수 입력사항 입니다.');
        $('#artist_name_en').focus();
        return false;
    }

    let year = $('#artist_year').val();
    if (year == '' || year == 0 || year < 1000) {
        alert('년도는 필수 입력사항 입니다.');
        $('#artist_year').focus();
        return false;
    }

    if ($('#artist_thumbnail input[type="file"]').val() == '') {
        alert('썸네일은 필수로 등록되어야 합니다.');
        return false;
    }

    if ($('#artist_image1 input[type="file"]').val() == '') {
        alert('대표 이미지 1 은 필수로 등록되어야 합니다.');
        return false;
    }

    $('#artist_introduction_temp').html($('#artist_introduction').summernote('code'));
    $('#artist_academic_temp').html($('#artist_academic').summernote('code'));
    $('#artist_individual_exhibition_temp').html($('#artist_individual_exhibition').summernote('code'));
    $('#artist_team_competition_temp').html($('#artist_team_competition').summernote('code'));
    $('#artist_interview_temp').html($('#artist_interview').summernote('code'));

    $('#insertArtistForm').submit();
}
