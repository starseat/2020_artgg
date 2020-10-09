<?php require_once('fragment/content_layout.php'); ?>

<?php
include('common.php');
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

    #directionsModal_add_btn {
        display: none;
    }
</style>
<h1 class="mt-4">프로그램 정보</h1>

<div class="card mt-4 mb-4">
    <div class="card-body">
        <form id="updateProgramForm" name="updateProgramForm" method="post" action="./action/program_update.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="program_name"><strong>* 프로그램 명</strong></label>
                <input type="text" class="form-control" id="program_name" name="program_name">
            </div>
            <div class="form-group">
                <label for="program_partners"><strong>* 협력사</strong></label>
                <input type="text" class="form-control" id="program_partners" name="program_partners">
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
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="program_online_name"><strong>온라인 소개 명칭</strong></label>
                    <input type="text" class="form-control" id="program_online_name" name="program_online_name">
                </div>
                <div class="form-group col-md-6">
                    <label for="program_online_url"><strong>온라인 URL</strong></label>
                    <input type="text" class="form-control" id="program_online_url" name="program_online_url">
                </div>
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
            <div class="form-row">
                <div class="form-group col-md-5">
                    <div class="form-row form-input-title-box"><label for="program_directions"><strong>오시는길</strong></label></div>
                    <input type="text" class="form-control" id="program_directions" name="program_directions" placeholder="지도 추가 버튼을 클릭하세요." readonly>
                </div>
                <div class="form-group col-md-5">
                    <label for="program_directions_name"><strong>장소 표시 명칭</strong></label>
                    <input type="text" class="form-control" id="program_directions_name" name="program_directions_name" readonly>
                </div>
                <div class="form-group col-md-2" style="margin-top: auto !important;">
                    <button type="button" class="btn btn-info btn-block ml-2 " onclick="showDirectionsModal()">지도 추가</button>
                </div>
                <input type="hidden" val="" id="directions_map_x" name="directions_map_x">
                <input type="hidden" val="" id="directions_map_y" name="directions_map_y">
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

<div class="modal fade" id="directionsModal" tabindex="-1" aria-labelledby="directionsModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="directionsModalLabel">지도 추가</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <input type="hidden" id="insert_type_link" name="insert_type" value="video" />
                    <div class="form-group">
                        <label for="directionsModal_address"><strong>* 주소</strong></label>
                        <input type="text" class="form-control" id="directionsModal_address" name="directionsModal_address" placeholder="검색할 장소의 주소를 입력해 주세요.">
                    </div>
                    <div class="form-group">
                        <label for="directionsModal_address_name"><strong>장소 표시 명칭</strong></label>
                        <input type="text" class="form-control" id="directionsModal_address_name" name="directionsModal_address_name" placeholder="표시될 명칭을 입력해 주세요.">
                    </div>
                    <div class="form-group">
                        <small id="directionsModal_find_error" style="color: red;"></small>
                    </div>
                    <div class="form-group" id="directionsModal_map_box">
                        <hr>
                        <small class="form-text text-muted">지도가 잘 안보이면 한번더 검색버튼을 눌러주세요.</small>
                        <div id="directionsModal_map" style="width:100%;height:280px;"></div>
                    </div>
                    <input type="hidden" val="" id="directionsModal_find_success_address">
                    <input type="hidden" val="" id="directionsModal_find_success_address_name">
                    <input type="hidden" val="" id="directionsModal_find_success_map_x">
                    <input type="hidden" val="" id="directionsModal_find_success_map_y">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-warning" onclick="doSubmit_openKakaoMap(event)">카카오 맵 열기</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                <button type="button" class="btn btn-info" id="directionsModal_find_btn" onclick="doSubmit_FindMap(event)">검색</button>
                <button type="button" class="btn btn-success" id="directionsModal_add_btn" onclick="doSubmit_insertMap()">추가</button>
            </div>
        </div>
    </div>
</div>

<?php require_once('fragment/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ko-KR.js"></script>
<script src="vendor/image-uploader/dist/image-uploader.min.js"></script>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=ec6b3e1f28bbc62cb020b79094f74664&libraries=services"></script>
<script src="./js/common.js"></script>
<script src="./js/program.edit.js"></script>

<?php require_once('fragment/tail.php'); ?>