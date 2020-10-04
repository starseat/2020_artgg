function doUpdate(partner_seq) {
    //alert('[doUpdate] seq: ' + partner_seq);
    location.href = './business.partner_edit.php?seq=' + partner_seq;
}

function doDelete(partner_seq) {
    if (confirm('협력사업자 정보를 정말로 삭제하시겠습니까?\n삭제된 정보는 복구할 수 없습니다.')) {
        $.ajax({
            type: 'post',
            url: './action/business_partner_delete.php',
            data: { seq: partner_seq },
            dataType: 'json',
            success: function (result) {
                console.log('[doDelete] ajax result:: ', result);
                alert('협력사업자 정보 삭제되었습니다.');
                location.reload(true);
            },
            error: function (xhr, status, error) {
                console.error('[doDelete] ajax error:: ', error);
            },
        });
    }
}
