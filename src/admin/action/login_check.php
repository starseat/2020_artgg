<?php

session_start();

header('Content-Type: text/html; charset=UTF-8');

//var_dump($_SESSION['is_login']);
if (!isset($_SESSION['is_login']) || empty($_SESSION['is_login'])) {
    echo ("<script>alert('로그인정보가 없습니다. 로그인이 페이지로 이동합니다.');</script>");
    echo ('<meta http-equiv="refresh" content="0 url=./login.html" />');
    exit;
} else if ($_SESSION['is_login'] != 1) {
    echo ("<script>alert('로그인이 필요합니다. 로그인이 페이지로 이동합니다.');</script>");
    echo ('<meta http-equiv="refresh" content="0 url=./login.html" />');
    exit;
}

?>
