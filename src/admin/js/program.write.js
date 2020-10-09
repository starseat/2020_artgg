// initKakaoMap();
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
let isLoadMap = false;  // 처음 맵 로드시 안보여서 한번더 호출시키 위한 플래그
function doSubmit_FindMap(event) {
    event.preventDefault();
    event.stopPropagation();

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
            $('#directionsModal_find_success_map_x').val(result[0].x);
            $('#directionsModal_find_success_map_y').val(result[0].y);

            if(isLoadMap == false) {
                doSubmit_FindMap(event);
                isLoadMap = true;
            }
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
            $('#directionsModal_find_success_map_x').val('');
            $('#directionsModal_find_success_map_y').val('');
        }
    });

}

function doSubmit_insertMap() {
    $('#program_directions').val($('#directionsModal_find_success_address').val());
    $('#program_directions_name').val($('#directionsModal_find_success_address_name').val());
    $('#program_directions_map_x').val($('#directionsModal_find_success_map_x').val());
    $('#program_directions_map_y').val($('#directionsModal_find_success_map_y').val());
    $('#directionsModal').modal('hide');
}
