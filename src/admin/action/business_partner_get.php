<?php

include('../common.php');
include('../db_conn.php');

$partner_seq = $_GET['seq'];
if (isEmpty($partner_seq) || !is_numeric($partner_seq)) {
    viewAlert('잘못된 접근 입니다.');
    mysqli_close($conn);
    flush();
    //historyBack();
    echo ('<meta http-equiv="refresh" content="0 url=../business.partner.php" />');
}

$partner_seq = intval(mysqli_real_escape_string($conn, $partner_seq));

$sql  = "SELECT seq, type, name, thumbnail, introduction ";
$sql .= "FROM artgg_business WHERE seq = " . $partner_seq . " AND type = 'P'";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

$partner_count = $result->num_rows;
$partner_info = $result->fetch_array();
$result->free();

$result_array = array();
$image_array = array();
if($partner_count > 0) {
    $result_array['partner_info'] = $partner_info;    

    $sql  = "SELECT seq, target_seq, target_type, sort, file_name, upload_path, caption ";
    $sql .= "FROM artgg_image WHERE target_seq = " . $partner_seq . " AND target_type = 'business' ";
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
    $result_array['partner_info'] = array();
}

$result_array['image_list'] = $image_array;

mysqli_close($conn);
flush();

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
