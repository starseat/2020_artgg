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
        ]
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
    $('#artist_thumbnail').imageUploader({
        imagesInputName: 'artist_thumbnail',
        label: '작가님의 대표 이미지(썸네일)를 업로드 해주세요.',
        extensions: ['.jpg', '.jpeg', '.png', '.gif'],
        mimes: ['image/jpeg', 'image/png', 'image/gif'],
        maxFiles: 1,
    });
    $('#artist_image').imageUploader({
        imagesInputName: 'artist_images',
        label: '작가님의 이미지를 업로드 해주세요. (최대 4개)',
        extensions: ['.jpg', '.jpeg', '.png', '.gif'],
        mimes: ['image/jpeg', 'image/png', 'image/gif'],
        maxFiles: 4,
    });
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
