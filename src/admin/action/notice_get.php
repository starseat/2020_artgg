<?php

include('../common.php');
include('../db_conn.php');

$notice_seq = $_GET['seq'];
if (isEmpty($notice_seq) || !is_numeric($notice_seq)) {
    viewAlert('잘못된 접근 입니다.');
    mysqli_close($conn);
    flush();
    //historyBack();
    echo ('<meta http-equiv="refresh" content="0 url=../notice.php" />');
}

$notice_seq = intval(mysqli_real_escape_string($conn, $notice_seq));

$sql  = "SELECT seq, level, title, view_count, created_at, updated_at, contents FROM artgg_notice WHERE seq = $notice_seq";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$notice_count = $result->num_rows;
$notice_info = $result->fetch_array();
$result->free();

$result_array = array();
if ($notice_count > 0) {
    $result_array['notice_info'] = $notice_info;
} else {
    $result_array['notice_info'] = array();
}


mysqli_close($conn);
flush();

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
