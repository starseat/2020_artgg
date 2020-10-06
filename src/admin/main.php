<?php require_once('fragment/content_layout.php'); ?>

<?php

include('common.php');
include('db_conn.php');

// $isLogin = $_SESSION['is_login'];
// if ($isLogin != 1) {
//     echo ('<meta http-equiv="refresh" content="0 url=./login.html" />');
// }

?>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<link href="vendor/image-uploader/dist/image-uploader.min.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

<style>
    .swiper-container {
        width: 100%;
        height: 400px;
        background-color: #fff;
        color: #000;
    }

    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;
        /* background: #000; */

        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }

    .swiper-slide img {
        width: auto;
        height: auto;
        max-width: 100%;
        max-height: 100%;
        -ms-transform: translate(-50%, -50%);
        -webkit-transform: translate(-50%, -50%);
        -moz-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        position: absolute;
        left: 50%;
        top: 50%;
    }

    .swiper-button-color {
        color: #000 !important;
    }

    .swiper-pagination-bullet-active {
        background-color: #000 !important;
    }

    .table-hover-pointer th,
    .table-hover-pointer td {
        text-align: center;
    }

    #modifyContentsModalTable tbody {
        display: block;
        overflow: auto;
        height: 240px;
    }

    #modifyContentsModalTable thead,
    #modifyContentsModalTable tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    .contents-file-name {
        text-align: left !important;
    }
</style>
<h1 class="mt-4">메인 화면 이미지</h1>

<div class="mt-4 mb-4">
    <div class="m-4 d-flex justify-content-end main-contents-add-btn-group">
        <button type="button" class="btn btn-info ml-2" onclick="showInsertImageModal()">이미지 추가</button>
        <button type="button" class="btn btn-danger ml-2" onclick="showInsertLinkModal()">Youtube 링크 추가</button>
        <button type="button" class="btn btn-secondary ml-2" onclick="showModifyContentsModal()">컨텐츠 관리</button>
    </div>
</div>

<!-- Swiper -->
<div class="card">
    <div class="card-body">
        <div class="swiper-container swiper-youtube-container">
            <div class="swiper-wrapper">
                <?php
                $sql  = "SELECT seq, sort, file_name, upload_path, storage_type, image_type FROM artgg_image WHERE target_type = 'main' ORDER BY sort";
                $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
                $main_contents_count = $result->num_rows;
                $main_contents_list = array();
                if ($main_contents_count > 0) {
                    while ($row = $result->fetch_array()) {
                        array_push($main_contents_list, [
                            'seq' => $row['seq'],
                            'sort' => $row['sort'],
                            'file_name' => $row['file_name'],
                            'upload_path' => $row['upload_path'],
                            'storage_type' => $row['storage_type'],
                            'image_type' => $row['image_type']
                        ]);

                        echo ('<div class="swiper-slide">');
                        if ($row['image_type'] == 'I') {
                            echo ('<img class="swiper-lazy" src="' . RemoveXSS($row['upload_path']) . '">');
                        } else if ($row['image_type'] == 'V') {
                            echo ('<div class="swiper-video-container" data-id="' . RemoveXSS($row['file_name']) . '">');
                            echo ('<div class="swiper-video-iframe"></div>');
                            echo ('<div class="swiper-video-play"></div>');
                            echo ('</div>');
                        }
                        echo ('</div>');
                    }
                } else {
                    echo ('<div class="swiper-slide">등록된 컨텐츠가 없습니다.</div>');
                }
                $result->free();
                ?>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
            <!-- Add Navigation -->
            <div class="swiper-button-prev swiper-button-color"></div>
            <div class="swiper-button-next swiper-button-color"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="insertImageModal" tabindex="-1" aria-labelledby="insertImageModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insertImageModalLabel">이미지 추가</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="insertImageModalForm" name="insertImageModalForm" method="post" action="./action/main_image_submit.php" enctype="multipart/form-data">
                    <input type="hidden" id="insert_type_image" name="insert_type" value="image" />
                    <div class="form-group">
                        <div id="main_images"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                <button type="button" class="btn btn-primary" onclick="doSubmit_insertImageModalForm(event)">추가</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="insertLinkModal" tabindex="-1" aria-labelledby="insertLinkModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insertLinkModalLabel">Youtube 링크 추가</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="insertLinkModalForm" name="insertLinkModalForm" method="post" action="./action/main_image_submit.php">
                    <input type="hidden" id="insert_type_link" name="insert_type" value="video" />
                    <div class="form-group">
                        <input type="text" class="form-control" id="main_link" name="main_link" placeholder=" Youtube 링크를 입력해 주세요.">
                        <input type="hidden" id="main_link_youtube_id" name="main_link_youtube_id">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                <button type="button" class="btn btn-primary" onclick="doSubmit_insertLinkModalForm(event)">추가</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modifyContentsModal" tabindex="-1" aria-labelledby="modifyContentsModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="width: 800px;">
            <div class="modal-header">
                <h5 class="modal-title" id="modifyContentsModalLabel">컨텐츠 관리</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="modifyContentsModalForm" name="modifyContentsModalForm">
                    <table class="table table-hover table-hover-pointer" id="modifyContentsModalTable">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">no</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col">파일명</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col">순서</th>
                                <th scope="col">삭제</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($main_contents_count > 0) {
                                for ($i = 0; $i < $main_contents_count; $i++) {
                                    echo ('<tr class="main-contents-list">');
                                    echo ('    <th scope="row" class="contents-seq">' . RemoveXSS($main_contents_list[$i]['seq']) . '</th>');
                                    if ($main_contents_list[$i]['storage_type'] == 'W') {
                                        echo ('    <td colspan="5" class="contents-file-name">' . RemoveXSS($main_contents_list[$i]['upload_path']) . '</td>');
                                    } else if ($main_contents_list[$i]['storage_type'] == 'L') {
                                        echo ('    <td colspan="5" class="contents-file-name">' . RemoveXSS($main_contents_list[$i]['file_name']) . '</td>');
                                    }
                                    echo ('    <td><input type="number" class="contents-sort" style="width: 60px;" value="' . RemoveXSS($main_contents_list[$i]['sort']) . '"></td>');
                                    echo ('    <td><button class="btn btn-danger" onclick="doDeleteContents(event, ' . RemoveXSS($main_contents_list[$i]['seq']) . ')">삭제</button></td>');
                                    echo ('</tr>');
                                }
                            } else {
                                echo ('<tr><th scope="row"></th><td>등록된 컨텐츠가 없습니다.</td><td></td><td></td></tr>');
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                <button type="button" class="btn btn-primary" onclick="doSubmit_modifyContentsModalForm(event)">적용</button>
            </div>
        </div>
    </div>
</div>

<?php
mysqli_close($conn);
flush();
?>

<?php require_once('fragment/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ko-KR.js"></script>
<script src="vendor/image-uploader/dist/image-uploader.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script src="./js/common.js"></script>
<script src="./js/main.js"></script>

<?php require_once('fragment/tail.php'); ?>