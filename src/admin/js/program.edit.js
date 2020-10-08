// initKakaoMap();
$(document).ready(function () {
    setActiveNavMenu('program.php');
    initTextForm();

    const seq = getProgramSeq();
    console.log('[load] seq:: ', seq);
    if (seq == 0) {
        history.back();
    }
    else if (seq > 0) {
        getProgramInfo(seq, function (program_info) {
            initProgramInfo(program_info)
        });
    }
});

function getProgramSeq() {
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

function getProgramInfo(program_seq, callback) {
    $.ajax({
        type: 'get',
        data: { seq: program_seq },
        url: './action/program_get.php',
        success: function (result) {
            //console.log('[getProgramInfo] result:: ', result);
            let resultObj = JSON.parse(result);
            console.log('[getProgramInfo] resultObj:: ', resultObj);
            callback(resultObj);
        },
        error: function (xhr, status, error) {
            console.error('[getProgramInfo] ajax error:: ', error);
        },
    });

}

function initProgramInfo(programInfo) {
    console.log('[initProgramInfo] programInfo:: ', programInfo );
    $('#program_name').val(programInfo.program_info.name);
    $('#program_partners').val(programInfo.program_info.partners);
    $('#program_year').val(programInfo.program_info.year);
    $('#program_date').val(programInfo.program_info.program_date);
    $('#program_place').val(programInfo.program_info.place);
    $('#program_online_name').val(programInfo.program_info.online_name);
    $('#program_online_url').val(programInfo.program_info.online_url);

    $('#program_introduction_textform').summernote('code', programInfo.program_info.introduction);
    $('#program_schedule_textform').summernote('code', programInfo.program_info.schedule);
    $('#program_event_textform').summernote('code', programInfo.program_info.event);

    $('#program_directions').val(programInfo.program_info.directions);
    $('#program_directions_name').val(programInfo.program_info.directions_name);

    let thumbnail_path = programInfo.program_info.thumbnail;
    if (isEmpty(thumbnail_path)) {
        setNotExistThumbnailInfo();
    } else {
        $('#program_thumbnail').hide();
        $('#program_thumbnail_saved').attr('src', programInfo.program_info.thumbnail);
    }

    const image_info = programInfo.image_list[0];
    $('#program_image').hide();
    $('#program_image_saved').attr('src', image_info.upload_path).show();
    $('#program_image_saved_seq').val(image_info.seq);

    // 세팅 끝나고 alert 띄우기 위해서 아래로 배치함.
    if (isEmpty(thumbnail_path)) {
        alert('썸네일 정보가 존재하지 않습니다. 다시 등록해주세요.');
    }

    if (isEmpty(image_info) || isEmpty(image_info.upload_path)) {
        alert('대표 이미지 정보가 존재하지 않습니다. 다시 등록해주세요.');
    }

    // directionsModal 정보
    $('#directionsModal_address').val(programInfo.program_info.directions);
    $('#directionsModal_find_success_address').val(programInfo.program_info.directions);
    $('#directionsModal_address_name').val(programInfo.program_info.directions_name);
    $('#directionsModal_find_success_address_name').val(programInfo.program_info.directions_name);

    doSubmit_FindMap();
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
            doDeleteImage_program(sort);
        } else {
            doDeleteImage_thumbnail();
        }

    } // end of if (confirm(confirm_message))
}

function doDeleteImage_program(sort) {
    const targetElId = '#program_image';
    let img_seq = $(targetElId + '_saved_seq').val();

    $.ajax({
        type: 'post',
        url: './action/image_delete.php',
        data: { seq: img_seq },
        dataType: 'json',
        success: function (result) {
            console.log('[doDeleteImage_program] ajax result:: ', result);
            if (result.result == 1) {
                $(targetElId + '_delete_btn').hide();
                $(targetElId + '_saved').attr('src', '#').hide();
                $(targetElId + '_saved_seq').val(0);

                let image_option = getImageUploadDefaultOption();
                image_option.label = '대표 이미지를 업로드 해주세요.';
                image_option.imagesInputName = 'program_image';
                $(targetElId).show().imageUploader(image_option);

                $('#program_image_new').val(1);
            }
        },
        error: function (xhr, status, error) {
            console.error('[doDeleteImage_artist] ajax error:: ', error);
        },
    });
}

