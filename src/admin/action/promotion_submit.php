<?php

// 로그인 체크
include('./login_check.php');

include('../common.php');
include('../db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$promotion_seq = intval(mysqli_real_escape_string($conn, $_POST['seq']));
$promotion_title = mysqli_real_escape_string($conn, $_POST['title']);
$promotion_contents = mysqli_real_escape_string($conn, $_POST['contents']);

$sql = '';
$message = '';

// update
if($promotion_seq > 0) {
    $sql  = "UPDATE artgg_promotion SET ";
    $sql .= "title = '" . $promotion_title . "', ";
    $sql .= "contents = '" . $promotion_contents . "', ";
    $sql .= "updated_at = now() ";
    $sql .= "WHERE seq = " . $promotion_seq;

    $message = '홍보자료 글이 수정되었습니다.';
}
// insert
else {
    $sql  = "INSERT INTO artgg_promotion (title, contents) ";
    $sql .= "VALUES ( ";
    $sql .= "'" . $promotion_title . "', ";
    $sql .= "'" . $promotion_contents . "') ";    

    $message = '홍보자료 글이 등록되었습니다.';
}

$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

$result_array['message'] = $message;
$result_array['result'] = 1;

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

mysqli_close($conn);
flush();

?>
