<?php require_once('./fragment/header.php'); ?>

<style>
    #target_mediaroom_title {
        height: 156px;
    }

    .section_mediaroom_w {
        margin-top: 2rem;
    }
</style>

<!-- 콘텐츠 -->
<div class="container">
    <div class="content_inner">
        <div class="section_box_w">
            <h2 class="content_title">VIEWING ROOMS</h2>
            <h3 class="content_title_d">미디어룸</h3>
            
            <!-- 미디어룸 -->
            <div class="section_mediaroom_w">
                <div class="mediaroom_vod_w">
                    <div class="vod_inner_box" id="target_youtube_box">
                        <iframe id="target_youtube_view" width="560" height="315" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <strong class="vod_info_text" id="target_mediaroom_title"></strong>
                </div>
                <div class="module_media_list_w">
                    <ul class="horizontal_thumbnail_w">
                        <?php
                        $sql = "SELECT seq, title, link, youtube_id FROM artgg_mediaroom ORDER BY seq DESC";
                        $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

                        while ($row = $result->fetch_array()) {
                            echo ('<li class="ht_inner">');
                            // echo ('    <a class="ht_link" href="' . RemoveXSS($row['link']) . '" target="_blank">');
                            echo ('    <a class="ht_link" href="#">');
                            echo ('        <span class="ht_img_w">');
                            echo ('            <img class="ht_img" src="https://img.youtube.com/vi/' . RemoveXSS($row['youtube_id']) . '/default.jpg" width="100%" alt="' . RemoveXSS($row['title']) . '">');
                            echo ('        </span>');
                            echo ('        <div class="ht_cont_w">');
                            echo ('            <strong class="ht_title_w">');
                            echo ('                <span class="ht_title">' . RemoveXSS($row['title']) . '</span>');
                            echo ('            </strong>');
                            echo ('        </div>');
                            echo ('        <input type="hidden" class="ht_youtube_link" value="' . RemoveXSS($row['link']) . '">');
                            echo ('        <input type="hidden" class="ht_youtube_id" value="' . RemoveXSS($row['youtube_id']) . '">');
                            echo ('    </a>');
                            echo ('</li>');
                        }

                        $result->free();
                        ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

<?php require_once('./fragment/footer.php'); ?>

<script src="./js/common.js"></script>
<script src="./js/mediaroom.js"></script>

<?php require_once('./fragment/tail.php'); ?>