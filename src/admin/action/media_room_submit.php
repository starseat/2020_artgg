<?php

// 로그인 체크
include('./login_check.php');

include('../common.php');
include('../db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$action = mysqli_real_escape_string($conn, $_POST['mediaroom_submit_action']);
$seq = intval(mysqli_real_escape_string($conn, $_POST['mediaroom_seq']));

$result_array = array();
$message = '';

$sql = '';
if($action == 'delete') {
    $sql  = "DELETE FROM artgg_mediaroom WHERE seq = $seq";

    $message = '미디어룸 정보가 삭제되었습니다.';
}
else {
    
    $title = mysqli_real_escape_string($conn, $_POST['mediaroom_title']);
    $link = mysqli_real_escape_string($conn, $_POST['mediaroom_link']);
    $youtube_id = mysqli_real_escape_string($conn, $_POST['mediaroom_link_youtube_id']);

    // update
    //if ($seq > 0) {
    if ($action == 'update') {
        $sql  = "UPDATE artgg_mediaroom SET ";
        $sql .= "title = '" . $title . "', ";
        $sql .= "youtube_id = '" . $youtube_id . "', ";
        $sql .= "link = '" . $link . "' ";        
        $sql .= "WHERE seq = " . $seq;

        $message = '미디어룸 정보가 수정되었습니다.';
    }
    // insert
    else {
        $sql  = "INSERT INTO artgg_mediaroom (title, youtube_id, link) ";
        $sql .= "VALUES (";
        $sql .= "'" . $title . "', ";
        $sql .= "'" . $youtube_id . "', ";
        $sql .= "'" . $link . "') ";

        $message = '미디어룸 정보가 등록되었습니다.';
    }
}


$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

mysqli_close($conn);
flush();

$result_array['message'] = $message;
$result_array['result'] = 1;

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>

    