<?php require_once('fragment/content_layout.php'); ?>

<?php

include('common.php');
include('db_conn.php');

// $isLogin = $_SESSION['is_login'];
// if ($isLogin != 1) {
//     echo ('<meta http-equiv="refresh" content="0 url=./login.html" />');
// }

$sql = "SELECT seq, target_type, sort, path, caption FROM artgg_image WHERE target_type = 'main' ORDER BY sort";
$result = mysqli_query($conn, $sql) or exit(mysql_error());
$main_image_length = $result->num_rows;
$result->free();

?>

<h1 class="mt-4">Main Images</h1>
<div class="row">
    <div class="d-none d-md-inline-block ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#insertModal">추가</button>
    </div>
</div>


<div class="row">
    <div class="m-auto">

        <?php
        if ($main_image_length > 0) {
            while ($main_image = $result->fetch_array()) {
                echo ('<div class="card mt-4 mb-4">');
                echo ('    <div class="card-body">');
                echo ('        <div>');
                echo ('            <img src="' . $main_image['path'] . '" class="img-fluid" alt="Responsive image">');
                echo ('        </div>');
                echo (' ');
                echo ('        <div class="mt-4 mr-2">');
                echo ('            <form>');
                echo ('                <div class="form-group row">');
                echo ('                    <label for="main-img-caption-' . $main_image['seq'] . '" class="col-sm-2 col-form-label">캡션</label>');
                echo ('                    <div class="col-sm-10">');
                echo ('                        <input type="text" class="form-control" id="main-img-caption-' . $main_image['seq'] . '">');
                echo ('                    </div>');
                echo ('                </div>');
                echo ('                <div class="form-group row">');
                echo ('                    <label for="main-img-link-' . $main_image['seq'] . '" class="col-sm-2 col-form-label">링크</label>');
                echo ('                    <div class="col-sm-10">');
                echo ('                        <input type="text" class="form-control" id="main-img-link-' . $main_image['seq'] . '">');
                echo ('                    </div>');
                echo ('                </div>');
                echo ('                <div class="form-group row">');
                echo ('                    <label for="main-img-sort-' . $main_image['seq'] . '" class="col-sm-2 col-form-label">순서</label>');
                echo ('                    <div class="col-sm-10">');
                echo ('                        <input type="number" class="form-control" id="main-img-sort-' . $main_image['seq'] . '">');
                echo ('                    </div>');
                echo ('                </div>');
                echo ('            </form>');
                echo ('        </div>');
                echo (' ');
                echo ('        <div style="text-align: right;">');
                echo ('            <button type="button" class="btn btn-primary">수정</button>');
                echo ('            <button type="button" class="btn btn-danger" onclick="doDelete(' . $main_image['seq'] . ');>삭제</button>');
                echo ('        </div>');
                echo ('    </div>');
                echo ('</div>');
            }
        } else {
            echo ('<div class="d-none d-md-inline-block" style="margin: 8rem auto;">등록된 이미지가 없습니다.</div>');
        }
        ?>
    </div>

</div>

<div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insertModalLabel">메인 이미지 추가</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row">
                        <label for="insert-main-image" class="col-sm-2 col-form-label">이미지</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control-file" id="insert-main-image">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="insert-caption" class="col-sm-2 col-form-label">캡션</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="insert-caption">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="insert-link" class="col-sm-2 col-form-label">링크</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="insert-link">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                <button type="button" class="btn btn-primary" onclick="doInsert()">추가</button>
            </div>
        </div>
    </div>
</div>

<script>
    function doInsert() {
        alert('doInsert');
    }

    function doDelete(mainImgSeq) {
        alert('[doDelete] seq: ' + mainImgSeq);
    }
</script>
<?php require_once('fragment/footer.php'); ?>
