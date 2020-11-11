<?php require_once('fragment/content_layout.php'); ?>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

<style>
    #promotion_date_box {
        display: none;
    }

    #promotion_form_delete_btn { display: none; }
</style>

<h1 class="mt-4 mb-4">홍보자료</h1>

<div class="card mt-2">
    <div class="card-body">
        <form id="promotion_from" name="promotion_from">
            <div class="form-group" id="promotion_date_box">
                <div class="row">
                    <div class="col-6"></div>
                    <div class="col-6 text-right">
                        <div class="row justify-content-md-end">
                            <div class="col-3"><label for="promotion_created_at" class="col-form-label">최초 등록일</label></div>
                            <div class="col-4"><input type="text" class="form-control" id="promotion_created_at" readonly></div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6"></div>
                    <div class="col-6 text-right">
                        <div class="row justify-content-md-end">
                            <div class="col-3"><label for="promotion_updated_at" class="col-form-label">마지막 수정일</label></div>
                            <div class="col-4"><input type="text" class="form-control" id="promotion_updated_at" readonly></div>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
            <input type="hidden" id="promotion_seq" name="promotion_seq" value="0">
            <div class="form-group row">
                <div class="form-group col-md-8">
                    <label for="promotion_title">* 제목</label>
                    <input type="text" class="form-control" id="promotion_title" name="promotion_title" placeholder="홍보자료 제목을 입력해주세요.">
                </div>
            </div>
            <div class="form-group">
                <label for="promotion_contents">* 홍보자료 내용</label>
                <div id="promotion_contents" class="form-control"></div>
            </div>
            <div class="row">
                <div class="col-6 text-left">
                    <button class="btn btn-info" id="promotion_list_btn" onclick="goPromotionList(event)">목록</button>
                    <button class="btn btn-secondary" id="promotion_form_reset_btn" onclick="doReset(event)">초기화</button>
                    <button class="btn btn-danger" id="promotion_form_delete_btn" onclick="doDelete(event)">삭제</button>
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
<script src="./js/promotion.form.js"></script>

<?php require_once('fragment/tail.php'); ?>