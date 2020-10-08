<?php

include('common.php');
include('db_conn.php');

$login_id = $_POST['login_id'];
$login_pw = $_POST['login_pw'];

$sql  = "SELECT ";
$sql .= "user_id, email, name, member_type, password ";
$sql .= "FROM artgg_members ";
$sql .= "WHERE user_id = '" . $login_id . "'";

$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$user_count = mysqli_num_rows($result);

mysqli_close($conn);
flush();

if ($user_count == 0) {
    echo ("<script>alert('아이디가 존재하지 않습니다.');</script>");
    echo ('<meta http-equiv="refresh" content="0 url=login.html" />');
    exit;
}

$row = mysqli_fetch_array($result);
//$hashed_password = password_encrypt($login_pw);
$dbPassword = $row['password'];
if (password_matches($pwd, $dbPassword) == 0) {
    echo ("<script>alert('비밀번호가 잘못되었습니다.');</script>");
    echo ('<meta http-equiv="refresh" content="0 url=login.html" />');
    exit;
}

$sessionSavedUserInfo = [
    'user_id' => $row['user_id'],
    'email' => $row['email'],
    'name' => $row['name'],
    'member_type' => $row['member_type']
];

$_SESSION['login_user_info'] = serialize($sessionSavedUserInfo);
$_SESSION['is_login'] = 1;

echo ('<meta http-equiv="refresh" content="0 url=./index.php" />');

?>
