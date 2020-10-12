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

// 프로그램 리스트 조회
$sql = "SELECT seq, year, name, thumbnail, program_date, place FROM artgg_program ";
if($year > 0) {
    $sql .= " WHERE year = $year ";
}
$sql .= " ORDER BY year DESC, name ASC ";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$program_length = $result->num_rows;
$program_list = array();

if ($program_length > 0) {    
    while ($row = $result->fetch_array()) {
        array_push($program_list, [
            'seq' => $row['seq'],
            'year' => $row['year'],
            'name' => $row['name'],
            'thumbnail' => getImagePath($row['thumbnail']),
            'program_date' => $row['program_date'],
            'place' => $row['place']
        ]);
    }
}

$result->free();

$result_array['program_list'] = $program_list;
$result_array['result'] = 1;

mysqli_close($conn);
flush();

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
