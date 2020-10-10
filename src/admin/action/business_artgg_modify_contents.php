<?php

include('../common.php');
include('../db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$content_list = $_POST['artgg_content_list'];
// var_dump($content_list);

$result_array = array();
if(isEmpty($content_list)) {
    $result_array['result'] = 0;
    $result_array['message'] = '잘못된 컨텐츠 정보 입니다.';
    mysqli_close($conn);
    echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

$content_count = count($content_list);
if($content_count == 0) {
    $result_array['result'] = 0;
    $result_array['message'] = '변경될 컨텐츠 정보가 없습니다.';
    mysqli_close($conn);
    echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

for($i=0; $i<$content_count; $i++) {
    $sql  = "UPDATE artgg_image SET sort = " . $content_list[$i]['sort'] . " WHERE seq = " . $content_list[$i]['seq'];
    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
}

mysqli_close($conn);
flush();

$result_array['message'] = '컨텐츠 정보가 수정되었습니다.';
$result_array['result'] = 1;

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
