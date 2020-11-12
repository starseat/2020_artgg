<?php

// 로그인 체크
include('./login_check.php');

include('../common.php');
include('../db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$result_array = array();

$upload_target_seq = $_POST['promotion_upload_target_seq'];
$upload_files = $_FILES['promotion_upload_files'];
$upload_info = uploadFiles($upload_files, 'promotion');
$upload_info_count = count($upload_info);

for ($i = 0; $i < $upload_info_count; $i++) {

    $sql  = "INSERT INTO artgg_file (target_type, target_seq, sort, file_name, file_name_save, upload_path) ";
    $sql .= "VALUES ( 'promotion', ";
    $sql .= $upload_target_seq . ", ";
    $sql .= ($i + 1) . ", ";
    $sql .= "'" . mysqli_real_escape_string($conn, $upload_info[$i]['file_name']) . "', ";
    $sql .= "'" . mysqli_real_escape_string($conn, $upload_info[$i]['file_save_name']) . "', ";
    $sql .= "'" . mysqli_real_escape_string($conn, $upload_info[$i]['upload_file_path']) . "' ";
    $sql .= ") ";

    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
} // end of for ($i = 0; $i<$upload_info_count; $i++);


mysqli_close($conn);
flush();

$result_array['message'] = '파일 업로드에 성공하였습니다.';
$result_array['result'] = 1;
$result_array['upload_count'] = $upload_info_count;

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
