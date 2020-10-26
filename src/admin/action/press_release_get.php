<?php

// 로그인 체크
include('./login_check.php');

include('../common.php');
include('../db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$press_release_seq = $_GET['seq'];
if (isEmpty($press_release_seq) || !is_numeric($press_release_seq)) {
    viewAlert('잘못된 접근 입니다.');
    mysqli_close($conn);
    flush();
    //historyBack();
    echo ('<meta http-equiv="refresh" content="0 url=../press_release.php" />');
}

$press_release_seq = intval(mysqli_real_escape_string($conn, $press_release_seq));
    
$sql  = "SELECT seq, title, link, news_date, news_media, news_author, view_count, created_at, updated_at, contents FROM artgg_press_release WHERE seq = $press_release_seq";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$item_count = $result->num_rows;
$item_info = $result->fetch_array();
$result->free();

$result_array = array();
if ($item_count > 0) {
    $result_array['press_release_info'] = $item_info;
} else {
    $result_array['press_release_info'] = array();
}


mysqli_close($conn);
flush();

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
