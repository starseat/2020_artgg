<?php

include('../common.php');
include('../db_conn.php');

// -- 썸네일 이미지 등록
$thumbnail = $_FILES['program_thumbnail'];
if ($thumbnail == null) {
    viewAlert('썸네일은 필수로 등록되어야 합니다.');
    mysqli_close($conn);
    exit;
}
$thumbnail_name_info = uploadImages($thumbnail, 'program_thumbnail');
if ($thumbnail_name_info == null) {
    viewAlert('썸네일 등록에 실패하였습니다.');
    mysqli_close($conn);
    exit;
}
$thumbnail_name = $thumbnail_name_info[0]['file_name'];
$thumbnail_name_save = $thumbnail_name_info[0]['file_save_name'];
$thumbnail_name_upload_path = $thumbnail_name_info[0]['upload_file_path'];

// -- 대표 이미지 등록
$program_image = $_FILES['program_image']; // var_dump($program_image);
if ($program_image == null) {
    viewAlert('대표이미지는 필수로 등록되어야 합니다.');
    mysqli_close($conn);
    exit;
}
$program_image_info = uploadImages($program_image, 'program');
if ($program_image_info == null) {
    viewAlert('대표이미지 등록에 실패하였습니다.');
    mysqli_close($conn);
    exit;
}
$program_image_name = $program_image_info[0]['file_name'];
$program_image_name_save = $program_image_info[0]['file_save_name'];
$program_image_name_upload_path = $program_image_info[0]['upload_file_path'];

// 필수 입력 값
$program_name = mysqli_real_escape_string($conn, $_POST['program_name']);
$program_partners = mysqli_real_escape_string($conn, $_POST['program_partners']);
$program_year = mysqli_real_escape_string($conn, $_POST['program_year']);
$program_date = mysqli_real_escape_string($conn, $_POST['program_date']);
$program_place = mysqli_real_escape_string($conn, $_POST['program_place']);

// 옵션 입력 값
$program_online_name = $_POST['program_online_name'];
if(!isEmpty($program_online_name)) { $program_online_name = mysqli_real_escape_string($conn, $program_online_name); }
$program_online_url = $_POST['program_online_url'];
if(!isEmpty($program_online_url)) { $program_online_url = mysqli_real_escape_string($conn, $program_online_url); }
$program_introduction = $_POST['program_introduction'];
if(!isEmpty($program_introduction)) { $program_introduction = mysqli_real_escape_string($conn, $program_introduction); }
$program_schedule = $_POST['program_schedule'];
if(!isEmpty($program_schedule)) { $program_schedule = mysqli_real_escape_string($conn, $program_schedule); }
$program_event = $_POST['program_event'];
if(!isEmpty($program_event)) { $program_event = mysqli_real_escape_string($conn, $program_event); }
$program_directions = $_POST['program_directions'];
if(!isEmpty($program_directions)) { $program_directions = mysqli_real_escape_string($conn, $program_directions); }
$program_directions_name = $_POST['program_directions_name'];
if(!isEmpty($program_directions_name)) { $program_directions_name = mysqli_real_escape_string($conn, $program_directions_name); }
$directions_map_x = $_POST['program_directions_map_x'];
if(!isEmpty($directions_map_x)) { $directions_map_x = mysqli_real_escape_string($conn, $directions_map_x); }
$directions_map_y = $_POST['program_directions_map_y'];
if(!isEmpty($directions_map_y)) { $directions_map_y = mysqli_real_escape_string($conn, $directions_map_y); }


$sql  = "INSERT INTO artgg_program (name, year, thumbnail, program_date, place, partners, online_url, online_name, introduction, ";
$sql .= "schedule, event, directions, directions_name, directions_map_x, directions_map_y) ";
$sql .= "VALUES ( ";
$sql .= "'" . $program_name . "', ";
$sql .= "'" . $program_year . "', ";
$sql .= "'" . $thumbnail_name_upload_path . "', ";
$sql .= "'" . $program_date . "', ";
$sql .= "'" . $program_place . "', ";
$sql .= "'" . $program_partners . "', ";

$sql .= "'" . $program_online_url . "', ";
$sql .= "'" . $program_online_name . "', ";
$sql .= "'" . $program_introduction . "', ";
$sql .= "'" . $program_schedule . "', ";
$sql .= "'" . $program_event . "', ";
$sql .= "'" . $program_directions . "', ";
$sql .= "'" . $program_directions_name . "', ";
$sql .= "'" . $directions_map_x . "', ";
$sql .= "'" . $directions_map_y . "') ";

$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

$program_seq = $conn->insert_id;

$sql  = "INSERT INTO artgg_image (target_type, target_seq, sort, file_name, file_name_save, upload_path) ";
$sql .= "VALUES ( 'program', ";
$sql .= $program_seq . ", 1, ";
$sql .= "'" . mysqli_real_escape_string($conn, $program_image_name) . "', ";
$sql .= "'" . mysqli_real_escape_string($conn, $program_image_name_save) . "', ";
$sql .= "'" . mysqli_real_escape_string($conn, $program_image_name_upload_path) . "') ";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

viewAlert('협력사업자 정보가 등록되었습니다.');
echo ('<meta http-equiv="refresh" content="0 url=../program.php" />');
mysqli_close($conn);
flush();

?>
