<?php

include('../common.php');
include('../db_conn.php');

$upload_files = $_FILES['insert_main_images'];
$upload_file_names = uploadImage($upload_files, 'main');

if ($upload_file_names == null) {
    viewAlert('메인 이미지 등록에 실패하였습니다.');
    exit;
}

$file_name = $upload_file_names[0]['file_name'];
$file_name_save = $upload_file_names[0]['file_save_name'];
$upload_file_path = $upload_file_names[0]['upload_file_path'];

$insert_main_caption = $_POST['insert_main_caption'];
$insert_main_link = $_POST['insert_main_link'];

$sql  = "INSERT INTO artgg_image (target_type, target_seq, sort, file_name, file_name_save, upload_path, caption, link) ";
$sql .= "VALUES ( 'main', 0, (select IFNULL(max(sort_temp.sort) + 1, 1) as next_sort from artgg_image sort_temp where sort_temp.target_type = 'main'), ";
$sql .= "'" . mysqli_real_escape_string($conn, $file_name) . "', ";
$sql .= "'" . mysqli_real_escape_string($conn, $file_name_save) . "', ";
$sql .= "'" . mysqli_real_escape_string($conn, $upload_file_path) . "', ";
$sql .= "'" . mysqli_real_escape_string($conn, $insert_main_caption) . "', ";
$sql .= "'" . mysqli_real_escape_string($conn, $insert_main_link) . "') ";

$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

viewAlert('메인 이미지가 등록되었습니다.');
echo ('<meta http-equiv="refresh" content="0 url=../main.php" />');
mysqli_close($conn);
flush();

?>
