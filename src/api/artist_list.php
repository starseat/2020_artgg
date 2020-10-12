<?php

include('../common.php');
include('../db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$result_array = array();

$year = 0;
$is_access = false;
if ($_SERVER['QUERY_STRING'] != '') {
    $year = $_GET['year'];
    if (isEmpty($year) || !is_numeric($year)) {
        $year = 0;
    }
}

$year = intval(mysqli_real_escape_string($conn, $year));

// 인사말 조회
$sql = "SELECT seq, year, introduction FROM artgg_artist WHERE name = 'artist_greeting' ";
if ($year > 0) {
    $sql .= " AND year = $year ";
}
else {
    $sql .= " AND year = (SELECT max(year) FROM artgg_artist) ";
}

$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$greeting_length = $result->num_rows;
if($greeting_length > 0) {
    $greeting_info = $result->fetch_array();
    $result_array['greeting'] = [
        'year' => $greeting_info['year'],
        'introduction' => $greeting_info['introduction']
    ];
}
else {
    $result_array['greeting'] = [
        'year' => 0,
        'introduction' => ''
    ];
}

$result->free();

// 작가 리스트 조회
$sql = "SELECT seq, year, name, en_name, thumbnail FROM artgg_artist WHERE name != 'artist_greeting' ";
if($year > 0) {
    $sql .= " AND year = $year ";
}
$sql .= " ORDER BY name";

$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$artist_length = $result->num_rows;
$artist_list = array();

if ($artist_length > 0) {    
    while ($row = $result->fetch_array()) {
        array_push($artist_list, [
            'seq' => $row['seq'],
            'year' => $row['year'],
            'name' => $row['name'],
            'en_name' => $row['en_name'],
            'thumbnail' => getImagePath($row['thumbnail'])
        ]);
    }
}

$result->free();

$result_array['artist_list'] = $artist_list;
$result_array['result'] = 1;

mysqli_close($conn);
flush();

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
