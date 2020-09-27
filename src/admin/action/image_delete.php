<?php

include('../common.php');
include('../db_conn.php');

$seq = $_POST['seq'];
$seq = mysqli_real_escape_string($conn, $seq);

$sql = "SELECT seq, target_type, sort, file_name, file_name_save, upload_path, caption, link FROM artgg_image WHERE seq = " . $seq;
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$row = mysqli_fetch_array($result);

// 파일 삭제
//unlink($row['upload_path']);
// 경로가 하나 더 위임.
//unlink('../' . $row['upload_path']);

$result->free();

// db - delete
$sql = "DELETE FROM artgg_image WHERE seq = $seq";
//$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

mysqli_close($conn);
flush();

$result_array['result'] = 1;

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
