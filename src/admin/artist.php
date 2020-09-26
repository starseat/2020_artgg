<?php require_once('fragment/content_layout.php'); ?>

<?php

include('common.php');
include('db_conn.php');

// $isLogin = $_SESSION['is_login'];
// if ($isLogin != 1) {
//     echo ('<meta http-equiv="refresh" content="0 url=./login.html" />');
// }

$sql  = "SELECT distinct year FROM artgg_artist where name != 'artist_greeting' ORDER BY year desc";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$year_length = $result->num_rows;

?>

<h1 class="mt-4">Artist</h1>
<style>
    .insert-button-box {
        position: fixed;
        top: 5.6rem;
        right: 1.8rem;
    }
</style>
<div class="insert-button-box">
    <button type="button" class="btn btn-info" onclick="javascript: location.href='./artist_write.php';">등록</button>
</div>

<div class="row">
    <div class="d-none d-md-inline-block ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <select class="form-control" id="artist_select_year" style="width: 240px;">
        <?php
        if($year_length > 0) {
            echo ('<option value="0">전체</option>');
            while ($year_row = $result->fetch_array()) {
                echo ('<option value="' . RemoveXSS($year_row['year']) .'">' . RemoveXSS($year_row['year']) . '</option>');
            }
        }
        else {
            echo ('<option value="0">없음</option>');
        }
        $result->free();
        ?>
        </select>
    </div>
</div>

<br>

<div class="mt-4 mb-4 container">
    <div class="row">

        <?php
        $sql = "SELECT seq, year, name, en_name, thumbnail FROM artgg_artist ORDER BY name";
        $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
        $artist_length = $result->num_rows;

        if ($artist_length > 0) {
            while ($artist_info = $result->fetch_array()) {
                echo ('<div class="col-sm-4 col-md-3 col-lg-2">');
                echo ('    <div class="card" style="width: 18rem;">');
                echo ('        <img src="' . RemoveXSS($artist_info['thumbnail']) . '" class="card-img-top" alt="thumbnail">');
                echo ('        <div class="card-body">');
                echo ('            <h5 class="card-title">' . RemoveXSS($artist_info['name']) . '</h5>');
                echo ('            <p class="card-text">' . RemoveXSS($artist_info['en_name']) . '</p>');
                echo ('            <div class="row">');
                echo ('                <div class="col-6"><button class="btn btn-primary w-100" onclick="doUpdate(' . RemoveXSS($artist_info['seq']) . ')">수정</button></div>');
                echo ('                <div class="col-6"><button class="btn btn-danger w-100" onclick="doDelete(' . RemoveXSS($artist_info['seq']) . ')">삭제</button></div>');
                echo ('            </div>');
                echo ('        </div>');
                echo ('    </div>');
                echo ('</div>');
            }
        } else {
            echo ('<div class="d-none d-md-inline-block" style="margin: 8rem auto;">등록된 작가 정보가 없습니다.</div>');
        }
        $result->free();
        ?>

    </div>
</div>

<?php require_once('fragment/footer.php'); ?>

<script src="./js/artist.js"></script>

<?php require_once('fragment/tail.php'); ?>