<?php

include('../common.php');
include('../db_conn.php');

$result_array = array();

$program_year = $_GET['year'];
if ($program_year != 0 && (isEmpty($program_year) || !is_numeric($program_year))) {
    viewAlert('잘못된 접근 입니다.');
    mysqli_close($conn);
    flush();
    //historyBack();
    $result_array['result'] = 0;
    echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

$program_year = intval(mysqli_real_escape_string($conn, $program_year));
$sql = "SELECT seq, year, name, thumbnail, program_date, place FROM artgg_program ";
if($program_year > 0) {
    $sql .= " WHERE year = $program_year ";
}
$sql .= " ORDER BY name";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$program_length = $result->num_rows;

$result_array = array();
$program_list = array();

if ($program_length > 0) {    
    while ($row = $result->fetch_array()) {
        array_push($program_list, [
            'seq' => $row['seq'],
            'year' => $row['year'],
            'name' => $row['name'],
            'program_date' => $row['program_date'],
            'place' => $row['place'],
            'thumbnail' => $row['thumbnail']
        ]);
    }
}


$result->free();

$result_array['result'] = 1;
$result_array['program_list'] = $program_list;

mysqli_close($conn);
flush();

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
