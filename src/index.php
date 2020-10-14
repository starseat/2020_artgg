<?php require_once('./fragment/header.php'); ?>

<link rel="stylesheet" type="text/css" href="./css/main.css" media="all" />

<!-- 콘텐츠 -->
<div class="container">

    <!-- popup -->
    <div class="layer_popup_w" id="main-popup-1">
        <div class="layer_popup_inner">
            <div class="popup_image_w">
                <img src="../img/popup_notice.jpg" class="popup_image" alt="공지사항 경기도 정책축제 개최에 따라 온택트 아트경기2020 행사기간 중 10월15일~17일 3일간 경기상상캠퍼스 차량 진입 및 주차 이용이 불가하오니 양해부탁드립니다.">
            </div>
            <button class="btn_popup_close" title="팝업닫기" onclick="closePopup(1)">
                <span class="icn icon_close"><i class="ir">팝업 닫기</i></span>
            </button>
        </div>
    </div>

    <div class="content_inner">
        <div class="section_visual_w">
            <div id="main-swiper-container" class="swiper-container swiper-youtube-container">
                <div class="swiper-wrapper">
                    <?php
                    $sql  = "SELECT seq, sort, file_name, upload_path, storage_type, image_type, link FROM artgg_image WHERE target_type = 'main' ORDER BY sort";
                    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
                    $main_contents_count = $result->num_rows;
                    if ($main_contents_count > 0) {
                        while ($row = $result->fetch_array()) {
                            if ($row['image_type'] == 'I') {
                                $item  = '<div class="swiper-slide"';
                                $item .= ' onclick="moveLink(\'' . RemoveXSS($row['link']) . '\')" ';
                                $item .= ' style="background-image:url(' . getImagePath(RemoveXSS($row['upload_path'])) . ')">';
                                $item .= '</div>';
                                echo $item;
                            } else if ($row['image_type'] == 'V') {
                                echo ('<div class="swiper-slide">');
                                echo ('<div class="swiper-video-container" data-id="' . RemoveXSS($row['file_name']) . '">');
                                echo ('<div class="swiper-video-iframe"></div>');
                                echo ('<div class="swiper-video-play"></div>');
                                echo ('</div>');
                                echo ('</div>');
                            }
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
    </div> <!-- .section_visual_w -->

    <!-- 공지사항 영역-->
    <div class="section_box_w">
        <div class="section_notice_w">
            <div class="notice_cont_l">
                <h2 class="section_title">공지사항</h2>
                <ul class="notice_list">
                    <?php

                    $sql  = "SELECT seq, level, title, view_count, created_at FROM artgg_notice WHERE deleted_at IS NULL ORDER BY seq desc LIMIT 4";
                    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
                    $notice_length = $result->num_rows;

                    if ($notice_length > 0) {
                        while ($row = $result->fetch_array()) {
                            $viewTitle = getNoticeListViewTitme(intval(RemoveXSS($row['level'])), RemoveXSS($row['title']));
                            echo ('<li class="nl_inner">');
                            echo ('<a href="./notice_detail.php?seq=' . RemoveXSS($row['seq']) . '" class="nl_cont">');
                            echo ('<strong class="nl_text">' . $viewTitle . '</strong>');
                            echo ('<span class="nl_date">' . $row['created_at'] . '</span>');
                            echo ('</a>');
                            echo ('</li>');
                        }
                    } else {
                        echo ('<li class="nl_inner">등록된 공지사항이 없습니다.</li>');
                    }

                    $result->free();

                    ?>
                </ul>
            </div>
            <div class="notice_cont_r">
                <div class="notice_slide_w">
                    <div id="artist-thumb-swiper-container">
                        <div class="swiper-wrapper ssl_inner">

                            <?php
                            $sql = "SELECT seq, year, name, en_name, thumbnail FROM artgg_artist WHERE name != 'artist_greeting' ORDER BY name";
                            $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
                            $artist_length = $result->num_rows;

                            if ($artist_length > 0) {
                                while ($artist_info = $result->fetch_array()) {
                                    echo ('<div onclick="goArtistDetail(' . RemoveXSS($artist_info['seq']) . ')" class="swiper-slide" style="background-image:url(' . getImagePath(RemoveXSS($artist_info['thumbnail'])) . ')"></div>');
                                }
                            }

                            $result->free();
                            ?>
                        </div>
                        <!-- Add Pagination -->
                        <div id="artist-thumb-swiper-pagination"></div>
                        <!-- Add Arrows -->
                        <div id="artist-thumb-swiper-button-prev" class="swiper-button-prev"></div>
                        <div id="artist-thumb-swiper-button-next" class="swiper-button-next"></div>
                    </div>
                </div> <!-- .notice_slide_w -->
            </div>
        </div>
    </div>

    <!-- 추진사업 영역-->
    <div class="section_box_w">
        <div class="section_service_w">
            <div class="service_list_w">
                <!-- 세로모듈 -->
                <ul class="service_list">
                    <?php

                    $sql  = "SELECT @rownum:=@rownum+1 as num, program.seq, program.year, program.name, program.thumbnail, ";
                    $sql .= "program.program_date, program.place, program.event, program.introduction ";
                    $sql .= "FROM artgg_program program WHERE (@rownum:=0)=0 AND year = (SELECT max(year) FROM artgg_program) ORDER BY name";
                    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
                    $program_length = $result->num_rows;

                    if ($program_length > 0) {
                        while ($row = $result->fetch_array()) {
                            echo ('<li class="sl_inner">');
                            echo ('    <a href="./program_detail.php?seq=' . RemoveXSS($row['seq']) . '" class="sl_cont">');
                            echo ('        <div class="sl_box_image_w">');
                            echo ('            <div class="sl_box_image">');
                            echo ('                <img src="' . getImagePath(RemoveXSS($row['thumbnail'])) . '" alt="" class="sl_img">');
                            echo ('            </div>');
                            echo ('        </div>');
                            echo ('        <div class="sl_box_inner">');
                            echo ('            <div class="sl_box_text">');
                            echo ('                <div class="sl_text_top">');
                            echo ('                    <span class="slt_num">' . RemoveXSS($row['num']) . '</span>');
                            echo ('                    <span class="slt_info">' . RemoveXSS($row['event']) . '</span>');
                            echo ('                    <span class="slt_date">' . RemoveXSS($row['program_date']) . '</span>');
                            echo ('                    <span class="slt_date_text">' . RemoveXSS($row['place']) . '</span>');
                            echo ('                </div>');
                            echo ('                <span class="slt_text">' . RemoveXSS($row['introduction']) . '</span>');
                            echo ('                <strong class="slt_name">' . RemoveXSS($row['name']) . '</strong>');
                            echo ('            </div>');
                            echo ('        </div>');
                            echo ('    </a>');
                            echo ('</li>');
                        }
                    }

                    $result->free();
                    ?>
                </ul> <!-- .service_list -->
            </div>
        </div>
    </div>

    <!-- 아트경기 소개 영역-->
    <div class="section_box_w">
        <div class="section_info_w">
            <?php
            $sql  = "SELECT seq, introduction FROM artgg_business WHERE type = 'A' LIMIT 1";
            $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
            $artgg_count = $result->num_rows;
            $artgg_info = mysqli_fetch_array($result);
            $artgg_seq = 0;
            $result->free();
            if ($artgg_count > 0) {
                $artgg_seq = intval(RemoveXSS($artgg_info['seq']));

                $sql  = "SELECT file_name, upload_path FROM artgg_image WHERE target_seq = $artgg_seq AND target_type = 'business' AND sort = 1";
                $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
                $artgg_img_info = mysqli_fetch_array($result);
                $result->free();

                echo ('<span class="info_image"><img src="' . getImagePath(RemoveXSS($artgg_img_info['upload_path'])) . '" alt="아트경기" class="info_img"></span>');
                echo ('<p class="info_text_w">');
                echo ($artgg_info['introduction']);
                echo ('</p>');
            }
            ?>
        </div>
    </div>
</div>

</div>

<?php require_once('./fragment/footer.php'); ?>

<script src="./js/main.js"></script>

<?php require_once('./fragment/tail.php'); ?>