<?php

include('../common.php');
include('../db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$result_array = array();

$artist_year = $_GET['year'];
if ($artist_year != 0 && (isEmpty($artist_year) || !is_numeric($artist_year))) {
    viewAlert('잘못된 접근 입니다.');
    mysqli_close($conn);
    flush();
    //historyBack();
    //echo ('<meta http-equiv="refresh" content="0 url=../artist.php" />');
    $result_array['result'] = 0;
    echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

$artist_year = intval(mysqli_real_escape_string($conn, $artist_year));
$sql = "SELECT seq, year, name, en_name, thumbnail FROM artgg_artist ";
if($artist_year > 0) {
    $sql .= " WHERE year = $artist_year ";
}
$sql .= " ORDER BY name";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$artist_length = $result->num_rows;

$result_array = array();
$artist_list = array();

if ($artist_length > 0) {    
    while ($row = $result->fetch_array()) {
        array_push($artist_list, [
            'seq' => $row['seq'],
            'year' => $row['year'],
            'name' => $row['name'],
            'en_name' => $row['en_name'],
            'thumbnail' => $row['thumbnail']
        ]);
    }
}


$result->free();

$result_array['result'] = 1;
$result_array['artist_list'] = $artist_list;

mysqli_close($conn);
flush();

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
