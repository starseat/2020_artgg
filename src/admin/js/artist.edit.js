
$(document).ready(function () {
    setActiveNavMenu('artist.php');
    initTextForm();

    const seq = getArtistSeq();
    if( seq == 0) {
        history.back();
    }

    if(seq > 0) {
        getArtistInfo(seq, function (artist_info) {
            initArtistInfo(artist_info)
        });
    }    
});

function getArtistSeq() {
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

    let thumbnail_path = artistInfo.artist_info.thumbnail;
    if (isEmpty(thumbnail_path)) {
        setNotExistThumbnailInfo();
    }
    else {
        $('#artist_thumbnail').hide();
        $('#artist_thumbnail_saved').attr('src', artistInfo.artist_info.thumbnail);
    }

    const image_list = artistInfo.image_list;
    const image_is_show_list = [false, false, false, false];
    const imageElId = '#artist_image';
    for(let i=0; i<image_list.length; i++) {
        let targetElId = imageElId + (i + 1);
        $(targetElId).hide();
        $(targetElId + '_saved').attr('src', image_list[i].upload_path).show();
        $(targetElId + '_saved_seq').val(image_list[i].seq);
        $(targetElId + '_caption').val(image_list[i].caption);
        image_is_show_list[i] = true;
    }

    let artist_image_option = getImageUploadDefaultOption();
    artist_image_option.label = '작가님의 이미지를 업로드 해주세요.';

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

    // 세팅 끝나고 alert 띄우기 위해서 아래로 배치함.
    if (isEmpty(thumbnail_path)) {
        alert('썸네일 이미지 정보가 존재하지 않습니다. 다시 등록해주세요.');
    }
}

function doDeleteImage(event, sort) {
    // sort => 0: thumbnail, 1~4
    if (typeof event != 'undefined') {
        event.preventDefault();
        event.stopPropagation();
    }

    let confirm_message = '';
    if(sort > 0) {
        confirm_message = sort + ' 번째 이미지를 정말로 삭제하시겠습니까?';
    }
    else {
        confirm_message = '썸네일 이미지를 정말로 삭제하시겠습니까?';
    }
    confirm_message += '\n삭제 후 이미지는 복구할 수 없습니다.'

    if (confirm(confirm_message)) {
        if(sort > 0) {
            doDeleteImage_artist(sort);
        }
        else {
            doDeleteImage_thumbnail();
        }
        
    } // end of if (confirm(confirm_message))
}

function doDeleteImage_artist(sort) {
    const targetElId = '#artist_image' + sort;
    let img_seq = $(targetElId + '_saved_seq').val();

    $.ajax({
        type: 'post',
        url: './action/image_delete.php',
        data: { seq: img_seq },
        dataType: 'json',
        success: function (result) {
            console.log('[doDeleteImage_artist] ajax result:: ', result);
            if (result.result == 1) {
                $(targetElId + '_delete_btn').hide();
                $(targetElId + '_saved').attr('src', '#').hide();
                $(targetElId + '_saved_seq').val(0);
                $(targetElId + '_caption').val('');

                let artist_image_option = getImageUploadDefaultOption();
                artist_image_option.label = '작가님의 이미지를 업로드 해주세요.';
                artist_image_option.imagesInputName = 'artist_image' + sort;
                $(targetElId).show().imageUploader(artist_image_option);

                if(sort == 1) {
                    $('#artist_image1_new').val(1);
                }
            }
        },
        error: function (xhr, status, error) {
            console.error('[doDeleteImage_artist] ajax error:: ', error);
        },
    });
}

function doDeleteImage_thumbnail() {
    const artist_seq = getArtistSeq();
    if (artist_seq == 0) {
        return false;
    }

    $.ajax({
        type: 'post',
        url: './action/artist_delete_thumbnail.php',
        data: { seq: artist_seq },
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
    $('#artist_thumbnail_delete_btn').hide();
    $('#artist_thumbnail_saved').attr('src', '#').hide();

    let artist_image_option = getImageUploadDefaultOption();
    artist_image_option.imagesInputName = 'artist_thumbnail';
    artist_image_option.label = '작가님의 대표 이미지(썸네일)를 업로드 해주세요.';
    $('#artist_thumbnail').show().imageUploader(artist_image_option);
    $('#artist_thumbnail_new').val(1);
}

function doDelete(event) {
    if (typeof event != 'undefined') {
        event.preventDefault();
        event.stopPropagation();
    }

    const artist_seq = getArtistSeq();
    if (artist_seq == 0) {
        return false;
    }

    if (confirm('작가 정보를 정말로 삭제하시겠습니까?\n삭제된 정보는 복구할 수 없습니다.')) {
        $.ajax({
            type: 'post',
            url: './action/artist_delete.php',
            data: { seq: artist_seq },
            dataType: 'json',
            success: function (result) {
                console.log('[doDelete] ajax result:: ', result);
                alert('작가 정보가 삭제되었습니다.');
                location.href = '../artist.php';
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

    const isUpdate = confirm('작가정보를 수정하시겠습니까?');
    if(!isUpdate) {
        return false;
    }

    const artist_seq = getArtistSeq();
    if (artist_seq == 0) {
        return false;
    }

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
    } else if (year > 9999) {
        alert('년도는 최대 4자리 까지만 입력 가능합니다.');
        $('#artist_year').focus();
        return false;
    }
    
    if ($('#artist_thumbnail_new').val() == '1') {
        if ( !$($('#artist_thumbnail .image-uploader')[0]).hasClass('has-files')) {
            alert('작가님의 썸네일은 필수로 등록되어야 합니다.');
            return false;
        }
    }

    if ($('#artist_image1_new').val() == '1') {
        if ( !$($('#artist_image1 .image-uploader')[0]).hasClass('has-files') ) {
            alert('작가님의 1번 이미지는 필수로 등록되어야 합니다.');
            return false;
        }
    }


    $('#artist_introduction_temp').html($('#artist_introduction').summernote('code'));
    $('#artist_academic_temp').html($('#artist_academic').summernote('code'));
    $('#artist_individual_exhibition_temp').html($('#artist_individual_exhibition').summernote('code'));
    $('#artist_team_competition_temp').html($('#artist_team_competition').summernote('code'));
    $('#artist_interview_temp').html($('#artist_interview').summernote('code'));

    $('#artist_seq').val(artist_seq);
    $('#updateArtistForm').submit();

}


