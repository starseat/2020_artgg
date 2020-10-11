<?php require_once('./fragment/header.php'); ?>

<?php
$partner_seq = 0;
$is_access = false;
if ($_SERVER['QUERY_STRING'] != '') {
    $partner_seq = $_GET['seq'];
    if (!isEmpty($partner_seq) && is_numeric($partner_seq)) {
        $is_access = true;
    }
}

if (!$is_access) {
    viewAlert('잘못된 접근 입니다.');
    mysqli_close($conn);
    flush();
    //historyBack();
    echo ('<meta http-equiv="refresh" content="0 url=./business.php" />');
    exit;
}

$partner_seq = intval(mysqli_real_escape_string($conn, $partner_seq));

$sql  = "SELECT seq, type, name, thumbnail, introduction ";
$sql .= "FROM artgg_business WHERE seq = " . $partner_seq . " AND type = 'P' LIMIT 1";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$partner_info = $result->fetch_array();
$result->free();

$sql  = "SELECT seq, target_seq, target_type, sort, file_name, upload_path, caption ";
$sql .= "FROM artgg_image WHERE target_seq = " . $partner_seq . " AND target_type = 'business' ";
$sql .= "ORDER BY sort ASC ";
$sql .= "LIMIT 1";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$image_info = $result->fetch_array();
$result->free();

?>

<!-- 콘텐츠 -->
<div class="container">
    <div class="content_inner">
        <div class="business_end_w">
            <h2 class="content_title_b"><?php echo $partner_info['name']; ?></h2>
            <div class="section_artist_w">
                <img src="<?php echo getImagePath(RemoveXSS($image_info['upload_path'])) ?>" alt="<?php echo $partner_info['name']; ?>">
            </div>
            <p class="content_info_text"><?php echo RemoveXSS($partner_info['introduction']); ?></p>
        </div>
    </div>
</div>

<?php require_once('./fragment/footer.php'); ?>

<?php require_once('./fragment/tail.php'); ?>