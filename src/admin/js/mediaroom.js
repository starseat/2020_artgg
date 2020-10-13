function showEditMediaRoomModal(seq) {
    if(typeof seq != 'undefined' && seq > 0) {
        $('#mediaroom_seq').val(seq);

        const $targetItem = $('#mediaroom_item_' + seq);
        const title = $targetItem.find('td.media-room-title').text();
        const link = $targetItem.find('td.media-room-link a').attr('href');

        $('#mediaroom_title').val(title);
        $('#mediaroom_link').val(link);
        $('#mediaroom_submit_action').val('update');

    }
    else {
        $('#mediaroom_seq').val(0);
        $('#mediaroom_submit_action').val('insert');
    }
    $('#editMediaRoomModal').modal('show');
}

function doSubmit(event) {
    event.preventDefault();
    event.stopPropagation();

    const seq = parseInt($('#mediaroom_seq').val(), 10);

    const requestParam = {};
    // update
    if(seq != null && seq > 0) {
        seq = parseInt(seq, 10);

        $('#mediaroom_seq').val(seq);
        $('#mediaroom_submit_action').val('update');
    }
    // insert
    else {   
        $('#mediaroom_seq').val(0);
        $('#mediaroom_submit_action').val('insert');
    }

    const title = $('#mediaroom_title').val();
    if(title == '') {
        alert('제목을 입력해 주세요.');
        $('#mediaroom_title').focus();
        return false;
    }
    const link = $('#mediaroom_link').val();
    if( !(link.indexOf('https://youtu.be') >= 0 || link.indexOf('https://www.youtube.com') >= 0) ) {
        alert('Youtube 링크를 정확히 입력해 주세요.');
        $('#mediaroom_link').focus();
        return false;
    }
    const youtube_id = getYoutubeId(link);
    if (youtube_id == '') {
        alert('Youtube 의 동영상을 찾지 못했습니다.');
        $('#mediaroom_link').focus();
        return false;
    }

    $('#mediaroom_link_youtube_id').val(youtube_id);
    
    // $('#editMediaRoomModalFrom').submit();    

    requestParam.mediaroom_submit_action = $('#mediaroom_submit_action').val();
    requestParam.mediaroom_seq = $('#mediaroom_seq').val();
    requestParam.mediaroom_title = $('#mediaroom_title').val();
    requestParam.mediaroom_link = $('#mediaroom_link').val();
    requestParam.mediaroom_link_youtube_id = youtube_id;
    
    sendRequest(requestParam);
    
}

function deleteMediaRoom(seq) {
    const requestParam = {
        mediaroom_submit_action: 'delete', 
        mediaroom_seq: seq
    };

    sendRequest(requestParam);
}

function sendRequest(_data) {
    $.ajax({
        type: 'post',
        url: './action/media_room_submit.php',
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