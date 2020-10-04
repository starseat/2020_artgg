<?php require_once('fragment/content_layout.php'); ?>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<link href="vendor/image-uploader/dist/image-uploader.min.css" type="text/css" rel="stylesheet">
<style>
    .form-input-title-box {
        margin-left: 0;
    }

    #partner_introduction {
        display: none;
    }
</style>
<h1 class="mt-4">협력사업자 정보</h1>

<div class="card mt-4 mb-4">
    <div class="card-body">
        <form id="insertPartnerForm" name="insertPartnerForm" method="post" action="./action/business_partner_insert.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="partner_name"><strong>* 협력사업자명</strong></label>
                <input type="text" class="form-control" id="partner_name" name="partner_name" placeholder="협력사업자명을 입력해 주세요.">
            </div>
            <hr>
            <div class="form-group">
                <label for="partner_thumbnail" id="partner_thumbnail_label"><strong>* 썸네일</strong></label>
                <div id="partner_thumbnail"></div>
            </div>
            <hr>
            <div class="form-group">
                <label for="partner_image" id="partner_image_label"><strong>* 대표 이미지</strong></label>
                <div id="partner_image"></div>
            </div>
            <hr>
            <div class="form-group">
                <div class="form-row form-input-title-box"><label for="partner_introduction_textform"><strong>* 협력사업자 소개</strong></label></div>
                <div id="partner_introduction_textform" class="form-control"></div>
                <textarea id="partner_introduction" name="partner_introduction"></textarea>
            </div>
            <div class="row">
                <div class="col-12 text-right">
                    <button class="btn btn-primary" onclick="doInsert(event)">등록</button>
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
<script src="./js/business.partner.write.js"></script>

<?php require_once('fragment/tail.php'); ?>