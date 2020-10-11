$(function() {
    $('#currentPassword').keypress( function( event ) { hideErrorMessageBox(); });	
    $('#changePassword').keypress( function( event ) { hideErrorMessageBox(); });	
    $('#changePasswordCheck').keypress( function( event ) { hideErrorMessageBox(); });	
});

let isShowErrorMessageBox = false;
function hideErrorMessageBox() {
    if(isShowErrorMessageBox) {
        $('#error_message').text('');
        $('#error_message_box').hide();
        isShowErrorMessageBox = false;
    }
}
function showErrorMessageBox(message) {
    $('#error_message').text(message);
    $('#error_message_box').show();
    isShowErrorMessageBox = true;
}

function onSubmit(event) {
    event.preventDefault();
    event.stopPropagation();

    const current = $('#currentPassword').val();
    if(current == '') {
        showErrorMessageBox('현재 비밀번호를 입력해 주세요.');
        $('#currentPassword').focus();
        return false;
    }

    const change = $('#changePassword').val();
    if(change == '') {
        showErrorMessageBox('새로운 비밀번호를 입력해 주세요.');
        $('#changePassword').focus();
        return false;
    }

    const check = $('#changePasswordCheck').val();
    if(check == '') {
        showErrorMessageBox('새로운 비밀번호 확인을 위해 한번더 입력해 주세요.');
        $('#changePasswordCheck').focus();
        return false;
    }

    if(change != check) {
        showErrorMessageBox('새로운 비밀번호가 일치하지 않습니다.');
        $('#changePassword').focus();
        return false;
    }

    $('#changePasswordForm').submit();
}

