<?php

include('../common.php');
include('../db_conn.php');

// -- 썸네일 이미지 등록
$thumbnail = $_FILES['partner_thumbnail'];
if ($thumbnail == null) {
    viewAlert('썸네일은 필수로 등록되어야 합니다.');
    mysqli_close($conn);
    exit;
}
$thumbnail_name_info = uploadImages($thumbnail, 'partner_thumbnail');
if ($thumbnail_name_info == null) {
    viewAlert('썸네일 등록에 실패하였습니다.');
    mysqli_close($conn);
    exit;
}
$thumbnail_name = $thumbnail_name_info[0]['file_name'];
$thumbnail_name_save = $thumbnail_name_info[0]['file_save_name'];
$thumbnail_name_upload_path = $thumbnail_name_info[0]['upload_file_path'];

// -- 대표 이미지 등록
$partner_image = $_FILES['partner_image']; // var_dump($partner_image);
if ($partner_image == null) {
    viewAlert('대표이미지는 필수로 등록되어야 합니다.');
    mysqli_close($conn);
    exit;
}
$partner_image_info = uploadImages($partner_image, 'business');
if ($partner_image_info == null) {
    viewAlert('대표이미지 등록에 실패하였습니다.');
    mysqli_close($conn);
    exit;
}
$partner_image_name = $partner_image_info[0]['file_name'];
$partner_image_name_save = $partner_image_info[0]['file_save_name'];
$partner_image_name_upload_path = $partner_image_info[0]['upload_file_path'];

// 필수 입력 값
$partner_name = mysqli_real_escape_string($conn, $_POST['partner_name']);
// 협력사업자 소개
$partner_introduction = $_POST['partner_introduction'];
if(!isEmpty($partner_introduction)) { $partner_introduction = mysqli_real_escape_string($conn, $partner_introduction); }

$sql  = "INSERT INTO artgg_business (type, name, thumbnail, introduction) ";
$sql .= "VALUES ( 'P', ";
$sql .= "'" . $partner_name . "', ";
$sql .= "'" . $thumbnail_name_upload_path . "', ";
$sql .= "'" . $partner_introduction . "') ";

$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

$partner_seq = $conn->insert_id;

$sql  = "INSERT INTO artgg_image (target_type, target_seq, sort, file_name, file_name_save, upload_path) ";
$sql .= "VALUES ( 'business', ";
$sql .= $partner_seq . ", 1, ";
$sql .= "'" . mysqli_real_escape_string($conn, $partner_image_name) . "', ";
$sql .= "'" . mysqli_real_escape_string($conn, $partner_image_name_save) . "', ";
$sql .= "'" . mysqli_real_escape_string($conn, $partner_image_name_upload_path) . "') ";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

viewAlert('협력사업자 정보가 등록되었습니다.');
echo ('<meta http-equiv="refresh" content="0 url=../business.partner.php" />');
mysqli_close($conn);
flush();

?>
