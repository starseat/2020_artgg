<?php
session_start();

$_SESSION['is_login'] = 0;

session_unset();
session_destroy();

echo json_encode(1, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
?>
