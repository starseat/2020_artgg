<?php

// 로그인 체크
include('./login_check.php');

include('../common.php');
include('../db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$notice_seq = intval(mysqli_real_escape_string($conn, $_POST['seq']));
$notice_level = intval(mysqli_real_escape_string($conn, $_POST['level']));
$notice_title = mysqli_real_escape_string($conn, $_POST['title']);
$notice_contents = mysqli_real_escape_string($conn, $_POST['contents']);

$sql = '';
$message = '';

// update
if($notice_seq > 0) {
    $sql  = "UPDATE artgg_notice SET ";
    $sql .= "level = " . $notice_level . ", ";
    $sql .= "title = '" . $notice_title . "', ";
    $sql .= "contents = '" . $notice_contents . "', ";
    $sql .= "updated_at = now() ";
    $sql .= "WHERE seq = " . $notice_seq;

    $message = '공지사항이 수정되었습니다.';
}
// insert
else {
    $sql  = "INSERT INTO artgg_notice (level, title, contents) ";
    $sql .= "VALUES ( ";
    $sql .=       $notice_level . ", ";
    $sql .= "'" . $notice_title . "', ";
    $sql .= "'" . $notice_contents . "') ";    

    $message = '공지사항이 등록되었습니다.';
}

$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

$result_array['message'] = $message;
$result_array['result'] = 1;

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

mysqli_close($conn);
flush();

?>
