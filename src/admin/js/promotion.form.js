$(document).ready(function () {
    setActiveNavMenu('promotion.php');
    initTextForm();
    initUploadForm();

    const promotion_seq = getPromotionSeq();
    if(promotion_seq > 0) {
        $('#promotion_uploaded_file_group').show();
        getPromotionInfo(promotion_seq);
    }
});

function initTextForm() {
    let option = getSummernoteDefaultOption();
    option.placeholder = '홍보자료 내용을 입력해 주세요.';
    $('#promotion_contents').summernote(option);
}

function initUploadForm() {
    // hwp, pdf 같은거 올릴때 서버에서 받아주질 못함..
    // $('#promotion_upload_files').fileinput({
    //     theme: 'fas',
    //     language: 'kr',
    //     uploadUrl: '#',
    //     browseOnZoneClick: true,
    //     allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'hwp', 'doc', 'docx', 'xls', 'xlsc', 'txt', 'zip']
    // });
}

function getPromotionSeq() {
    const seq = getParameter('seq');
    if (isEmpty(seq) || !isNumeric(seq)) {
        return 0;
    }

    return seq;
}

function getPromotionInfo(promotion_seq) {
     $.ajax({
        type: 'get',
        data: {seq: promotion_seq},
        url: './action/promotion_get.php',
        success: function (result) {
            console.log('[getPromotionInfo] result:: ', result);
            const resultObj = JSON.parse(result);
            console.log('[getPromotionInfo] resultObj:: ', resultObj);
            setPromotionInfo(resultObj.promotion_info);
            setUploadFileInfo(resultObj.file_info);
        }, 
        error: function (xhr, status, error) {
            console.error('[getPromotionInfo] ajax error:: ', error);
        },
        
    });
}

function setPromotionInfo(promotionInfo) {
    $('#promotion_form_reset_btn').hide();
    $('#promotion_form_delete_btn').show();

    $('#promotion_date_box').show();
    $('#promotion_created_at').val(promotionInfo.created_at);
    $('#promotion_updated_at').val(promotionInfo.updated_at);

    $('#promotion_seq').val(promotionInfo.seq);
    $('#promotion_title').val(promotionInfo.title);
    $('#promotion_contents').summernote('code', promotionInfo.contents);

    $('#promotion_upload_target_seq').val(promotionInfo.seq);
}

function setUploadFileInfo(fileList) {
    for(let i=0; i<fileList.length; i++) {
        let $uploadFile = '';
        // $uploadFile += '<button type="button" class="btn btn-outline-dark m-2" id="uploaded_file_' + fileList[i].seq + '" ';
        // $uploadFile += 'onclick="doFileDelete(' + fileList[i].seq + ', \'' + fileList[i].file_name + '\')">';
        // $uploadFile += fileList[i].file_name;
        // $uploadFile += ' <i class="fa fa-trash"></i>'
        // $uploadFile += '</button>';

        $uploadFile += '<div class="col-3" id="uploaded_file_' + fileList[i].seq + '">';
        $uploadFile += '<div class="card"><div class="card-body row justify-content-between">';

        $uploadFile += '<div class="col-6">' + fileList[i].file_name + '</div>';
        
        $uploadFile += '<div class="col-6" style="text-align: right;">';
        $uploadFile += ' <a class="btn btn-outline-secondary" ';
        $uploadFile += 'href="' + fileList[i].upload_path + '" download="' +  fileList[i].file_name + '">';
        $uploadFile += '<i class="fa fa-download"></i>';
        $uploadFile += '</a>';

        $uploadFile += ' <button type="button" class="btn btn-outline-danger" ';
        $uploadFile += 'onclick="doFileDelete(' + fileList[i].seq + ', \'' + fileList[i].file_name + '\')">';
        $uploadFile += '<i class="fa fa-trash"></i>';
        $uploadFile += '</button>';
        $uploadFile += '</div>';

        $uploadFile += '</div></div>';
        $uploadFile += '</div>';

        $('#promotion_uploaded_file_list').append($uploadFile);
        console.log('[setUploadFileInfo] fileList[' + i + '] :: ', fileList[i]);
    }
}

function doFileDelete(file_seq, filename) {
    if(confirm(filename + ' 파일을 삭제하시겠습니까?')) {
        $.ajax({
            type: 'post',
            url: './action/file_delete.php',
            data: { seq: file_seq },
            dataType: 'json',
            success: function (result) {
                console.log('[doFileDelete] ajax result:: ', result);
                $('#uploaded_file_' + file_seq).remove();
                alert(filename + ' 파일이 삭제되었습니다.');
            }, 
            error: function (xhr, status, error) {
                console.error('[doFileDelete] ajax error:: ', error);
            }, 
        });
    }
}

function doReset(event) {
    event.preventDefault();
    event.stopPropagation();

    $('#promotion_title').val('');
    $('#promotion_contents').summernote('reset');
    $('#promotion_upload_files').fileinput('reset');
}

function doSubmit(event) {
    event.preventDefault();
    event.stopPropagation();

    const promotion_seq = parseInt($('#promotion_seq').val(), 10);
    const promotion_title = $('#promotion_title').val();
    if (promotion_title == '') {
        alert('홍보자료 제목을 입력해주세요.');
        return false;
    }
    if ($('#promotion_contents').summernote('isEmpty')) {
        alert('홍보자료 내용을 입력해주세요.');
        return false;
    }
    const promotion_contents = $('#promotion_contents').summernote('code');
    
    $.ajax({
        type: 'post',
        url: './action/promotion_submit.php',
        data: { seq: promotion_seq, title: promotion_title, contents: promotion_contents },
        dataType: 'json',
        success: function (result) {
            console.log('[doSubmit] result:: ', result);            
            $('#promotion_upload_target_seq').val(result.target_seq);
            uploadFile(function() {
                alert(result.message);
                location.href = './promotion.php';
            }); 
        }, 
        error: function (xhr, status, error) {
            console.error('[doSubmit] ajax error:: ', error);
        },        
    });
}

function goPromotionList(event) {
    event.preventDefault();
    event.stopPropagation();

    location.href = './promotion.php';
}

function doDelete(event) {
    event.preventDefault();
    event.stopPropagation();

    const promotion_seq = parseInt($('#promotion_seq').val(), 10);
    if (promotion_seq == 0) {
        alert('잘못된 접근 입니다.');
        location.href = './promotion.php';
        return false;
    }

    if(confirm('홍보자료글을 정말로 삭제하시겠습니까?')) {
        $.ajax({
            type: 'post',
            url: './action/promotion_delete.php',
            data: { seq: promotion_seq },
            dataType: 'json',
            success: function (result) {
                console.log('[doDelete] result:: ', result);
                alert(result.message);
                location.href = './promotion.php';
            },
            error: function (xhr, status, error) {
                console.error('[doDelete] ajax error:: ', error);
            },

        });
    }    
}

function uploadFile(callback) {
    const formData = new FormData($('#promotion_from')[0]);
    console.log(formData);
    
    $.ajax({
        url: './action/promotion_upload.php',
        type: 'post',
        dataType: 'json',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        xhr: function() { //XMLHttpRequest 재정의 가능
            var xhr = $.ajaxSettings.xhr();
            xhr.upload.onprogress = function(e) { //progress 이벤트 리스너 추가
                var percent = e.loaded * 100 / e.total;
                console.log('upload... ', percent);
            };
            return xhr;
        },
        success: function (result) {
            console.log('[uploadFile] ajax success result: ', result);
            callback(result);
        }
    });
}