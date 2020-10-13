<?php require_once('fragment/content_layout.php'); ?>

<?php

include('common.php');
include('db_conn.php');


?>

<style>
    .table-hover-pointer tbody tr:hover {
        cursor: pointer;
    }

    .page-link-dark {
        color: #343a40;
    }

    .page-item.active-dark .page-link {
        z-index: 3;
        color: white;
        background-color: #343a40;
        border-color: #343a40
    }

    .table-hover-pointer th,
    .table-hover-pointer td {
        text-align: center;
    }

    .media-room-item {
        text-align: left !important;
    }
</style>

<h1 class="mt-4">미디어룸</h1>

<div class="mt-4 mb-4 container">
    <div class="m-4 d-flex justify-content-end">
        <div class="row"><button type="button" class="btn btn-info" onclick="showEditMediaRoomModal();">추가</button></div>
    </div>

    <table class="table table-hover table-hover-pointer">
        <colgroup>
            <col width="10%" />
            <col width="40%" />
            <col width="35%" />
            <col width="15%" />
        </colgroup>
        <thead class="thead-dark">
            <tr>
                <th scope="col">no</th>
                <th scope="col">제목</th>
                <th scope="col">링크</th>
                <th scope="col">수정</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $sql  = "SELECT seq, title, link FROM artgg_mediaroom ORDER BY seq DESC";
            $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
            $media_length = $result->num_rows;

            if ($media_length > 0) {
                while ($row = $result->fetch_array()) {
                    echo ('<tr onclick="showEditMediaRoomModal(' . RemoveXSS($row['seq']) . ')" id="mediaroom_item_' . RemoveXSS($row['seq']) . '">');
                    echo ('    <th scope="row">' . RemoveXSS($row['seq']) . '</th>');
                    echo ('    <td class="media-room-item media-room-title">' . RemoveXSS($row['title']) . '</td>');
                    echo ('    <td class="media-room-item media-room-link"><a href="' . RemoveXSS($row['link']) . '" target="_blank" >' . RemoveXSS($row['link']) . '</a></td>');
                    echo ('    <td><button class="btn btn-success ml-2 mr-2" onclick="showEditMediaRoomModal(' . RemoveXSS($row['seq']) . ')"><i class="fas fa-edit"></i></button>');
                    echo ('<button class="btn btn-danger ml-2 mr-2" onclick="deleteMediaRoom(' . RemoveXSS($row['seq']) . ')"><i class="fas fa-trash"></i></button></td>');
                    echo ('</tr>');
                }
            } else {
                echo ('<tr><th scope="row"></th><td colspan="2">등록된 정보가 없습니다.</td><td></td></tr>');
            }

            $result->free();

            ?>
        </tbody>
    </table>

    <div class="m-4 d-flex justify-content-end">
        <div class="row"><button type="button" class="btn btn-info" onclick="showEditMediaRoomModal();">추가</button></div>
    </div>
</div>

<div class="modal fade" id="editMediaRoomModal" tabindex="-1" aria-labelledby="editMediaRoomModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMediaRoomModalLabel">미디어룸</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editMediaRoomModalFrom" name="editMediaRoomModalFrom" method="post" action="./action/media_room_submit.php">
                    <div class="form-group">
                        <label for="mediaroom_title">제목</label>
                        <input type="text" class="form-control" id="mediaroom_title" name="mediaroom_title" placeholder=" 제목을 입력해 주세요." />
                    </div>
                    <div class="form-group">
                        <label for="mediaroom_link">Youtube Link</label>
                        <input type="text" class="form-control" id="mediaroom_link" name="mediaroom_link" placeholder=" Youtube 링크를 입력해 주세요.">
                        <input type="hidden" id="mediaroom_link_youtube_id" name="mediaroom_link_youtube_id">
                    </div>
                    <input type="hidden" id="mediaroom_seq" name="mediaroom_seq" value="0">
                    <input type="hidden" id="mediaroom_submit_action" name="mediaroom_submit_action" value="insert">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                <button type="button" class="btn btn-primary" onclick="doSubmit(event)">추가</button>
            </div>
        </div>
    </div>
</div>

<?php
mysqli_close($conn);
flush();
?>

<?php require_once('fragment/footer.php'); ?>

<script src="./js/common.js"></script>
<script src="./js/mediaroom.js"></script>

<?php require_once('fragment/tail.php'); ?>