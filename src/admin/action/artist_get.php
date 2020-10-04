<?php

include('../common.php');
include('../db_conn.php');

$artist_seq = $_GET['seq'];
if (isEmpty($artist_seq) || !is_numeric($artist_seq)) {
    viewAlert('잘못된 접근 입니다.');
    mysqli_close($conn);
    flush();
    //historyBack();
    echo ('<meta http-equiv="refresh" content="0 url=../artist.php" />');
}

$artist_seq = intval(mysqli_real_escape_string($conn, $artist_seq));

$sql  = "SELECT seq, year, name, en_name, thumbnail, introduction, academic, individual_exhibition, team_competition, interview ";
$sql .= "FROM artgg_artist WHERE seq = " . $artist_seq;
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$artist_count = $result->num_rows;
$artist_info = $result->fetch_array();
$result->free();

$result_array = array();
$image_array = array();
if($artist_count > 0) {
    $result_array['artist_info'] = $artist_info;    

    $sql  = "SELECT seq, target_seq, target_type, sort, file_name, upload_path, caption ";
    $sql .= "FROM artgg_image WHERE target_seq = " . $artist_seq . " AND target_type = 'artist' ";
    $sql .= "ORDER BY sort ASC";
    
    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

    $image_count = $result->num_rows;
    if($image_count > 0) {
        while ($image_row = $result->fetch_array()) {
            array_push($image_array, $image_row);
        }
    }

    $result->free();
}
else {
    $result_array['artist_info'] = array();
}

$result_array['image_list'] = $image_array;

mysqli_close($conn);
flush();

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
