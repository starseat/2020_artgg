<?php

include('../common.php');
include('../db_conn.php');

$seq = intval(mysqli_real_escape_string($conn, $_POST['seq']));

$message = '';
$result_array = array();

// update
if($seq > 0) {
    $sql  = "DELETE FROM artgg_artist ";
    $sql .= "WHERE seq = " . $seq;

    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
    $result_array['result'] = 1;
    $message = '작가 소개글이 삭제되었습니다.';
}
// insert
else {
    $result_array['result'] = 0;

    $message = '등록된 글만 삭제할 수 있습니다.';
}

mysqli_close($conn);
flush();

$result_array['message'] = $message;
echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>

    