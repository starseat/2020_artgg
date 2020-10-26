<?php require_once('fragment/content_layout.php'); ?>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

<style>
    #press_release_date_box {
        display: none;
    }

    #press_release_form_delete_btn {
        display: none;
    }
</style>

<h1 class="mt-4 mb-4">보도자료</h1>

<div class="card mt-2">
    <div class="card-body">
        <form id="press_release_form" name="press_release_form">
            <div class="form-group" id="press_release_date_box">
                <div class="row">
                    <div class="col-6"></div>
                    <div class="col-6 text-right">
                        <div class="row justify-content-md-end">
                            <div class="col-3"><label for="press_release_created_at" class="col-form-label">최초 등록일</label></div>
                            <div class="col-4"><input type="text" class="form-control" id="press_release_created_at" readonly></div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6"></div>
                    <div class="col-6 text-right">
                        <div class="row justify-content-md-end">
                            <div class="col-3"><label for="press_release_updated_at" class="col-form-label">마지막 수정일</label></div>
                            <div class="col-4"><input type="text" class="form-control" id="press_release_updated_at" readonly></div>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
            <input type="hidden" id="press_release_seq" name="press_release_seq" value="0">
            <div class="form-group row">
                <div class="form-group col-md-12">
                    <label for="press_release_title">* 제목</label>
                    <input type="text" class="form-control" id="press_release_title" name="press_release_title" placeholder="보도자료 제목을 입력해주세요.">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group col-md-12">
                    <label for="press_release_link">링크</label>
                    <input type="text" class="form-control" id="press_release_link" name="press_release_link" placeholder="보도자료 링크를 입력해주세요.">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group col-md-4">
                    <label for="press_release_news_date">날짜</label>
                    <input type="text" class="form-control" id="press_release_news_date" name="press_release_news_date" placeholder="날짜를 입력해주세요.">
                </div>
                <div class="form-group col-md-4">
                    <label for="press_release_news_media">매체</label>
                    <input type="text" class="form-control" id="press_release_news_media" name="press_release_news_media" placeholder="매체를 입력해주세요.">
                </div>
                <div class="form-group col-md-4">
                    <label for="press_release_news_author">작성자</label>
                    <input type="text" class="form-control" id="press_release_news_author" name="press_release_news_author" placeholder="작성자를 입력해주세요.">
                </div>
            </div>
            <div class="form-group">
                <label for="press_release_contents">* 보도자료 내용</label>
                <div id="press_release_contents" class="form-control"></div>
            </div>
            <div class="row">
                <div class="col-6 text-left">
                    <button class="btn btn-info" id="press_release_list_btn" onclick="goPressReleaseList(event)">목록</button>
                    <button class="btn btn-secondary" id="press_release_form_reset_btn" onclick="doReset(event)">초기화</button>
                    <button class="btn btn-danger" id="press_release_form_delete_btn" onclick="doDelete(event)">삭제</button>
                </div>
                <div class="col-6 text-right">
                    <button class="btn btn-primary" onclick="doSubmit(event)">저장</button>
                </div>
            </div>
        </form>
    </div>
</div>


<?php require_once('fragment/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ko-KR.js"></script>
<script src="./js/common.js"></script>
<script src="./js/press_release.form.js"></script>

<?php require_once('fragment/tail.php'); ?>