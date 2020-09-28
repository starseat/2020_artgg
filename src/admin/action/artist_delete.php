<?php

include('../common.php');
include('../db_conn.php');

$artist_seq = $_POST['seq'];
$artist_seq = intval(mysqli_real_escape_string($conn, $artist_seq));

// 1. 이미지 지우기
$sql = "SELECT seq, target_seq, target_type, upload_path FROM artgg_image WHERE target_seq = " . $artist_seq . " AND target_type = 'artist'";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
if (($result->num_rows) > 0) {
    while ($row = $result->fetch_array()) {
        unlink('../' . $row['upload_path']);
    }
} // end of if (($result->num_rows) > 0)
$result->free();

// 2. 작가 관련 이미지 db 에서 delete
$sql = "DELETE FROM artgg_image WHERE target_seq = " . $artist_seq . " AND target_type = 'artist'";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

// 3. thumbnail 지우기
$sql = "SELECT seq, thumbnail FROM artgg_artist WHERE seq = " . $artist_seq;
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
if (($result->num_rows) > 0) {
    $row = $result->fetch_array();
    unlink('../' . $row['thumbnail']);
}

// 4. 작가 정보 지우기
$sql = "DELETE FROM artgg_artist WHERE seq = " . $artist_seq;
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

mysqli_close($conn);
flush();

$result_array['result'] = 1;

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
