<?php require_once('./fragment/header.php'); ?>

<!-- 콘텐츠 -->
<div class="container">
    <div class="content_inner">
        <div class="section_box_w">
            <h2 class="content_title">보도자료</h2>
            <!-- <h3 class="content_title_d">서브텍스트있을경우해당태그사용</h3> -->
            <!-- 보도자료 -->
            <div class="section_report_w">
                <ul class="text_link_list">
                    <?php

                    $sql = "SELECT title, link FROM artgg_press_release ORDER BY seq DESC";
                    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));

                    while ($row = $result->fetch_array()) {
                        echo ('<li class="tl_inner">');
                        echo ('    <a href="' . RemoveXSS($row['link']) . '" class="tl_cont" target="_blank" >');
                        echo ('        <span class="text">' . RemoveXSS($row['title']) . '</span>');
                        echo ('        <span class="line -right"></span>');
                        echo ('        <span class="line -top"></span>');
                        echo ('        <span class="line -left"></span>');
                        echo ('        <span class="line -bottom"></span>');
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

<?php require_once('./fragment/footer.php'); ?>

<?php require_once('./fragment/tail.php'); ?>