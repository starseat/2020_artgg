<?php

include('../common.php');
include('../db_conn.php');

$sql  = "SELECT seq FROM artgg_business WHERE type = 'A' LIMIT 1";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$artgg_info = mysqli_fetch_array($result);
$result->free();
$artgg_seq = intval($artgg_info['seq']);

$result_array = array();

$insert_type = mysqli_real_escape_string($conn, $_POST['insert_type']);
$message = '';
if($insert_type == 'text') {
    $artgg_introduction = mysqli_real_escape_string($conn, $_POST['artgg_introduction']);
    $sql  = "UPDATE artgg_business SET introduction = '" . $artgg_introduction . "' WHERE seq = $artgg_seq";
    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
    $message = '아트경기 소개글이 적용되었습니다.';
} // end of if($insert_type == 'text')
else if($insert_type == 'image') {
    $artgg_images = $_FILES['artgg_images']; // var_dump($artist_image1);
    if ($artgg_images == null) {
        viewAlert('추가된 이미지가 없습니다.');
        mysqli_close($conn);
        flush();
        echo ('<meta http-equiv="refresh" content="0 url=../business.artgg.php" />');
        exit;
    }
    $artgg_images_upload_info_list = uploadImages($artgg_images, 'business'); // var_dump($artgg_images_upload_info_list);
    if ($artgg_images_upload_info_list == null) {
        viewAlert('이미지 등록에 실패하였습니다.');
        mysqli_close($conn);
        flush();
        echo ('<meta http-equiv="refresh" content="0 url=../business.artgg.php" />');
        exit;
    }

    $upload_count = count($artgg_images_upload_info_list);
    for($i=0; $i<$upload_count; $i++) {
        $sql  = "INSERT INTO artgg_image (target_type, target_seq, sort, file_name, file_name_save, upload_path) ";
        $sql .= "VALUES ( 'business', $artgg_seq, (select IFNULL(max(sort_temp.sort) + 1, 1) as next_sort from artgg_image sort_temp where sort_temp.target_seq = $artgg_seq AND sort_temp.target_type = 'business'), ";
        $sql .= "'" . mysqli_real_escape_string($conn, $artgg_images_upload_info_list[$i]['file_name']) . "', ";
        $sql .= "'" . mysqli_real_escape_string($conn, $artgg_images_upload_info_list[$i]['file_save_name']) . "', ";
        $sql .= "'" . mysqli_real_escape_string($conn, $artgg_images_upload_info_list[$i]['upload_file_path']) . "') ";

        $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
    }

    $message = '아트경기 이미지가 등록되었습니다.';
} // end of else if($insert_type == 'image')
else if ($insert_type == 'video') {
    $artgg_link = mysqli_real_escape_string($conn, $_POST['artgg_link']);
    $youtube_id = mysqli_real_escape_string($conn, $_POST['artgg_link_youtube_id']);

    $sql  = "INSERT INTO artgg_image (target_type, target_seq, sort, storage_type, image_type, file_name, file_name_save, upload_path) ";
    $sql .= "VALUES ( 'business', $artgg_seq, (select IFNULL(max(sort_temp.sort) + 1, 1) as next_sort from artgg_image sort_temp where sort_temp.target_seq = $artgg_seq AND sort_temp.target_type = 'business'), ";
    $sql .= "'W', 'V', ";
    $sql .= "'" . $youtube_id . "', ";
    $sql .= "'', ";
    $sql .= "'" . $artgg_link . "') ";
    
    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

    $message = '아트경기 Youtube 링크가 등록되었습니다.';
} // end of else if ($insert_type == 'video')

mysqli_close($conn);
flush();

viewAlert($message);
echo ('<meta http-equiv="refresh" content="0 url=../business.artgg.php" />');

?>

