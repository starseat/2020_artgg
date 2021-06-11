<?php

// 로그인 체크
include('./login_check.php');

include('../common.php');
include('../db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$result_array = array();

$target_type = 'notice';

$notice_image = $_FILES['uploadImage']; // var_dump($artist_image1);
$notice_image_upload_info = uploadImage($notice_image, $target_type); // var_dump($main_images_upload_info_list);

$result_array['result'] = true;
$result_array['code'] = 0;
$result_array['message'] = 'success';
$result_array['data'] = $notice_image_upload_info['upload_file_path'];

$sql  = "INSERT INTO artgg_image (target_type, target_seq, sort, file_name, file_name_save, upload_path) ";
$sql .= "VALUES ( '" . $target_type . "', 0, (select IFNULL(max(sort_temp.sort) + 1, 1) as next_sort from artgg_image sort_temp where sort_temp.target_type = '" . $target_type . "'), ";
$sql .= "'" . mysqli_real_escape_string($conn, $notice_image_upload_info['file_name']) . "', ";
$sql .= "'" . mysqli_real_escape_string($conn, $notice_image_upload_info['file_save_name']) . "', ";
$sql .= "'" . mysqli_real_escape_string($conn, $notice_image_upload_info['upload_file_path']) . "') ";

$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));


mysqli_close($conn);
flush();

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
