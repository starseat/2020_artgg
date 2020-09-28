function doUpdate(seq) {
    //alert('[doUpdate] seq: ' + seq);
    location.href='./artist_edit.php?seq=' + seq;
}

function doDelete(seq) {
    if(confirm('작가 정보를 정말로 삭제하시겠습니까?\n삭제된 정보는 복구할 수 없습니다.')) {
        $.ajax({
            type: 'post',
            url: './action/artist_delete.php',
            data: { seq: seq },
            dataType: 'json',
            success: function (result) {
                console.log('[doDelete] ajax result:: ', result);
                alert('작가 정보가 삭제되었습니다.');
                location.reload(true);
            },
            error: function (xhr, status, error) {
                console.error('[doDelete] ajax error:: ', error);
            },
        });
    }
}
