$(document).ready(function () {
    $('#btn_submitInsertForm').on('click', function (event) {
        event.preventDefault();
        doInsert();
    });

    $('#insert_main_image').change(function () {
        readURL(this, 'insert_main_image_preview');
    });
});

function doInsert() {
    const mainImage = $('#insert_main_image').val();
    if (!mainImage) {
        alert('파일을 첨부해 주세요.');
        return false;
    }

    $('#insertModalForm')[0].submit();
}

function doUpdate(mainImgSeq) {
    console.log('[doUpdate] seq: ' + mainImgSeq);

    const mainImgCaption = $('#main-img-caption-' + mainImgSeq).val();
    const mainImgLink = $('#main-img-link-' + mainImgSeq).val();
    const mainImgSort = $('#main-img-sort-' + mainImgSeq).val();

    if (confirm('정보를 수정하시겠습니까?')) {
        $.ajax({
            url: './action/main_image_update.php',
            type: 'post',
            dataType: 'json',
            data: { seq: mainImgSeq, caaption: mainImgCaption, link: mainImgLink, sort: mainImgSort },
            success: function (result) {
                console.log('[doUpdate] ajax success result:: ', result);
                alert('정보가 수정 되었습니다.');
                location.reload(true);
            }
        });
    }
}

function doDelete(mainImgSeq, filename) {
    console.log('[doDelete] seq: ' + mainImgSeq);
    console.log('[doDelete] filename: ' + filename);
    if (confirm(filename + ' 이미지를 삭제하시겠습니까?')) {
        $.ajax({
            url: './action/main_image_delete.php',
            type: 'post',
            dataType: 'json',
            data: { seq: mainImgSeq },
            success: function (result) {
                console.log('[doDelete] ajax success result:: ', result);
                alert('메인 이미지가 삭제되었습니다.');
                location.reload(true);
            }
        });
    }
}


function readURL(input, previewElId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#' + previewElId).attr('src', e.target.result).show();
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

function showInsertModal() {
    $('#insert_main_image').val('');
    $('#insert_main_image_preview').attr('src', '#').hide();;
    $('#insert_main_caption').val('');
    $('#insert_main_link').val('');

    $('#insertModal').modal('show');
}

