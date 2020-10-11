<?php

// 로그인 체크
include('./login_check.php');

include('../common.php');
include('../db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$seq = intval(mysqli_real_escape_string($conn, $_POST['seq']));
$year = mysqli_real_escape_string($conn, $_POST['year']);
$name = 'artist_greeting'; 
$introduction = mysqli_real_escape_string($conn, $_POST['greeting']);

$result_array = array();
$message = '';

// update
if($seq > 0) {
    $sql  = "UPDATE artgg_artist SET ";
    $sql .= "year = '" . $year . "', ";
    $sql .= "introduction = '" . $introduction . "' ";
    $sql .= "WHERE seq = " . $seq;

    $message = '작가 소개글이 수정되었습니다.';
}
// insert
else {
    $sql  = "INSERT INTO artgg_artist (year, name, introduction) ";
    $sql .= "VALUES (";
    $sql .= "'" . $year . "', ";
    $sql .= "'" . $name . "', ";
    $sql .= "'" . $introduction . "') ";

    $message = '작가 소개글이 등록되었습니다.';

    //$seq = mysqli_insert_id($conn);
    $seq = $conn->insert_id;
}

$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

mysqli_close($conn);
flush();

$result_array['message'] = $message;
$result_array['result'] = 1;
$result_array['seq'] = $seq;

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>

    