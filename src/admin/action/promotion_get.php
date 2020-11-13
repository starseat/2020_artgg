<?php

// 로그인 체크
include('./login_check.php');

include('../common.php');
include('../db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$promotion_seq = $_GET['seq'];
if (isEmpty($promotion_seq) || !is_numeric($promotion_seq)) {
    viewAlert('잘못된 접근 입니다.');
    mysqli_close($conn);
    flush();
    //historyBack();
    echo ('<meta http-equiv="refresh" content="0 url=../promotion.php" />');
}

$promotion_seq = intval(mysqli_real_escape_string($conn, $promotion_seq));

$sql  = "SELECT seq, title, view_count, created_at, updated_at, contents FROM artgg_promotion WHERE seq = $promotion_seq";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$promotion_count = $result->num_rows;
$promotion_info = $result->fetch_array();
$result->free();

$result_array = array();
if ($promotion_count > 0) {
    $result_array['promotion_info'] = $promotion_info;

    $sql  = "SELECT seq, target_seq, sort, file_name, file_name_save, upload_path, created_at ";
    $sql .= "FROM artgg_file WHERE target_type = 'promotion' AND target_seq = " . $promotion_seq;
    $sql .= " ORDER BY sort";
    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

    $file_count = $result->num_rows;

    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
    $promotion_length = $result->num_rows;
    if ($file_count > 0) {
        $file_array = array();
        while ($row = $result->fetch_array()) {
            array_push($file_array, [
                'seq' => $row['seq'],
                'target_seq' => $row['target_seq'],
                'sort' => $row['sort'],
                'file_name' => $row['file_name'],
                'file_name_save' => $row['file_name_save'],
                'upload_path' => $row['upload_path'],
                'created_at' => $row['created_at'], 
            ]);
        }
        $result_array['file_info'] = $file_array;
    } 
    else {
        $result_array['file_info'] = array();
    }
    $result->free();    

} else {
    $result_array['promotion_info'] = array();
    $result_array['file_info'] = array();
}


mysqli_close($conn);
flush();

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
