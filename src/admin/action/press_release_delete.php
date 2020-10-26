<?php

// 로그인 체크
include('./login_check.php');

include('../common.php');
include('../db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$press_release_seq = intval(mysqli_real_escape_string($conn, $_POST['seq']));

$sql  = "UPDATE artgg_press_release SET ";
$sql .= "deleted_at = now() ";
$sql .= "WHERE seq = " . $press_release_seq;

$message = '보도자료글이 삭제되었습니다.';

$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

$result_array['message'] = $message;
$result_array['result'] = 1;

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

mysqli_close($conn);
flush();

?>
