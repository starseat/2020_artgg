<?php

include('../common.php');
include('../db_conn.php');

$param_year = mysqli_real_escape_string($conn, $_GET['year']);
$result_array = array();

$sql  = "SELECT distinct year FROM artgg_artist where name = 'artist_greeting' ORDER BY year desc";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$year_count = $result->num_rows;

if($year_count > 0) {
    $year_array = array();
    while ($row = $result->fetch_array()) {
        array_push($year_array, ['year' => $row['year']] );
    }
    $result_array['year_list'] = $year_array;
    $result->free();
    
    $sql = "SELECT seq, year, introduction FROM artgg_artist WHERE ";
    
    if(isEmpty($param_year) || $param_year == '0') {
        $last_year = $result_array['year_list'][0]['year'];
        $sql .= "year = '" . $last_year . "'";
    }
    else {
        $sql .= "year = '" . $param_year . "'";
    }
    
    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
    $result_array['artist_greeting'] = $result->fetch_array();
    $result->free();
}
else {
    $result_array['year_list'] = array();
    $result->free();
}

mysqli_close($conn);
flush();

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>

    