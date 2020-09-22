<?php require_once('fragment/content_layout.php'); ?>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

<h1 class="mt-4">작가 소개 글</h1>

<div class="row">
    <div class="d-none d-md-inline-block ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <select class="form-control" id="artist_select_year">
            <option value="0">없음</option>
        </select>
    </div>
</div>

<br>

<div class="card">
    <div class="card-body">
        <form id="artist_gretting_from" name="artist_gretting_from">
            <input type="hidden" id="artist_seq" value="0">
            <div class="form-group row">
                <label for="artist_year" class="col-sm-2 col-form-label">년도</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="artist_year">
                </div>
            </div>
            <div class="form-group">
                <label for="artist_greeting">소개글</label>
                <div id="artist_greeting" class="form-control"></div>
            </div>
            <div class="row">
                <div class="col-6 text-left">
                    <button class="btn btn-success" onclick="doNewWrite(event)">새글 작성</button>
                </div>
                <div class="col-6 text-right">
                    <button class="btn btn-primary" onclick="doSubmit(event)">저장</button>
                    <button class="btn btn-danger" onclick="doDelete(event)">삭제</button>
                </div>
            </div>
        </form>
    </div>
</div>


<?php require_once('fragment/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ko-KR.js"></script>
<script src="./js/artist_greeting.js"></script>

<?php require_once('fragment/tail.php'); ?>