<?php require_once('fragment/content_layout.php'); ?>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<link href="vendor/image-uploader/dist/image-uploader.min.css" type="text/css" rel="stylesheet">
<style>
    .form-input-title-box {
        margin-left: 0;
    }

    .artist_image_caption_box {
        margin-top: 1rem;
    }

    .artist_image_caption {
        width: 100%;
    }

    .artist_image_caption_label {
        padding-top: 0.6rem;
    }
</style>
<h1 class="mt-4">작가 정보</h1>

<div class="card mt-4 mb-4">
    <div class="card-body">
        <form id="editArtistForm" name="editArtistForm" method="post" action="./action/artist_submit.php" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="artist_name"><strong>작가명</strong></label>
                    <input type="text" class="form-control" id="artist_name" name="artist_name">
                </div>
                <div class="form-group col-md-4">
                    <label for="artist_name_en"><strong>작가명 (영문)</strong></label>
                    <input type="text" class="form-control" id="artist_name_en" name="artist_name_en">
                </div>
                <div class="form-group col-md-4">
                    <label for="artist_year"><strong>년도</strong></label>
                    <input type="number" class="form-control" id="artist_year" name="artist_year">
                </div>
            </div>
            <hr>
            <div class="form-group">
                <label for="artist_thumbnail" id="artist_thumbnail_label"><strong>썸네일</strong></label>
                <div id="artist_thumbnail"></div>
            </div>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="artist_image1"><strong>대표 이미지 1</strong></label>
                    <div id="artist_image1"></div>
                    <div class="row artist_image_caption_box">
                        <div class="col-2"><label for="artist_image1_caption" id="artist_image1_caption" class="artist_image_caption_label">캡션</label></div>
                        <div class="col-10"><input type="text" id="artist_image1_caption" class="form-control artist_image_caption"></div>
                    </div>
                </div>
                <div class="form-group col-md-1"></div>
                <div class="form-group col-md-5">
                    <label for="artist_image2"><strong>대표 이미지 2</strong></label>
                    <div id="artist_image2"></div>
                    <div class="row artist_image_caption_box">
                        <div class="col-2"><label for="artist_image2_caption" id="artist_image2_caption" class="artist_image_caption_label">캡션</label></div>
                        <div class="col-10"><input type="text" id="artist_image2_caption" class="form-control artist_image_caption"></div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="artist_image3"><strong>대표 이미지 3</strong></label>
                    <div id="artist_image3"></div>
                    <div class="row artist_image_caption_box">
                        <div class="col-2"><label for="artist_image3_caption" id="artist_image3_caption" class="artist_image_caption_label">캡션</label></div>
                        <div class="col-10"><input type="text" id="artist_image3_caption" class="form-control artist_image_caption"></div>
                    </div>
                </div>
                <div class="form-group col-md-1"></div>
                <div class="form-group col-md-5">
                    <label for="artist_image4"><strong>대표 이미지 4</strong></label>
                    <div id="artist_image4"></div>
                    <div class="row artist_image_caption_box">
                        <div class="col-2"><label for="artist_image4_caption" id="artist_image4_caption" class="artist_image_caption_label">캡션</label></div>
                        <div class="col-10"><input type="text" id="artist_image4_caption" class="form-control artist_image_caption"></div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="form-row form-input-title-box"><label for="artist_introduction"><strong>작가 소개</strong></label></div>
                <div id="artist_introduction" class="form-control"></div>
            </div>
            <hr>
            <div class="form-group">
                <div class="form-row form-input-title-box"><label for="artist_academic"><strong>학력</strong></label></div>
                <div id="artist_academic" class="form-control"></div>
            </div>
            <hr>
            <div class="form-group">
                <div class="form-row form-input-title-box"><label for="artist_individual_exhibition"><strong>주요 개인전</strong></label></div>
                <div id="artist_individual_exhibition" class="form-control"></div>
            </div>
            <hr>
            <div class="form-group">
                <div class="form-row form-input-title-box"><label for="artist_team_competition"><strong>주요 단체전</strong></label></div>
                <div id="artist_team_competition" class="form-control"></div>
            </div>
            <hr>
            <div class="form-group">
                <div class="form-row form-input-title-box"><label for="artist_interview"><strong>작가 인터뷰</strong></label></div>
                <div id="artist_interview" class="form-control"></div>
            </div>
        </form>
    </div>
</div>



<?php require_once('fragment/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ko-KR.js"></script>
<script src="vendor/image-uploader/dist/image-uploader.min.js"></script>
<script src="./js/artist.js"></script>

<?php require_once('fragment/tail.php'); ?>