function doDeleteImage_thumbnail() {
    const program_seq = getProgramSeq();
    if (program_seq == 0) {
        return false;
    }

    $.ajax({
        type: 'post',
        url: './action/program_delete_thumbnail.php',
        data: { seq: program_seq },
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
    $('#program_thumbnail_delete_btn').hide();
    $('#program_thumbnail_saved').attr('src', '#').hide();

    let image_option = getImageUploadDefaultOption();
    image_option.imagesInputName = 'program_thumbnail';
    image_option.label = '썸네일을 업로드 해주세요. (220x220)';
    $('#program_thumbnail').show().imageUploader(image_option);
    $('#program_thumbnail_new').val(1);
}

function doDelete(event) {
    if (typeof event != 'undefined') {
        event.preventDefault();
        event.stopPropagation();
    }

    const program_seq = getProgramSeq();
    if (program_seq == 0) {
        return false;
    }

    if (confirm('프로그램 정보를 정말로 삭제하시겠습니까?\n삭제된 정보는 복구할 수 없습니다.')) {
        $.ajax({
            type: 'post',
            url: './action/program_delete.php',
            data: { seq: program_seq },
            dataType: 'json',
            success: function (result) {
                console.log('[doDelete] ajax result:: ', result);
                alert('프로그램 정보가 삭제되었습니다.');
                location.href = './program.php';
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

    const isUpdate = confirm('프로그램 정보를 수정하시겠습니까?');
    if (!isUpdate) {
        return false;
    }

    const program_seq = getProgramSeq();
    if (program_seq == 0) {
        return false;
    }

    if ($('#program_name').val() == '') {
        alert('프로그램명은 필수 입력사항 입니다.');
        $('#program_name').focus();
        return false;
    }

    if ($('#program_partners').val() == '') {
        alert('협력사 정보는 필수 입력사항 입니다.');
        $('#program_partners').focus();
        return false;
    }

    let year = parseInt($('#program_year').val(), 10);
    if (year == '' || year == 0 || year < 1000) {
        alert('년도는 필수 입력사항 입니다.');
        $('#program_year').focus();
        return false;
    } else if (year > 9999) {
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

    if ($('#program_thumbnail_new').val() == '1') {
        if ($('#program_thumbnail input[type="file"]').val() == '') {
            alert('썸네일은 필수로 등록되어야 합니다.');
            return false;
        }
    }
    
    if ($('#program_image_new').val() == '1') {
        if ($('#program_image input[type="file"]').val() == '') {
            alert('대표 이미지는 필수로 등록되어야 합니다.');
            return false;
        }
    }

    $('#program_introduction').html($('#program_introduction_textform').summernote('code'));
    $('#program_schedule').html($('#program_schedule_textform').summernote('code'));
    $('#program_event').html($('#program_event_textform').summernote('code'));

    $('#program_seq').val(program_seq);
    $('#updateProgramForm').submit();

}

function showDirectionsModal() {
    $('#directionsModal').modal('show');
}

function doSubmit_openKakaoMap(event) {
    event.preventDefault();
    event.stopPropagation();

    const win = window.open('https://map.kakao.com', '_blank');
    win.focus();
}

const geocoder = new kakao.maps.services.Geocoder();

function doSubmit_FindMap(event) {
    if(typeof event != 'undefined') {
        event.preventDefault();
        event.stopPropagation();
    }    

    const find_address = $('#directionsModal_address').val();
    if (find_address == '') {
        alert('주소는 필수 입력 사항입니다.');
        $('#directionsModal_address').focus();
        return false;
    }

    // 주소로 좌표 검색    
    geocoder.addressSearch(find_address, function (result, status) {
        $('#directionsModal_map').empty();

        // 주소 검색 성공
        if (status === kakao.maps.services.Status.OK) {
            $('#directionsModal_find_error').text('');

            const coords = new kakao.maps.LatLng(result[0].y, result[0].x);

            const mapContainer = document.getElementById('directionsModal_map');
            const mapOption = {
                center: coords, // 지도의 중심좌표
                level: 3 // 지도의 확대 레벨
            };
            const targetMapObj = new kakao.maps.Map(mapContainer, mapOption);

            // 마커 표시
            const marker = new kakao.maps.Marker({
                map: targetMapObj,
                position: coords
            });

            // 장소 명칭 표시
            const address_name = $('#directionsModal_address_name').val();
            if (typeof address_name != 'undefined' && address_name != '') {
                const infowindow = new kakao.maps.InfoWindow({
                    content: '<div style="width:150px;text-align:center;padding:6px 0;">' + address_name + '</div>'
                });
                infowindow.open(targetMapObj, marker);
            }

            // 위치로 이동
            targetMapObj.setCenter(coords);

            $('#directionsModal_map_box').show();
            $('#directionsModal_add_btn').show();
            $('#directionsModal_find_success_address').val(find_address);
            $('#directionsModal_find_success_address_name').val(address_name);
        }
        // 주소 검색 실패
        else {
            $('#directionsModal_map_box').hide();
            $('#directionsModal_add_btn').hide();
            $('#directionsModal_find_error').text('주소 검색에 실패하였습니다. 다시검색하여 주세요.');
            $('#program_directions').val('');
            $('#program_directions_name').val('');
            $('#directionsModal_find_success_address').val('');
            $('#directionsModal_find_success_address_name').val('');
        }
    });

}

function doSubmit_insertMap() {
    $('#program_directions').val($('#directionsModal_find_success_address').val());
    $('#program_directions_name').val($('#directionsModal_find_success_address_name').val());
    $('#directionsModal').modal('hide');
}
