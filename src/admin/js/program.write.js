$(document).ready(function () {
    // 왼쪽 nav 에서 선택이 안되어 있어서 강제로 active 상태 만들어줌.
    setActiveNavMenu('program.php');

    initImageForm();
    initTextForm();
});


function initTextForm() {
    const textFormOption = getSummernoteDefaultOption();

    textFormOption.placeholder = '프로그램 소개글을 입려해 주세요.';
    $('#program_introduction_textform').summernote(textFormOption);

    textFormOption.placeholder = '프로그램 스케쥴을 입려해 주세요.';
    $('#program_schedule_textform').summernote(textFormOption);

    textFormOption.placeholder = '프로그램 이벤트를 입려해 주세요.';
    $('#program_event_textform').summernote(textFormOption);
}

function initImageForm() {
    let image_option = getImageUploadDefaultOption();
    image_option.imagesInputName = 'program_thumbnail';
    image_option.label = '프로그램 썸네일을 업로드 해주세요.';

    $('#program_thumbnail').imageUploader(image_option);

    image_option.label = '프로그램 대표 이미지를 업로드 해주세요.',
    image_option.imagesInputName = 'program_image';
    $('#program_image').imageUploader(image_option);
}

function doInsert(event) {
    event.preventDefault();
    event.stopPropagation();

    if ($('#program_name').val() == '') {
        alert('프로그램명은 필수 입력사항 입니다.');
        $('#program_name').focus();
        return false;
    }

    let year = parseInt($('#program_year').val(), 10);
    if (year == '' || year == 0 || year < 1000) {
        alert('년도는 필수 입력사항 입니다.');
        $('#program_year').focus();
        return false;
    } 
    else if (year > 9999) {
        alert('년도는 최대 4자리 까지만 입력 가능합니다.');
        $('#program_year').focus();
        return false;
    }

    if ($('#program_date').val() == '') {
        alert('프로그램명 일자는 필수 입력사항 입니다.');
        $('#program_date').focus();
        return false;
    }

    if ($('#program_place').val() == '') {
        alert('프로그램명 장소는 필수 입력사항 입니다.');
        $('#program_place').focus();
        return false;
    }
    

    if ($('#program_thumbnail input[type="file"]').val() == '') {
        alert('썸네일은 필수로 등록되어야 합니다.');
        return false;
    }

    if ($('#program_image input[type="file"]').val() == '') {
        alert('대표 이미지는 필수로 등록되어야 합니다.');
        return false;
    }

    // if ($('#program_introduction_textform').summernote('isEmpty')) {
    //     alert('프로그램 소개글을 입력해주세요.');
    //     return false;
    // }
    $('#program_introduction').html($('#program_introduction_textform').summernote('code'));

    // if ($('#program_schedule_textform').summernote('isEmpty')) {
    //     alert('프로그램 스케쥴을 입력해주세요.');
    //     return false;
    // }
    $('#program_schedule').html($('#program_schedule_textform').summernote('code'));

    // if ($('#program_event_textform').summernote('isEmpty')) {
    //     alert('프로그램 이벤트를 입력해주세요.');
    //     return false;
    // }
    $('#program_event').html($('#program_event_textform').summernote('code'));

    $('#insertProgramForm').submit();
}
