<?php

include('../common.php');
include('../db_conn.php');

$program_seq = $_GET['seq'];
if (isEmpty($program_seq) || !is_numeric($program_seq)) {
    viewAlert('잘못된 접근 입니다.');
    mysqli_close($conn);
    flush();
    //historyBack();
    echo ('<meta http-equiv="refresh" content="0 url=../program.php" />');
}

$program_seq = intval(mysqli_real_escape_string($conn, $program_seq));

$sql  = "SELECT seq, year, thumbnail, name, program_date, place, introduction, schedule, event, directions ";
$sql .= "FROM artgg_program WHERE seq = " . $program_seq;
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

$program_count = $result->num_rows;
$program_info = $result->fetch_array();
$result->free();

$result_array = array();
$image_array = array();
if($program_count > 0) {
    $result_array['program_info'] = $program_info;    

    $sql  = "SELECT seq, target_seq, target_type, sort, file_name, upload_path ";
    $sql .= "FROM artgg_image WHERE target_seq = " . $program_seq . " AND target_type = 'program' ";
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
    $result_array['program_info'] = array();
}

$result_array['image_list'] = $image_array;

mysqli_close($conn);
flush();

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
