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
                    <strong class="bns_text"><?php echo RemoveXSS($artgg_info['introduction']); ?></strong>
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