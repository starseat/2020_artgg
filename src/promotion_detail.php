<?php require_once('./fragment/header.php'); ?>

<?php

$promotion_seq = 0;
$is_access = false;
if ($_SERVER['QUERY_STRING'] != '') {
    $promotion_seq = $_GET['seq'];
    if (!isEmpty($promotion_seq) && is_numeric($promotion_seq)) {
        $is_access = true;
    }
}

if (!$is_access) {
    viewAlert('잘못된 접근 입니다.');
    mysqli_close($conn);
    flush();
    //historyBack();
    echo ('<meta http-equiv="refresh" content="0 url=./promotion.php" />');
    exit;
}

$promotion_seq = intval(mysqli_real_escape_string($conn, $promotion_seq));

$sql  = "SELECT seq, title, contents, view_count, created_at, updated_at FROM artgg_promotion WHERE seq = $promotion_seq";
$sql .= " Limit 1";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$promotion_info = $result->fetch_array();
$result->free();

// 조회수 처리
$promotion_view_cookie_name = 'promotion_view_' . $promotion_seq;
if (!isset($_COOKIE[$promotion_view_cookie_name]) || empty($_COOKIE[$promotion_view_cookie_name])) {
    $sql  = 'UPDATE artgg_promotion set view_count = view_count + 1 WHERE seq = ' . $promotion_seq;
    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
    // setcookie($promotion_view_cookie_name, 1, time() + (60 * 60 * 24), '/');  // 1 day
}
?>

<!-- 콘텐츠 -->
<div class="container">
    <div class="content_inner">
        <div class="section_box_w">
            <h2 class="content_title">홍보자료</h2>
            <div class="board_view_area">
                <div class="top_title_faq">
                    <em class="board_title"><?php echo RemoveXSS($promotion_info['title']); ?></em>
                </div>
                <div class="stit_area">
                    <span class="stit_regist_day">
                        <span class="stit_text">등록일 :</span>
                        <span class="stit_date"><?php echo $promotion_info['created_at']; ?></span>
                    </span>
                    <span class="stit_regist_end">
                        <span class="stit_text">수정일 :</span>
                        <em class="stit_date"><?php echo $promotion_info['updated_at']; ?></em>
                    </span>
                    <span class="stit_regist_view">
                        <span class="stit_text">조회수 :</span>
                        <em class="stit_date"><?php echo $promotion_info['view_count']; ?></em>
                    </span>
                </div>
                <div class="file_area">
                    <div class="file_name">
                        <strong class="area_title">첨부파일 : </strong>
                        <?php
                        $sql  = "SELECT file_name, upload_path FROM artgg_file WHERE target_type = 'promotion' AND target_seq = " . $promotion_seq;
                        $sql .= " ORDER BY sort";
                        $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
                        while ($row = $result->fetch_array()) {
                            $file_item  = ' <a class="fn_text" ';
                            $file_item .= ' href="' . getFilePath($row['upload_path']) . '" download="' . RemoveXSS($row['file_name']) . '">';
                            $file_item .= $row['file_name'];
                            $file_item .= '</a> ';

                            echo $file_item;
                        }
                        $result->free();
                        ?>
                    </div>


                </div>
                <div class="view_area"><?php echo RemoveXSS($promotion_info['contents']); ?></div>
                <div class="button_box_w">
                    <button type="button" class="button_board_list" onclick="javascript: location.href='./promotion.php'; ">
                        <span class="btn_bl_text">목록으로</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('./fragment/footer.php'); ?>

<?php require_once('./fragment/tail.php'); ?>