<?php require_once('./fragment/header.php'); ?>

<link rel="stylesheet" type="text/css" href="./css/artist.detail.css" media="all" />

<?php
$artist_seq = 0;
$is_access = false;
if ($_SERVER['QUERY_STRING'] != '') {
    $artist_seq = $_GET['seq'];
    if (!isEmpty($artist_seq) && is_numeric($artist_seq)) {
        $is_access = true;
    }
}

if (!$is_access) {
    viewAlert('잘못된 접근 입니다.');
    mysqli_close($conn);
    flush();
    //historyBack();
    echo ('<meta http-equiv="refresh" content="0 url=./artist.php" />');
    exit;
}

$sql  = "SELECT seq, year, name, en_name, thumbnail, introduction, academic, individual_exhibition, team_competition, interview ";
$sql .= "FROM artgg_artist WHERE seq = " . $artist_seq;
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$artist_info = $result->fetch_array();
$result->free();

?>

<!-- 콘텐츠 -->
<div class="container">
    <div class="content_inner">
        <div class="section_box_w">
            <h2 class="content_title_b">Artist <span class="artist_name"><?php echo RemoveXSS($artist_info['name']) . '(' . RemoveXSS($artist_info['en_name']) . ')'; ?></span></h2>
            <div class="content_info_text"><?php echo RemoveXSS($artist_info['introduction']); ?></div>
            <div class="section_artist_w">
                <div class="artist_slide_w">
                    <div id="artist_slide_swiper_container" class="swiper-container">
                        <div class="swiper-wrapper">
                            <?php
                            $sql  = "SELECT seq, target_seq, target_type, sort, file_name, upload_path, caption ";
                            $sql .= "FROM artgg_image WHERE target_seq = " . $artist_seq . " AND target_type = 'artist' ";
                            $sql .= "ORDER BY sort ASC";
                            $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
                            while ($image_row = $result->fetch_array()) {
                                echo '<div class="swiper-slide"><img src="' . getImagePath(RemoveXSS($image_row['upload_path'])) . '"></div>';
                            }
                            $result->free();
                            ?>
                        </div>
                        <!-- Add Pagination -->
                        <div class="swiper-pagination"></div>
                        <!-- Add Arrows -->
                        <div class="swiper-button-next swiper-button-color"></div>
                        <div class="swiper-button-prev swiper-button-color"></div>
                    </div>
                </div>
                <!-- 작가이력 영역 -->
                <!--
                <div class="article_artist_box">
                    <h3 class="content_title_c">작가 소개</h3>
                    <ul class="artist_box_list">
                        <li class="abl_inner">
                            <strong>
                -->
                            <?php 
                                // echo RemoveXSS($artist_info['name']) . '(' . RemoveXSS($artist_info['en_name']) . ')'; 
                            ?>
                <!--
                            </strong>
                        </li>
                    </ul>
                </div>
                -->
                <div class="article_artist_box">
                    <h3 class="content_title_c">학력</h3>
                    <?php echo RemoveXSS($artist_info['academic']); ?>
                </div>
                <div class="article_artist_box">
                    <h3 class="content_title_c">주요개인전</h3>
                    <?php echo RemoveXSS($artist_info['individual_exhibition']); ?>
                </div>
                <div class="article_artist_box">
                    <h3 class="content_title_c">주요단체전</h3>
                    <?php echo RemoveXSS($artist_info['team_competition']); ?>
                </div>
                <div class="article_artist_box">
                    <h3 class="content_title_c">작가인터뷰</h3>
                    <div class="artist_qa_list">
                        <?php echo RemoveXSS($artist_info['interview']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('./fragment/footer.php'); ?>

<script src="./js/artist.detail.js"></script>

<?php require_once('./fragment/tail.php'); ?>