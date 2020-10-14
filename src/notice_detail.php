<?php require_once('./fragment/header.php'); ?>

<?php

$notice_seq = 0;
$is_access = false;
if ($_SERVER['QUERY_STRING'] != '') {
    $notice_seq = $_GET['seq'];
    if (!isEmpty($notice_seq) && is_numeric($notice_seq)) {
        $is_access = true;
    }
}

if (!$is_access) {
    viewAlert('잘못된 접근 입니다.');
    mysqli_close($conn);
    flush();
    //historyBack();
    echo ('<meta http-equiv="refresh" content="0 url=./notice.php" />');
    exit;
}

$notice_seq = intval(mysqli_real_escape_string($conn, $notice_seq));

$sql  = "SELECT seq, level, title, contents, view_count, created_at, updated_at FROM artgg_notice WHERE seq = $notice_seq";
$sql .= " Limit 1";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$notice_info = $result->fetch_array();
$result->free();

// 조회수 처리
$notice_view_cookie_name = 'notice_view_' . $notice_seq;
if (!isset($_COOKIE[$notice_view_cookie_name]) || empty($_COOKIE[$notice_view_cookie_name])) {
    $sql  = 'UPDATE artgg_notice set view_count = view_count + 1 WHERE seq = ' . $notice_seq;
    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
    setcookie($notice_view_cookie_name, 1, time() + (60 * 60 * 24), '/');  // 1 day
}
?>

<!-- 콘텐츠 -->
<div class="container">
    <div class="content_inner">
        <div class="section_box_w">
            <h2 class="content_title">공지사항</h2>
            <div class="board_view_area">
                <ul class="top_title_faq">
                    <li class="board_title"><?php echo getNoticeListViewTitme(intval(RemoveXSS($notice_info['level'])), RemoveXSS($notice_info['title'])); ?></li>
                    <li class="stit_area">
                        <span class="stit_regist_day">
                            <span class="stit_text">등록일</span>
                            <em class="stit_date"><?php echo $notice_info['created_at']; ?></em>
                        </span>
                        <span class="stit_regist_end">
                            <span class="stit_text">수정일</span>
                            <em class="stit_date"><?php echo $notice_info['updated_at']; ?></em>
                        </span>
                        <span class="stit_regist_end">
                            <span class="stit_text">조회수</span>
                            <em class="stit_date"><?php echo $notice_info['view_count']; ?></em>
                        </span>
                    </li>
                </ul>
                <div class="view_area"><?php echo RemoveXSS($notice_info['contents']); ?></div>
                <div class="button_box_w">
                    <button type="button" class="button_board_list" onclick="javascript: location.href='./notice.php'; ">
                        <span class="btn_bl_text">목록으로</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('./fragment/footer.php'); ?>

<?php require_once('./fragment/tail.php'); ?>