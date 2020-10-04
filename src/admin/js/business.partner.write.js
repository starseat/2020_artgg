$(document).ready(function () {
    // 왼쪽 nav 에서 선택이 안되어 있어서 강제로 active 상태 만들어줌.
    setActiveNavMenu('business.partner.php');

    initImageForm();
    initTextForm();
});

function initImageForm() {
    let image_option = getImageUploadDefaultOption();

    image_option.imagesInputName = 'partner_thumbnail';
    image_option.label = '썸네일을 업로드 해주세요. (220x220)';
    $('#partner_thumbnail').imageUploader(image_option);

    image_option.imagesInputName = 'partner_image';
    image_option.label = '대표 이미지를 업로드 해주세요.';
    $('#partner_image').imageUploader(image_option);    
}

function initTextForm() {
    const textFormOption = getSummernoteDefaultOption();

    textFormOption.placeholder = '협력사업자의 소개글을 입려해 주세요.';
    $('#partner_introduction_textform').summernote(textFormOption);
}

function doInsert(event) {
    event.preventDefault();
    event.stopPropagation();

    const partner_name = $('#partner_name').val();
    if (partner_name == '') {
        alert('협력사업자명은 필수로 입력되어야 합니다.');
        return false;
    }

    if ($('#partner_thumbnail input[type="file"]').val() == '') {
        alert('썸네일은 필수로 등록되어야 합니다.');
        return false;
    }

    if ($('#partner_image input[type="file"]').val() == '') {
        alert('대표 이미지는 필수로 등록되어야 합니다.');
        return false;
    }

    if ($('#partner_introduction_textform').summernote('isEmpty')) {
        alert('협력사업자 소개글을 입력해주세요.');
        return false;
    }
    $('#partner_introduction').html($('#partner_introduction_textform').summernote('code'));

    $('#insertPartnerForm').submit();
}
