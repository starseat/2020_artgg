<?php

// 로그인 체크
include('./login_check.php');

include('../common.php');
include('../db_conn.php');

header('Content-Type: text/html; charset=UTF-8');

$startDate = $_GET['start'];
$endDate = $_GET['end'];

$sql  = "
    SELECT main.date as MainView, main.count as MainCount, IFNULL(viewing.date, main.date) as ViewingRoomView, IFNULL(viewing.count, 0) ViewingRoomCount FROM 
    (
        SELECT main_temp.date, main_temp.count FROM artgg_visit main_temp WHERE type = 'main' AND main_temp.date  BETWEEN '" . $startDate . "' AND '" . $endDate . "'
    ) main left outer join
    (
        SELECT viewing_temp.date, viewing_temp.count FROM artgg_visit viewing_temp WHERE type = 'viewingroom' AND viewing_temp.date  BETWEEN '" . $startDate . "' AND '" . $endDate . "'
    ) viewing 
    on main.date = viewing.date order by main.date
";

$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$excel_data_count = $result->num_rows;

$result_array = array();
if ($excel_data_count > 0) {

    $excel_data_list = array();
    while($row = $result->fetch_array()) {
        array_push($excel_data_list, [
            'MainView' => $row['MainView'],
            'MainCount' => $row['MainCount'],
            'ViewingRoomView' => $row['ViewingRoomView'],
            'ViewingRoomCount' => $row['ViewingRoomCount']
        ]);
    }

    $result_array['visit_excel_data'] = $excel_data_list;
} else {
    $result_array['visit_excel_data'] = array();
}

$result->free();

mysqli_close($conn);
flush();

echo json_encode($result_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
