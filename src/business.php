<?php require_once('./fragment/header.php'); ?>

<link href="./css/business.css" type="text/css" rel="stylesheet">

<?php

$sql  = "SELECT seq, name, type, thumbnail, introduction FROM artgg_business WHERE type = 'A' LIMIT 1";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$artgg_count = $result->num_rows;
$artgg_info = mysqli_fetch_array($result);
$artgg_seq = 0;
if ($artgg_count > 0) {
    $artgg_seq = intval(RemoveXSS($artgg_info['seq']));
}
$result->free();

?>

<!-- 콘텐츠 -->
<div class="container">
    <div class="content_inner">
        <div class="business_info_w">
            <div class="section_artgg_text">

                <!-- Swiper -->
                <div class="artgg_swiper_w">
                    <div class="swiper-container bns_artgg_logo" id="business-artgg-image-swiper-container">
                        <div class="swiper-wrapper">
                            <?php
                            $sql  = "SELECT seq, sort, file_name, upload_path, storage_type, image_type FROM artgg_image WHERE target_seq = $artgg_seq AND target_type = 'business' ORDER BY sort";
                            $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
                            $artgg_contents_count = $result->num_rows;
                            $artgg_contents_list = array();
                            while ($row = $result->fetch_array()) {
                                echo ('<div class="swiper-slide">');
                                if ($row['image_type'] == 'I') {
                                    echo ('<img class="swiper-lazy" src="' . RemoveXSS($row['upload_path']) . '" alt="2020 아트경기">');
                                } else if ($row['image_type'] == 'V') {
                                    $item  = '<iframe class="swiper-youtube-view" src="https://www.youtube.com/embed/';
                                    $item .= RemoveXSS($row['file_name']);
                                    $item .= '?rel=0&enablejsapi=1" ';
                                    $item .= 'frameborder="0" ';
                                    $item .= 'allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" ';
                                    $item .= 'allowfullscreen></iframe>';
                                    echo $item;
                                }
                                echo ('</div>');
                            }
                            $result->free();
                            ?>
                        </div>

                        <!-- Add Pagination -->
                        <div class="swiper-pagination swiper-move-button"></div>
                        <!-- Add Navigation -->
                        <div class="swiper-button-prev swiper-button-color swiper-move-button"></div>
                        <div class="swiper-button-next swiper-button-color swiper-move-button"></div>
                    </div>
                </div>
                <div class="bns_text_box">
                    <strong class="bns_text">
                        <?php
                        // 고객사 요청으로 아래 텍스트로 대체
                        //echo RemoveXSS($artgg_info['introduction']); 
                        ?>
                        <p> 경기도와 경기문화재단은 지난 2016년부터 매년 경기도 미술품 유통활성화 사업인 ‘아트경기’를 개최해왔습니다. 아트경기는 경기도 시각예술분야 작가의 창작활동이 지속될 수 있는 환경을 조성합니다. 이와 함께 미술품 전문사업자의육성을 지원하여 선순환적인 미술시장 형성에 기여하고자 합니다.</p><br>
                        <p>무명의 작가가 그려낸 작품이 다음 세대에도 사랑받는 유명작품으로 성장하기 까지는 미술시장의 역할이 중요합니다. 이곳에서 작품은 가치를 평가받고, 작가의 창작이 확대될 수 있는 장(場)을 제공합니다.</p><br>
                        <p>아트경기는 미술시장을 구성하는 창작, 유통, 향유 세 분야의 역할에 주목합니다. 올해 2020 아트경기 사업 공모를 통해 선정된 60인의 시각예술작가와 6곳의 협력사업자는 경기도 내외 각지에서 풍성하고 다채로운 내용이 담긴 미술 시장을 선보입니다.</p><br>
                        <p>그림을 소장한다는 것은 결코 쉬운 일이 아닐 것입니다. 아트경기는 경기도 시각예술인의 작품이 도민의 일상으로, 그리고 개인의 삶으로 가까이 하고 향유될 수 있기를 기대합니다.</p><br>
                        <p>마지막으로 2020 아트경기를 위해 참여해주신 경기도 작가와 협력사업자를 비롯한 모든 분들과 수고해주신 관계자 분들께 감사드립니다.</p><br>
                        <div style="text-align: right;">
                            <p>경기문화재단 대표이사</p>
                            <p>강 헌</p>
                        </div>
                    </strong>
                </div>
            </div>
            <!-- 협력사업자 -->
            <div class="business_list_box">
                <h3 class="list_title">2020 아트경기 협력사업자</h3>
                <div class="module_image_list_w">
                    <ul class="module_image_list">
                        <?php

                        $sql = "SELECT seq, name, type, thumbnail FROM artgg_business WHERE type = 'P' ORDER BY seq";
                        $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
                        while ($row = $result->fetch_array()) {
                            echo ('<li class="mdil_inner">');
                            echo ('    <a href="./partners.php?seq=' . RemoveXSS($row['seq']) . '" class="mdil_cont">');
                            echo ('        <span class="mdil_thumb_w">');
                            echo ('            <img src="' . getImagePath(RemoveXSS($row['thumbnail'])) . '" alt="' . RemoveXSS($row['name']) . '" class="mdil_image">');
                            echo ('        </span>');
                            echo ('    </a>');
                            echo ('</li>');
                        }

                        $result->free();

                        ?>
                    </ul>
                </div>
            </div>

            <!-- 아트경기작가 -->
            <div class="artgg_artist_list_box">
                <h3 class="list_title">2020 아트경기 작가</h3>
                <ul class="artgg_artist_list">
                    <?php

                    $sql  = "SELECT seq, year, name, en_name, thumbnail FROM artgg_artist ";
                    $sql .= "WHERE name != 'artist_greeting' ";
                    $sql .= "AND year = (SELECT max(artist.year) FROM artgg_artist artist WHERE name != 'artist_greeting') ";
                    $sql .= "ORDER BY name";

                    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

                    while ($row = $result->fetch_array()) {
                        echo ('<li class="aal_name"><a href="./artist_detail.php?seq=' . RemoveXSS($row['seq']) . '" class="all_link">' . RemoveXSS($row['name']) . '</a></li>');
                    }

                    $result->free();

                    ?>
                </ul>
            </div>
        </div>
    </div>

</div>

<?php require_once('./fragment/footer.php'); ?>

<script src="./js/business.js"></script>

<?php require_once('./fragment/tail.php'); ?>