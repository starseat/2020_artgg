<?php

include('./login_check.php');

include('../common_login.php');
include('../db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$current_pwd = mysqli_real_escape_string($conn, $_POST['currentPassword']);
$change_pwd = mysqli_real_escape_string($conn, $_POST['changePassword']);

$loginUser = unserialize($_SESSION['login_user_info']);

$sql = "SELECT seq, user_id, password FROM artgg_members WHERE seq = " . $loginUser['seq'];
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$user_info = $result->fetch_array();
$result->free();

$db_password = $user_info['password'];
if(password_matches($current_pwd, $db_password) == 0) {
    echo ("<script>alert('비밀번호가 다릅니다.');</script>");
    echo ("<script>history.back();</script>");
    mysqli_close($conn);
    flush();
    exit;
}

$new_pwd = password_encrypt($change_pwd);
$sql = "UPDATE artgg_members SET password = '" . $new_pwd . "' WHERE seq = " . $loginUser['seq'];
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

echo ("<script>alert('비밀번호가 변경되었습니다.');</script>");
echo ('<meta http-equiv="refresh" content="0 url=../change_password.php" />');

mysqli_close($conn);
flush();

?>
