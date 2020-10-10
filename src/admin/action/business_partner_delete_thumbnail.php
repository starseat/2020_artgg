<?php

include('../common.php');
include('../db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$partner_seq = $_POST['seq'];
$partner_seq = mysqli_real_escape_string($conn, $partner_seq);

$sql  = "SELECT seq, thumbnail ";
$sql .= "FROM artgg_business WHERE seq = " . $partner_seq;
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$row = mysqli_fetch_array($result);

// 파일 삭제
unlink('../' . $row['thumbnail']);

$result->free();

// db - thumbnail delete
$sql = "UPDATE artgg_business SET thumbnail = '' WHERE seq = " . $partner_seq;
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

mysqli_close($conn);
flush();

$result_array['result'] = 1;

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
