function showEditPressReleaseModal(seq) {
    if(typeof seq != 'undefined' && seq > 0) {
        $('#press_release_seq').val(seq);

        const $targetItem = $('#press_release_item_' + seq);
        const title = $targetItem.find('td.press_release_title').text();
        const link = $targetItem.find('td.press_release_link a').attr('href');

        $('#press_release_title').val(title);
        $('#press_release_link').val(link);
        $('#press_release_submit_action').val('update');

    }
    else {
        $('#press_release_seq').val(0);
        $('#press_release_submit_action').val('insert');
    }
    $('#editPressReleaseModal').modal('show');
}

function doSubmit(event) {
    event.preventDefault();
    event.stopPropagation();

    const seq = parseInt($('#press_release_seq').val(), 10);

    const requestParam = {};
    // update
    if(seq != null && seq > 0) {
        seq = parseInt(seq, 10);

        $('#press_release_seq').val(seq);
        $('#press_release_submit_action').val('update');
    }
    // insert
    else {   
        $('#press_release_seq').val(0);
        $('#press_release_submit_action').val('insert');
    }

    const title = $('#press_release_title').val();
    if(title == '') {
        alert('제목을 입력해 주세요.');
        $('#press_release_title').focus();
        return false;
    }
    const link = $('#press_release_link').val();
    if( link == '' ) {
        alert('링크를 정확히 입력해 주세요.');
        $('#press_release_link').focus();
        return false;
    }
    
    // $('#editPressReleaseModalFrom').submit();    

    requestParam.press_release_submit_action = $('#press_release_submit_action').val();
    requestParam.press_release_seq = $('#press_release_seq').val();
    requestParam.press_release_title = $('#press_release_title').val();
    requestParam.press_release_link = $('#press_release_link').val();

    sendRequest(requestParam);
    
}

function deletePressRelease(seq) {
    const requestParam = {
        press_release_submit_action: 'delete', 
        press_release_seq: seq
    };

    sendRequest(requestParam);
}

function sendRequest(_data) {
    $.ajax({
        type: 'post',
        url: './action/press_release_submit.php',
        data: _data,
        dataType: 'json',
        success: function (result) {
            console.log('[sendRequest] ajax result:: ', result);
            if (result.result == 1) {
                alert(result.message);
            }
            location.reload();
        },
        error: function (xhr, status, error) {
            console.error('[sendRequest] ajax error:: ', error);
        },
    });
}