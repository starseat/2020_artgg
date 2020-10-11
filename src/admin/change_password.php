<?php require_once('fragment/content_layout.php'); ?>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

<style>
    #error_message_box { display: none; }
</style>
<h1 class="mt-4">비밀번호 변경</h1>

<div class="mt-4 mb-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-body">
                        <form id="changePasswordForm" name="changePasswordForm" method="post" action="./action/change_password_submit.php">
                            <div class="form-group">
                                <label class="small mb-1" for="currentPassword">현재 비밀번호</label>
                                <input class="form-control py-4" id="currentPassword" name="currentPassword" type="password" aria-describedby="currentPasswordHelp" placeholder="현재 비밀번호를 입력해 주세요." />
                            </div>
                            <div class="form-group">
                                <label class="small mb-1" for="changePassword">새로운 비밀번호</label>
                                <input class="form-control py-4" id="changePassword" name="changePassword" type="password" aria-describedby="changePasswordHelp" placeholder="새로운 비밀번호를 입력해 주세요." />
                            </div>
                            <div class="form-group">
                                <label class="small mb-1" for="changePasswordCheck">새로운 비밀번호 체크</label>
                                <input class="form-control py-4" id="changePasswordCheck" type="password" aria-describedby="changePasswordCheckHelp" placeholder="새로운 비밀번호를 한번 더 입력해 주세요." />
                            </div>
                            <div class="form-group" id="error_message_box">
                                <hr>
                                <small id="error_message" style="color: red;"></small>
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                <div></div>
                                <button class="btn btn-primary" onclick="onSubmit(event)">비밀번호 변경하기</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php require_once('fragment/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ko-KR.js"></script>
<script src="./js/common.js"></script>
<script src="./js/change_password.js"></script>

<?php require_once('fragment/tail.php'); ?>