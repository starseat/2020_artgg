<?php

include('../common.php');
include('../db_conn.php');

$seq = mysqli_real_escape_string($conn, $_POST['seq']);
$caption = mysqli_real_escape_string($conn, $_POST['caaption']);
$link = mysqli_real_escape_string($conn, $_POST['link']);
$sort = mysqli_real_escape_string($conn, $_POST['sort']);

// db - delete
$sql  = "UPDATE artgg_image SET ";
$sql .= "caption = '" . $caption . "', ";
$sql .= "link = '" . $link . "', ";
$sql .= "sort = " . $sort . " ";
$sql .= "WHERE seq = " . $seq;
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

mysqli_close($conn);
flush();

echo json_encode(1, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>
