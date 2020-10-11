<?php

// 로그인 체크
include('./login_check.php');

include('../common.php');
include('../db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$partner_seq = $_POST['seq'];
$partner_seq = intval(mysqli_real_escape_string($conn, $partner_seq));

// 1. 이미지 지우기
$sql = "SELECT seq, target_seq, target_type, upload_path FROM artgg_image WHERE target_seq = " . $partner_seq . " AND target_type = 'business'";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
if (($result->num_rows) > 0) {
    while ($row = $result->fetch_array()) {
        unlink('../' . $row['upload_path']);
    }
} // end of if (($result->num_rows) > 0)
$result->free();

// 2. 이미지 db 에서 delete
$sql = "DELETE FROM artgg_image WHERE target_seq = " . $partner_seq . " AND target_type = 'business'";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

// 3. thumbnail 지우기
$sql = "SELECT seq, thumbnail FROM artgg_business WHERE seq = " . $partner_seq;
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
if (($result->num_rows) > 0) {
    $row = $result->fetch_array();
    unlink('../' . $row['thumbnail']);
}

// 4. 정보 지우기
$sql = "DELETE FROM artgg_business WHERE seq = " . $partner_seq;
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

mysqli_close($conn);
flush();

$result_array['result'] = 1;

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>

