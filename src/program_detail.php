<?php require_once('./fragment/header.php'); ?>

<style>
    #direction_map_marker_link {
        cursor: pointer;
    }

    #direction_map_marker_link:hover {
        cursor: pointer;
        text-decoration: none;
        color: #000;
    }
</style>

<?php
$program_seq = 0;
$is_access = false;
if ($_SERVER['QUERY_STRING'] != '') {
    $program_seq = $_GET['seq'];
    if (!isEmpty($program_seq) && is_numeric($program_seq)) {
        $is_access = true;
    }
}

if (!$is_access) {
    viewAlert('잘못된 접근 입니다.');
    mysqli_close($conn);
    flush();
    //historyBack();
    echo ('<meta http-equiv="refresh" content="0 url=./program.php" />');
    exit;
}

$program_seq = intval(mysqli_real_escape_string($conn, $program_seq));

$sql  = "SELECT name, year, thumbnail, program_date, place, partners, online_url, online_name, introduction, schedule, event, ";
$sql .= "directions, directions_name, directions_map_x, directions_map_y ";
$sql .= "FROM artgg_program WHERE seq = " . $program_seq;
$sql .= " Limit 1";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$program_info = $result->fetch_array();

$result->free();

$sql  = "SELECT seq, target_seq, target_type, sort, file_name, upload_path ";
$sql .= "FROM artgg_image WHERE target_seq = " . $program_seq . " AND target_type = 'program' ";
$sql .= " Limit 1";
//$sql .= "ORDER BY sort ASC";

$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$image_info = $result->fetch_array();
?>

<style>
    #directions_map {
        margin-top: 1rem;
    }
</style>

<!-- 콘텐츠 -->
<div class="container">
    <div class="content_inner">
        <div class="section_box_w">
            <h2 class="content_title">Program</h2>
            <!-- <h3 class="content_title_d"> -->
            <?php
            // 상단에 표시되는 프로그램명 삭제 요청 - 2020.10.12
            // echo RemoveXSS($program_info['name']); 
            ?>
            <!-- </h3> -->
            <div class="section_program_w">
                <div class="program_poster_w">
                    <img src="<?php echo getImagePath(RemoveXSS($image_info['upload_path'])); ?>" alt="<?php echo RemoveXSS($program_info['name']); ?>" class="poster_image">
                </div>
                <div class="program_name_w">
                    <strong class="pn_title"><?php echo RemoveXSS($program_info['name']); ?></strong>
                    <span class="pn_collaborate">협력사 : <?php echo RemoveXSS($program_info['partners']); ?></span>
                    <span class="pn_date"><?php echo RemoveXSS($program_info['program_date']); ?></span>
                </div>
                <div class="program_info_text_w">
                    <div class="program_info_box">
                        <strong class="info_title">장소</strong>
                        <span class="info_cont">
                            <?php
                            echo RemoveXSS($program_info['place']);

                            if (!isEMpty($program_info['online_name'])) {
                                echo ' / ';
                                echo '<a href="' . RemoveXSS($program_info['online_url']) . '" target="_blank">' . RemoveXSS($program_info['online_name']) . '</a>';
                            }
                            ?>
                        </span>
                    </div>
                    <div class="program_info_box">
                        <strong class="info_title">프로그램 소개</strong>
                        <span class="info_cont"><?php echo RemoveXSS($program_info['introduction']); ?> </span>
                    </div>
                    <?php
                    // Schedule, 행사 정보 삭제
                    // <div class="program_info_box">
                    //     <strong class="info_title">Schedule</strong>
                    //     <span class="info_cont">
                    //         echo RemoveXSS($program_info['schedule']); 
                    //     </span>
                    // </div>
                    // echo RemoveXSS($program_info['event']);
                    ?>
                </div>
            </div>
        </div>

        <!-- 오시는 길 -->
        <?php
        if (!isEmpty(RemoveXSS($program_info['directions']))) {
            echo ('<div class="section_box_w">');
            echo ('    <div class="program_info_box pg_roadmap_w">');
            echo ('        <strong class="info_title">오시는길</strong>');
            echo ('        <div class="roadmap_box" id="directions_map"></div>');
            echo ('        <input type="hidden" id="directions" value="' . RemoveXSS($program_info['directions']) . '">');
            echo ('        <input type="hidden" id="directions_name" value="' . RemoveXSS($program_info['directions_name']) . '">');
            echo ('        <input type="hidden" id="directions_map_x" value="' . RemoveXSS($program_info['directions_map_x']) . '">');
            echo ('        <input type="hidden" id="directions_map_y" value="' . RemoveXSS($program_info['directions_map_y']) . '">');
            echo ('    </div>');
            echo ('    <!-- 자료다운 -->');
            echo ('    <!-- <div class="program_down_w">');
            echo ('        <button type="button" class="button_down_text"><span class="btn_dw_txt">2020아트경기 포스터 다운로드</span></button>');
            echo ('        <button type="button" class="button_down_text"><span class="btn_dw_txt">아트X 리서치형 심의형 PDF 다운로드</span></button>');
            echo ('    </div> -->');
            echo ('</div>');
        } else {
            echo ('        <input type="hidden" id="directions" value="' . RemoveXSS($program_info['directions']) . '">');
        }
        ?>
    </div>

</div>

<?php require_once('./fragment/footer.php'); ?>

<!-- <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=ec6b3e1f28bbc62cb020b79094f74664"></script> REST API 키 -->
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=157370e23b303ffd4b4f4cef2f8c9913"></script> <!-- JavaScript 키로 변경 -->
<script src="./js/program.detail.js"></script>

<?php require_once('./fragment/tail.php'); ?>