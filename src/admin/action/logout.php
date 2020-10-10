<?php

session_start();

header('Content-Type: text/html; charset=UTF-8');

$_SESSION['is_login'] = 0;

session_unset();
session_destroy();

// echo json_encode(1, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

echo ("<script>alert('로그아웃되었습니다.');</script>");
echo ('<meta http-equiv="refresh" content="0 url=../../index.php" />');

?>
