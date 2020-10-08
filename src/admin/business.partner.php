<?php require_once('fragment/content_layout.php'); ?>

<?php
include('common.php');
include('db_conn.php');
?>

<h1 class="mt-4">협력사업자</h1>
<style>
    .insert-button-box {
        position: fixed;
        top: 8rem;
        right: 1.8rem;
    }

    .artgg-border-top {
        border-top: solid;
    }
</style>
<div class="insert-button-box">
    <button type="button" class="btn btn-info" onclick="javascript: location.href='./business.partner_write.php';">등록</button>
</div>

<br>
<div class="mt-4 mb-4 container">
    <div class="row">

        <?php

        $sql = "SELECT seq, name, type, thumbnail FROM artgg_business WHERE type = 'P' ORDER BY seq";
        $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
        $partner_length = $result->num_rows;

        if ($partner_length > 0) {
            while ($row = $result->fetch_array()) {
                echo ('<div class="col-sm-4 col-md-3">');
                echo ('    <div class="card">');
                echo ('        <img src="' . RemoveXSS($row['thumbnail']) . '" class="card-img-top" alt="thumbnail" width="220" height="220">');
                echo ('        <div class="card-body artgg-border-top">');
                echo ('            <h5 class="card-title">' . RemoveXSS($row['name']) . '</h5>');
                echo ('            <div class="row">');
                echo ('                <div class="col-6"><button class="btn btn-primary w-100" onclick="doUpdate(' . RemoveXSS($row['seq']) . ')">수정</button></div>');
                echo ('                <div class="col-6"><button class="btn btn-danger w-100" onclick="doDelete(' . RemoveXSS($row['seq']) . ')">삭제</button></div>');
                echo ('            </div>');
                echo ('        </div>');
                echo ('    </div>');
                echo ('</div>');
            }
        } else {
            echo ('<div class="d-none d-md-inline-block" style="margin: 8rem auto;">등록된 협력사업자 정보가 없습니다.</div>');
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

<script src="./js/business.partner.js"></script>

<?php require_once('fragment/tail.php'); ?>
