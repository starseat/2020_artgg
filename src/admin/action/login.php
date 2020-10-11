<?php

session_start();

include('../db_conn.php');
include('../common_login.php');

header('Content-Type: text/html; charset=UTF-8');

$login_id = $_POST['login_id'];
$login_pw = $_POST['login_pw'];

$sql  = "SELECT ";
$sql .= "seq, user_id, name, member_type, password ";
$sql .= "FROM artgg_members ";
$sql .= "WHERE user_id = '" . $login_id . "'";

$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$user_count = mysqli_num_rows($result);

if ($user_count == 0) {
    echo ("<script>alert('아이디가 존재하지 않습니다.');</script>");
    echo ('<meta http-equiv="refresh" content="0 url=../login.html" />');
    mysqli_close($conn);
    flush();
    exit;
}

$row = mysqli_fetch_array($result);
//$hashed_password = password_encrypt($login_pw);
$dbPassword = $row['password'];
if (password_matches($login_pw, $dbPassword) == 0) {
    echo ("<script>alert('비밀번호가 잘못되었습니다.');</script>");
    echo ('<meta http-equiv="refresh" content="0 url=../login.html" />');
    mysqli_close($conn);
    flush();
    exit;
}

$sessionSavedUserInfo = [
    'seq' => $row['seq'], 
    'user_id' => $row['user_id'],
    'name' => $row['name'],
    'member_type' => $row['member_type']
];

$_SESSION['login_user_info'] = serialize($sessionSavedUserInfo);
$_SESSION['is_login'] = 1;


$result->free();
mysqli_close($conn);
flush();


echo ('<meta http-equiv="refresh" content="0 url=../index.php" />');

?>
