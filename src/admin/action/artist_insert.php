<?php

// 로그인 체크
include('./login_check.php');

include('../common.php');
include('../db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

// -- 썸네일 이미지 등록
$thumbnail = $_FILES['artist_thumbnail'];
if ($thumbnail == null) {
    viewAlert('썸네일은 필수로 등록되어야 합니다.');
    mysqli_close($conn);
    exit;
}
$thumbnail_name_info = uploadImages($thumbnail, 'artist_thumbnail');
if ($thumbnail_name_info == null) {
    viewAlert('썸네일 등록에 실패하였습니다.');
    mysqli_close($conn);
    exit;
}
$thumbnail_name = $thumbnail_name_info[0]['file_name'];
$thumbnail_name_save = $thumbnail_name_info[0]['file_save_name'];
$thumbnail_name_upload_path = $thumbnail_name_info[0]['upload_file_path'];

// -- 대표 이미지 1 등록
$artist_image1 = $_FILES['artist_image1']; // var_dump($artist_image1);
if ($artist_image1 == null) {
    viewAlert('대표이미지 1은 필수로 등록되어야 합니다.');
    mysqli_close($conn);
    exit;
}
$artist_image1_info = uploadImages($artist_image1, 'artist');
if ($artist_image1_info == null) {
    viewAlert('대표이미지 1 등록에 실패하였습니다.');
    mysqli_close($conn);
    exit;
}
$artist_image1_name = $artist_image1_info[0]['file_name'];
$artist_image1_name_save = $artist_image1_info[0]['file_save_name'];
$artist_image1_name_upload_path = $artist_image1_info[0]['upload_file_path'];

// -- 대표 이미지 2 등록
$artist_image2_name = '';
$artist_image2_name_save = '';
$artist_image2_name_upload_path = '';
$artist_image2 = $_FILES['artist_image2'];
if ($artist_image2['name'][0] != '') {
    $artist_image2_info = uploadImages($artist_image2, 'artist');
    if ($artist_image2_info == null) {
        viewAlert('대표이미지 2 등록에 실패하였습니다.');
        mysqli_close($conn);
        exit;
    }
    $artist_image2_name = $artist_image2_info[0]['file_name'];
    $artist_image2_name_save = $artist_image2_info[0]['file_save_name'];
    $artist_image2_name_upload_path = $artist_image2_info[0]['upload_file_path'];
}
else {
    // 파일이 등록되지 않은경우 기본 정보는 공백으로 저장되므로 null 이 아님. 강제로 null 박아줌.
    $artist_image2 = null;
}

// -- 대표 이미지 3 등록
$artist_image3_name = '';
$artist_image3_name_save = '';
$artist_image3_name_upload_path = '';
$artist_image3 = $_FILES['artist_image3'];
if ($artist_image3['name'][0] != '') {
    $artist_image3_info = uploadImages($artist_image3, 'artist');
    if ($artist_image3_info == null) {
        viewAlert('대표이미지 3 등록에 실패하였습니다.');
        mysqli_close($conn);
        exit;
    }
    $artist_image3_name = $artist_image3_info[0]['file_name'];
    $artist_image3_name_save = $artist_image3_info[0]['file_save_name'];
    $artist_image3_name_upload_path = $artist_image3_info[0]['upload_file_path'];
}
else {
    $artist_image3 = null;
}

// -- 대표 이미지 4 등록
$artist_image4_name = '';
$artist_image4_name_save = '';
$artist_image4_name_upload_path = '';
$artist_image4 = $_FILES['artist_image4'];
if ($artist_image4['name'][0] != '') {
    $artist_image4_info = uploadImages($artist_image4, 'artist');
    if ($artist_image4_info == null) {
        viewAlert('대표이미지 4 등록에 실패하였습니다.');
        mysqli_close($conn);
        exit;
    }
    $artist_image4_name = $artist_image4_info[0]['file_name'];
    $artist_image4_name_save = $artist_image4_info[0]['file_save_name'];
    $artist_image4_name_upload_path = $artist_image4_info[0]['upload_file_path'];
}
else {
    $artist_image4 = null;
}

// 필수 입력 값
$artist_name = mysqli_real_escape_string($conn, $_POST['artist_name']);
$artist_name_en = mysqli_real_escape_string($conn, $_POST['artist_name_en']);
$artist_year = mysqli_real_escape_string($conn, $_POST['artist_year']);

// 캡션 1~4
$artist_image1_caption = $_POST['artist_image1_caption'];
if(!isEmpty($artist_image1_caption)) { $artist_image1_caption = mysqli_real_escape_string($conn, $_POST['artist_image1_caption']);}
$artist_image2_caption = $_POST['artist_image2_caption'];
if(!isEmpty($artist_image2_caption)) { $artist_image1_caption = mysqli_real_escape_string($conn, $_POST['artist_image2_caption']);}
$artist_image3_caption = $_POST['artist_image3_caption'];
if(!isEmpty($artist_image3_caption)) { $artist_image1_caption = mysqli_real_escape_string($conn, $_POST['artist_image3_caption']);}
$artist_image4_caption = $_POST['artist_image4_caption'];
if(!isEmpty($artist_image4_caption)) { $artist_image1_caption = mysqli_real_escape_string($conn, $_POST['artist_image4_caption']);}

// 작가소개
$artist_introduction = $_POST['artist_introduction'];
if(!isEmpty($artist_introduction)) { $artist_introduction = mysqli_real_escape_string($conn, $_POST['artist_introduction']); }
// 학력
$artist_academic = $_POST['artist_academic'];
if(!isEmpty($artist_academic)) { $artist_academic = mysqli_real_escape_string($conn, $_POST['artist_academic']); }
// 주요 개인전
$artist_individual_exhibition = $_POST['artist_individual_exhibition'];
if(!isEmpty($artist_individual_exhibition)) { $artist_individual_exhibition = mysqli_real_escape_string($conn, $_POST['artist_individual_exhibition']); }
// 주요 단체전
$artist_team_competition = $_POST['artist_team_competition'];
if(!isEmpty($artist_team_competition)) { $artist_team_competition = mysqli_real_escape_string($conn, $_POST['artist_team_competition']); }
// 작가 인터뷰
$artist_interview = $_POST['artist_interview'];
if(!isEmpty($artist_interview)) { $artist_interview = mysqli_real_escape_string($conn, $_POST['artist_interview']); }


$sql  = "INSERT INTO artgg_artist (year, name, en_name, thumbnail, introduction, academic, individual_exhibition, team_competition, interview) ";
$sql .= "VALUES ( ";
$sql .= "'" . $artist_year . "', ";
$sql .= "'" . $artist_name . "', ";
$sql .= "'" . $artist_name_en . "', ";
$sql .= "'" . $thumbnail_name_upload_path . "', ";
$sql .= "'" . $artist_introduction . "', ";
$sql .= "'" . $artist_academic . "', ";
$sql .= "'" . $artist_individual_exhibition . "', ";
$sql .= "'" . $artist_team_competition . "', ";
$sql .= "'" . $artist_interview . "') ";

$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

$artist_seq = $conn->insert_id;


$sql  = "INSERT INTO artgg_image (target_type, target_seq, sort, file_name, file_name_save, upload_path, caption, link) ";
$sql .= "VALUES ( 'artist', ";
$sql .= $artist_seq . ", 1, ";
$sql .= "'" . mysqli_real_escape_string($conn, $artist_image1_name) . "', ";
$sql .= "'" . mysqli_real_escape_string($conn, $artist_image1_name_save) . "', ";
$sql .= "'" . mysqli_real_escape_string($conn, $artist_image1_name_upload_path) . "', ";
$sql .= "'" . $artist_image1_caption . "', ";
$sql .= "'') ";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

if ($artist_image2 != null) {
    $sql  = "INSERT INTO artgg_image (target_type, target_seq, sort, file_name, file_name_save, upload_path, caption, link) ";
    $sql .= "VALUES ( 'artist', ";
    $sql .= $artist_seq . ", 2, ";
    $sql .= "'" . mysqli_real_escape_string($conn, $artist_image2_name) . "', ";
    $sql .= "'" . mysqli_real_escape_string($conn, $artist_image2_name_save) . "', ";
    $sql .= "'" . mysqli_real_escape_string($conn, $artist_image2_name_upload_path) . "', ";
    $sql .= "'" . $artist_image2_caption . "', ";
    $sql .= "'') ";
    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
}
if ($artist_image3 != null) {
    $sql  = "INSERT INTO artgg_image (target_type, target_seq, sort, file_name, file_name_save, upload_path, caption, link) ";
    $sql .= "VALUES ( 'artist', ";
    $sql .= $artist_seq . ", 3, ";
    $sql .= "'" . mysqli_real_escape_string($conn, $artist_image3_name) . "', ";
    $sql .= "'" . mysqli_real_escape_string($conn, $artist_image3_name_save) . "', ";
    $sql .= "'" . mysqli_real_escape_string($conn, $artist_image3_name_upload_path) . "', ";
    $sql .= "'" . $artist_image3_caption . "', ";
    $sql .= "'') ";
    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
}
if ($artist_image4 != null) {
    $sql  = "INSERT INTO artgg_image (target_type, target_seq, sort, file_name, file_name_save, upload_path, caption, link) ";
    $sql .= "VALUES ( 'artist', ";
    $sql .= $artist_seq . ", 4, ";
    $sql .= "'" . mysqli_real_escape_string($conn, $artist_image4_name) . "', ";
    $sql .= "'" . mysqli_real_escape_string($conn, $artist_image4_name_save) . "', ";
    $sql .= "'" . mysqli_real_escape_string($conn, $artist_image4_name_upload_path) . "', ";
    $sql .= "'" . $artist_image4_caption . "', ";
    $sql .= "'') ";
    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
}

viewAlert('작가 정보가 등록되었습니다.');
echo ('<meta http-equiv="refresh" content="0 url=../artist.php" />');
mysqli_close($conn);
flush();

?>

