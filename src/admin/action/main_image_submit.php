<?php

include('../common.php');
include('../db_conn.php');

$result_array = array();

$insert_type = mysqli_real_escape_string($conn, $_POST['insert_type']);
$message = '';

if($insert_type == 'image') {
    $main_images = $_FILES['main_images']; // var_dump($artist_image1);
    if ($main_images == null) {
        viewAlert('추가된 이미지가 없습니다.');
        mysqli_close($conn);
        flush();
        echo ('<meta http-equiv="refresh" content="0 url=../main.php" />');
        exit;
    }
    $main_images_upload_info_list = uploadImages($main_images, 'main'); // var_dump($main_images_upload_info_list);
    if ($main_images_upload_info_list == null) {
        viewAlert('이미지 등록에 실패하였습니다.');
        mysqli_close($conn);
        flush();
        echo ('<meta http-equiv="refresh" content="0 url=../main.php" />');
        exit;
    }

    $upload_count = count($main_images_upload_info_list);
    for($i=0; $i<$upload_count; $i++) {
        $sql  = "INSERT INTO artgg_image (target_type, target_seq, sort, file_name, file_name_save, upload_path) ";
        $sql .= "VALUES ( 'main', 0, (select IFNULL(max(sort_temp.sort) + 1, 1) as next_sort from artgg_image sort_temp where sort_temp.target_type = 'main'), ";
        $sql .= "'" . mysqli_real_escape_string($conn, $main_images_upload_info_list[$i]['file_name']) . "', ";
        $sql .= "'" . mysqli_real_escape_string($conn, $main_images_upload_info_list[$i]['file_save_name']) . "', ";
        $sql .= "'" . mysqli_real_escape_string($conn, $main_images_upload_info_list[$i]['upload_file_path']) . "') ";

        $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
    }

    $message = '메인 이미지가 등록되었습니다.';
} // end of else if($insert_type == 'image')
else if ($insert_type == 'video') {
    $main_link = mysqli_real_escape_string($conn, $_POST['main_link']);
    $youtube_id = mysqli_real_escape_string($conn, $_POST['main_link_youtube_id']);

    $sql  = "INSERT INTO artgg_image (target_type, target_seq, sort, storage_type, image_type, file_name, file_name_save, upload_path) ";
    $sql .= "VALUES ( 'main', 0, (select IFNULL(max(sort_temp.sort) + 1, 1) as next_sort from artgg_image sort_temp where sort_temp.target_type = 'main'), ";
    $sql .= "'W', 'V', ";
    $sql .= "'" . $youtube_id . "', ";
    $sql .= "'', ";
    $sql .= "'" . $main_link . "') ";
    
    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

    $message = 'Youtube 링크가 등록되었습니다.';
} // end of else if ($insert_type == 'video')

mysqli_close($conn);
flush();

viewAlert($message);
echo ('<meta http-equiv="refresh" content="0 url=../main.php" />');

?>

