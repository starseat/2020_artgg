<?php

// 로그인 체크
include('./login_check.php');

include('../common.php');
include('../db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$artist_seq = $_POST['seq'];
$artist_seq = mysqli_real_escape_string($conn, $artist_seq);

$sql  = "SELECT seq, thumbnail ";
$sql .= "FROM artgg_artist WHERE seq = " . $artist_seq;
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$row = mysqli_fetch_array($result);

// 파일 삭제
unlink('../' . $row['thumbnail']);

$result->free();

// db - thumbnail delete
$sql = "UPDATE artgg_artist SET thumbnail = '' WHERE seq = " . $artist_seq;
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

mysqli_close($conn);
flush();

$result_array['result'] = 1;

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
