<?php require_once('fragment/content_layout.php'); ?>

<?php

include('common.php');
include('db_conn.php');

// $isLogin = $_SESSION['is_login'];
// if ($isLogin != 1) {
//     echo ('<meta http-equiv="refresh" content="0 url=./login.html" />');
// }

$sql  = "SELECT distinct year FROM artgg_program ORDER BY year desc";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$year_length = $result->num_rows;

?>

<h1 class="mt-4">아트경기 프로그램</h1>
<style>
    .insert-button-box {
        position: fixed;
        top: 5.6rem;
        right: 1.8rem;
    }

    .artgg-border-top { border-top: solid; }
</style>
<div class="insert-button-box">
    <button type="button" class="btn btn-info" onclick="javascript: location.href='./program_write.php';">등록</button>
</div>

<div class="row">
    <div class="d-none d-md-inline-block ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <select class="form-control" id="select_year" style="width: 240px;">
            <?php
            if ($year_length > 0) {
                echo ('<option value="0">전체</option>');
                while ($year_row = $result->fetch_array()) {
                    echo ('<option value="' . RemoveXSS($year_row['year']) . '">' . RemoveXSS($year_row['year']) . '</option>');
                }
            } else {
                echo ('<option value="0">없음</option>');
            }
            $result->free();
            ?>
        </select>
    </div>
</div>

<br>

<div class="mt-4 mb-4 container">
    <div class="row" id="program-list-box">

        <?php
        $sql = "SELECT seq, year, name, thumbnail, program_date, place FROM artgg_program ORDER BY name";
        $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
        $program_length = $result->num_rows;

        if ($program_length > 0) {
            while ($row = $result->fetch_array()) {
                echo ('<div class="col-sm-4 col-md-3">');
                echo ('    <div class="card">');
                echo ('        <img src="' . RemoveXSS($row['thumbnail']) . '" class="card-img-top" alt="thumbnail" width="220" height="220">');
                echo ('        <div class="card-body artgg-border-top">');
                echo ('            <h5 class="card-title">' . RemoveXSS($row['name']) . '</h5>');
                echo ('            <p class="card-text">' . RemoveXSS($row['program_date']) . '</p>');
                echo ('            <p class="card-text">' . RemoveXSS($row['place']) . '</p>');
                echo ('            <div class="row">');
                echo ('                <div class="col-6"><button class="btn btn-primary w-100" onclick="doUpdate(' . RemoveXSS($row['seq']) . ')">수정</button></div>');
                echo ('                <div class="col-6"><button class="btn btn-danger w-100" onclick="doDelete(' . RemoveXSS($row['seq']) . ')">삭제</button></div>');
                echo ('            </div>');
                echo ('        </div>');
                echo ('    </div>');
                echo ('</div>');
            }
        } else {
            echo ('<div class="d-none d-md-inline-block" style="margin: 8rem auto;">등록된 아트경기 프로그램 정보가 없습니다.</div>');
        }
        $result->free();
        ?>

    </div>
</div>

<?php
mysqli_close($conn);
flush();
?>
<?php require_once('fragment/footer.php'); ?>

<script src="./js/program.js"></script>

<?php require_once('fragment/tail.php'); ?>