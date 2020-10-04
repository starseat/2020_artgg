$(document).ready(function () {
    setActiveNavMenu('business.partner.php');
    initTextForm();

    const seq = getPartnerSeq();
    console.log('[load] seq:: ', seq);
    if (seq == 0) {
        history.back();
    }
    else if (seq > 0) {
        getPartnerInfo(seq, function (partner_info) {
            initPartnerInfo(partner_info)
        });
    }
});

function getPartnerSeq() {
    const seq = getParameter('seq');
    if (isEmpty(seq) || !isNumeric(seq)) {
        alert('잘못된 접근입니다.');
        history.back();
        return 0;
    }

    return seq;
}

function initTextForm() {
    const textFormOption = getSummernoteDefaultOption();

    textFormOption.placeholder = '협력사업자의 소개글을 입려해 주세요.';
    $('#partner_introduction_textform').summernote(textFormOption);
}

function initImageForm() {
    let image_option = getImageUploadDefaultOption();

    image_option.imagesInputName = 'partner_thumbnail';
    image_option.label = '썸네일을 업로드 해주세요. (220x220)';
    $('#partner_thumbnail').imageUploader(image_option);

    image_option.imagesInputName = 'partner_image';
    image_option.label = '대표 이미지를 업로드 해주세요.';
    $('#partner_image').imageUploader(image_option);
}

function getPartnerInfo(partner_seq, callback) {
    $.ajax({
        type: 'get',
        data: { seq: partner_seq },
        url: './action/business_partner_get.php',
        success: function (result) {
            //console.log('[getPartnerInfo] result:: ', result);
            let resultObj = JSON.parse(result);
            console.log('[getPartnerInfo] resultObj:: ', resultObj);
            callback(resultObj);
        },
        error: function (xhr, status, error) {
            console.error('[getPartnerInfo] ajax error:: ', error);
        },
    });

}

function initPartnerInfo(partnerInfo) {
    console.log('[initPartnerInfo] partnerInfo:: ', partnerInfo );
    $('#partner_name').val(partnerInfo.partner_info.name);

    $('#partner_introduction_textform').summernote('code', partnerInfo.partner_info.introduction);

    let thumbnail_path = partnerInfo.partner_info.thumbnail;
    if (isEmpty(thumbnail_path)) {
        setNotExistThumbnailInfo();
    } else {
        $('#partner_thumbnail').hide();
        $('#partner_thumbnail_saved').attr('src', partnerInfo.partner_info.thumbnail);
    }

    const image_info = partnerInfo.image_list[0];
    $('#partner_image').hide();
    $('#partner_image_saved').attr('src', image_info.upload_path).show();
    $('#partner_image_saved_seq').val(image_info.seq);

    // 세팅 끝나고 alert 띄우기 위해서 아래로 배치함.
    if (isEmpty(thumbnail_path)) {
        alert('썸네일 정보가 존재하지 않습니다. 다시 등록해주세요.');
    }

    if (isEmpty(image_info) || isEmpty(image_info.upload_path)) {
        alert('대표 이미지 정보가 존재하지 않습니다. 다시 등록해주세요.');
    }
}

function doDeleteImage(event, sort) {
    // sort => 0: thumbnail, 1~4
    if (typeof event != 'undefined') {
        event.preventDefault();
        event.stopPropagation();
    }

    let confirm_message = '';
    if (sort > 0) {
        confirm_message = '대표 이미지를 정말로 삭제하시겠습니까?';
    } else {
        confirm_message = '썸네일 이미지를 정말로 삭제하시겠습니까?';
    }
    confirm_message += '\n삭제 후 이미지는 복구할 수 없습니다.'

    if (confirm(confirm_message)) {
        if (sort > 0) {
            doDeleteImage_partner(sort);
        } else {
            doDeleteImage_thumbnail();
        }

    } // end of if (confirm(confirm_message))
}

function doDeleteImage_partner(sort) {
    const targetElId = '#partner_image';
    let img_seq = $(targetElId + '_saved_seq').val();

    $.ajax({
        type: 'post',
        url: './action/image_delete.php',
        data: {
            seq: img_seq
        },
        dataType: 'json',
        success: function (result) {
            console.log('[doDeleteImage_partner] ajax result:: ', result);
            if (result.result == 1) {
                $(targetElId + '_delete_btn').hide();
                $(targetElId + '_saved').attr('src', '#').hide();
                $(targetElId + '_saved_seq').val(0);

                let image_option = getImageUploadDefaultOption();
                image_option.label = '대표 이미지를 업로드 해주세요.';
                image_option.imagesInputName = 'partner_image';
                $(targetElId).show().imageUploader(image_option);

                $('#partner_image_new').val(1);
            }
        },
        error: function (xhr, status, error) {
            console.error('[doDeleteImage_artist] ajax error:: ', error);
        },
    });
}

function doDeleteImage_thumbnail() {
    const partner_seq = getPartnerSeq();
    if (partner_seq == 0) {
        return false;
    }

    $.ajax({
        type: 'post',
        url: './action/business_partner_delete_thumbnail.php',
        data: { seq: partner_seq },
        dataType: 'json',
        success: function (result) {
            console.log('[doDeleteImage_thumbnail] ajax result:: ', result);
            if (result.result == 1) {
                setNotExistThumbnailInfo();
            }
        },
        error: function (xhr, status, error) {
            console.error('[doDeleteImage_thumbnail] ajax error:: ', error);
        },
    });
}

function setNotExistThumbnailInfo() {
    $('#partner_thumbnail_delete_btn').hide();
    $('#partner_thumbnail_saved').attr('src', '#').hide();

    let image_option = getImageUploadDefaultOption();
    image_option.imagesInputName = 'partner_thumbnail';
    image_option.label = '썸네일을 업로드 해주세요. (220x220)';
    $('#partner_thumbnail').show().imageUploader(image_option);
    $('#partner_thumbnail_new').val(1);
}

function doDelete(event) {
    if (typeof event != 'undefined') {
        event.preventDefault();
        event.stopPropagation();
    }

    const partner_seq = getPartnerSeq();
    if (partner_seq == 0) {
        return false;
    }

    if (confirm('협력사업자 정보를 정말로 삭제하시겠습니까?\n삭제된 정보는 복구할 수 없습니다.')) {
        $.ajax({
            type: 'post',
            url: './action/business_partner_delete.php',
            data: { seq: partner_seq },
            dataType: 'json',
            success: function (result) {
                console.log('[doDelete] ajax result:: ', result);
                alert('협력사업자 정보 삭제되었습니다.');
                location.href = './business.partner.php';
            },
            error: function (xhr, status, error) {
                console.error('[doDelete] ajax error:: ', error);
            },
        });
    }
}

function doUpdate(event) {
    if (typeof event != 'undefined') {
        event.preventDefault();
        event.stopPropagation();
    }

    const isUpdate = confirm('협력사업자 정보를 수정하시겠습니까?');
    if (!isUpdate) {
        return false;
    }

    const partner_seq = getPartnerSeq();
    if (partner_seq == 0) {
        return false;
    }

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

    $('#partner_seq').val(partner_seq);
    $('#updatePartnerForm').submit();

}
