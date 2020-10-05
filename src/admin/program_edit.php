<?php require_once('fragment/content_layout.php'); ?>

<?php

include('common.php');

// $isLogin = $_SESSION['is_login'];
// if ($isLogin != 1) {
//     echo ('<meta http-equiv="refresh" content="0 url=./login.html" />');
// }

?>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<link href="vendor/image-uploader/dist/image-uploader.min.css" type="text/css" rel="stylesheet">
<style>
    .form-input-title-box {
        margin-left: 0;
    }

    .program_textarea {
        display: none;
    }
</style>
<h1 class="mt-4">협력사업자 정보</h1>

<div class="card mt-4 mb-4">
    <div class="card-body">
        <form id="updateProgramForm" name="updateProgramForm" method="post" action="./action/program_update.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="program_name"><strong>* 프로그램 명</strong></label>
                <input type="text" class="form-control" id="program_name" name="program_name">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="program_year"><strong>* 년도</strong></label>
                    <input type="number" class="form-control" id="program_year" name="program_year">
                </div>
                <div class="form-group col-md-6">
                    <label for="program_date"><strong>* 일자</strong></label>
                    <input type="text" class="form-control" id="program_date" name="program_date">
                </div>
            </div>
            <div class="form-group">
                <label for="program_place"><strong>* 장소</strong></label>
                <input type="text" class="form-control" id="program_place" name="program_place">
            </div>
            <hr>
            <div class="form-group">
                <div class="row">
                    <div class="col-4"><label for="program_thumbnail" id="program_thumbnail_label"><strong>* 썸네일</strong></label></div>
                    <div class="col"></div>
                    <div class="col-2 text-right"><button class="btn btn-outline-danger" id="program_thumbnail_delete_btn" onclick="doDeleteImage(event, 0)">삭제</button></div>
                </div>
                <div id="program_thumbnail"></div>
                <div class="row ml-4"><img id="program_thumbnail_saved" src="#" width="auto" height="160" /></div>
                <input type="hidden" id="program_thumbnail_new" name="program_thumbnail_new" value=" 0" />
            </div>
            <hr>
            <div class="form-group">
                <div class="row">
                    <div class="col-4"><label for="program_image" id="program_image_label"><strong>* 대표 이미지</strong></label></div>
                    <div class="col"></div>
                    <div class="col-2 text-right"><button class="btn btn-outline-danger" id="program_image_delete_btn" onclick="doDeleteImage(event, 1)">삭제</button></div>
                </div>
                <div id="program_image"></div>
                <div class="row m-2 text-center">
                    <img id="program_image_saved" src="#" width="auto" height="160" />
                    <input type="hidden" id="program_image_saved_seq" name="program_image_saved_seq" value="0" />
                    <input type="hidden" id="program_image_new" name="program_image_new" value=" 0" />
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="form-row form-input-title-box"><label for="program_introduction_textform"><strong>프로그램 소개</strong></label></div>
                <div id="program_introduction_textform" class="form-control"></div>
                <textarea class="program_textarea" id="program_introduction" name="program_introduction"></textarea>
            </div>
            <hr>
            <div class="form-group">
                <div class="form-row form-input-title-box"><label for="program_schedule_textform"><strong>스케쥴</strong></label></div>
                <div id="program_schedule_textform" class="form-control"></div>
                <textarea class="program_textarea" id="program_schedule" name="program_schedule"></textarea>
            </div>
            <hr>
            <div class="form-group">
                <div class="form-row form-input-title-box"><label for="program_event_textform"><strong>이벤트</strong></label></div>
                <div id="program_event_textform" class="form-control"></div>
                <textarea class="program_textarea" id="program_event" name="program_event"></textarea>
            </div>
            <hr>
            <div class="form-group">
                <p style="color: red;">파일 등록, 지도 등록 기능 추가 예정입니다.</p>
            </div>
            <hr>
            <input type="hidden" id="program_seq" name="program_seq" value="0" />
            <div class="row">
                <div class="col-12 text-right">
                    <button class="btn btn-danger" onclick="doDelete(event)">삭제</button>
                    <button class="btn btn-primary" onclick="doUpdate(event)">수정</button>
                </div>
            </div>
        </form>
    </div>
</div>



<?php require_once('fragment/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ko-KR.js"></script>
<script src="vendor/image-uploader/dist/image-uploader.min.js"></script>

<script src="./js/common.js"></script>
<script src="./js/program.edit.js"></script>

<?php require_once('fragment/tail.php'); ?>