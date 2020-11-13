<?php

// 로그인 체크
include('./login_check.php');

include('../common.php');
include('../db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$seq = $_POST['seq'];
$seq = mysqli_real_escape_string($conn, $seq);

$sql = "SELECT seq, target_type, file_name, file_name_save, upload_path FROM artgg_file WHERE seq = $seq";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$row = mysqli_fetch_array($result);

// 파일 삭제
unlink('../' . $row['upload_path']);

$result->free();

// db - delete
$sql = "DELETE FROM artgg_file WHERE seq = $seq";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

mysqli_close($conn);
flush();

$result_array['result'] = 1;

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
