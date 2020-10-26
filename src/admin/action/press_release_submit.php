<?php

// 로그인 체크
include('./login_check.php');

include('../common.php');
include('../db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

////////// press_release.php.bak 용
// $action = mysqli_real_escape_string($conn, $_POST['press_release_submit_action']);
// $seq = intval(mysqli_real_escape_string($conn, $_POST['press_release_seq']));

// $result_array = array();
// $message = '';

// $sql = '';
// if($action == 'delete') {
//     $sql  = "DELETE FROM artgg_press_release WHERE seq = $seq";

//     $message = '보도자료 정보가 삭제되었습니다.';
// }
// else {

//     $title = mysqli_real_escape_string($conn, $_POST['press_release_title']);
//     $link = mysqli_real_escape_string($conn, $_POST['press_release_link']);

//     // update
//     //if ($seq > 0) {
//     if($action == 'update') {
//         $sql  = "UPDATE artgg_press_release SET ";
//         $sql .= "title = '" . $title . "', ";
//         $sql .= "link = '" . $link . "' ";
//         $sql .= "WHERE seq = " . $seq;

//         $message = '보도자료 정보가 수정되었습니다.';
//     }
//     // insert
//     else {
//         $sql  = "INSERT INTO artgg_press_release (title, link) ";
//         $sql .= "VALUES (";
//         $sql .= "'" . $title . "', ";
//         $sql .= "'" . $link . "') ";

//         $message = '보도자료 정보가 등록되었습니다.';
//     }
// }
////////// press_release.php.bak 용

$press_release_seq = intval(mysqli_real_escape_string($conn, $_POST['seq']));
$press_release_title = mysqli_real_escape_string($conn, $_POST['title']);
$press_release_link = mysqli_real_escape_string($conn, $_POST['link']);
$press_release_news_date = mysqli_real_escape_string($conn, $_POST['news_date']);
$press_release_news_media = mysqli_real_escape_string($conn, $_POST['news_media']);
$press_release_news_author = mysqli_real_escape_string($conn, $_POST['news_author']);
$press_release_contents = mysqli_real_escape_string($conn, $_POST['contents']);

$sql = '';
$message = '';

// update
if ($press_release_seq > 0) {
    $sql  = "UPDATE artgg_press_release SET ";
    $sql .= "title = '" . $press_release_title . "', ";
    $sql .= "link = '" . $press_release_link . "', ";
    $sql .= "news_date = '" . $press_release_news_date . "', ";
    $sql .= "news_media = '" . $press_release_news_media . "', ";
    $sql .= "news_author = '" . $press_release_news_author . "', ";
    $sql .= "contents = '" . $press_release_contents . "', ";
    $sql .= "updated_at = now() ";
    $sql .= "WHERE seq = " . $press_release_seq;

    $message = '보도자료글이 수정되었습니다.';
}
// insert
else {
    $sql  = "INSERT INTO artgg_press_release (title, link, news_date, news_media, news_author, contents) ";
    $sql .= "VALUES ( ";
    $sql .= "'" . $press_release_title . "', ";
    $sql .= "'" . $press_release_link . "', ";
    $sql .= "'" . $press_release_news_date . "', ";
    $sql .= "'" . $press_release_news_media . "', ";
    $sql .= "'" . $press_release_news_author . "', ";
    $sql .= "'" . $press_release_contents . "') ";

    $message = '공지사항이 등록되었습니다.';
}

$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

mysqli_close($conn);
flush();

$result_array['message'] = $message;
$result_array['result'] = 1;

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>

    