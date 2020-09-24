<?php require_once('fragment/content_layout.php'); ?>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<link href="vendor/image-uploader/dist/image-uploader.min.css" type="text/css" rel="stylesheet">
<style>
    .form-input-title-box {
        margin-left: 0;
    }
</style>
<h1 class="mt-4">작가 정보</h1>

<div class="card mt-4 mb-4">
    <div class="card-body">
        <form id="editArtistForm" name="editArtistForm" method="post" action="./action/artist_submit.php" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="artist_name">작가명</label>
                    <input type="text" class="form-control" id="artist_name" name="artist_name">
                </div>
                <div class="form-group col-md-6">
                    <label for="artist_name_en">작가명 (영문)</label>
                    <input type="text" class="form-control" id="artist_name_en" name="artist_name_en">
                </div>
            </div>
            <div class="form-group">
                <label for="artist_thumbnail" id="artist_thumbnail_label">썸네일</label>
                <div id="artist_thumbnail"></div>
            </div>
            <div class="form-group">
                <label for="artist_image">대표 이미지(최대 4개)</label>
                <div id="artist_image" name="artist_image"></div>
            </div>
            <div class="form-group">
                <div class="form-row form-input-title-box"><label for="artist_introduction">작가 소개</label></div>
                <div id="artist_introduction" class="form-control"></div>
            </div>
            <div class="form-group">
                <div class="form-row form-input-title-box"><label for="artist_academic">학력</label></div>
                <div id="artist_academic" class="form-control"></div>
            </div>
            <div class="form-group">
                <div class="form-row form-input-title-box"><label for="artist_individual_exhibition">주요 개인전</label></div>
                <div id="artist_individual_exhibition" class="form-control"></div>
            </div>
            <div class="form-group">
                <div class="form-row form-input-title-box"><label for="artist_team_competition">주요 단체전</label></div>
                <div id="artist_team_competition" class="form-control"></div>
            </div>
            <div class="form-group">
                <div class="form-row form-input-title-box"><label for="artist_interview">작가 인터뷰</label></div>
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