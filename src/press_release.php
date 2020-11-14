<?php require_once('./fragment/header.php'); ?>

<?php

// 게시굴 수
$item_row_count = 10;
// 하단 페이지 block 수 (1, 2, 3, 4, ...  이런거)
$page_block_count = 10;

$sql = "SELECT COUNT(*) FROM artgg_press_release WHERE deleted_at IS NULL";

$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$total_count = mysqli_fetch_array($result);
$total_count = intval($total_count[0]);
$result->free();

// 현재 페이지
$page = isset($_GET['page']) ? trim($_GET['page']) : 1;
$paging_info = getPagingInfo($page, $total_count, $item_row_count, $page_block_count);

?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<link href="./css/press_release.css" type="text/css" rel="stylesheet">

<!-- 콘텐츠 -->
<div class="container">
    <div class="content_inner">
        <div class="section_box_w">
            <h2 class="content_title">언론보도</h2>
            <!-- <h3 class="content_title_d">서브텍스트있을경우해당태그사용</h3> -->
            <!-- 언론보도 -->
            <div class="section_report_w">
                <ul class="text_link_list">
                    <?php

                    // $sql = "SELECT title, link FROM artgg_press_release WHERE deleted_at IS NULL ORDER BY seq DESC";
                    $sql  = "SELECT title, link FROM artgg_press_release WHERE deleted_at IS NULL ORDER BY seq desc LIMIT " . $paging_info['page_db'] . ", $item_row_count";
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

        <div class="mt-4 d-flex justify-content-center">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php
                    if ($paging_info['page_prev'] > 0) {
                        echo ('<li class="page-item">');
                        echo ('    <a class="page-link page-link-dark" href="./press_release.php?page=' . $paging_info['page_prev'] . '" aria-label="Previous">');
                        echo ('        <span aria-hidden="true">&laquo;</span>');
                        echo ('    </a>');
                        echo ('</li>');
                    }
                    ?>
                    <?php
                    for ($i = $paging_info['page_start']; $i <= $paging_info['page_end']; $i++) {
                        if ($i == $page) {
                            echo ('<li class="page-item active-dark"><a class="page-link page-link-dark" href="#">' . $i . '</a></li>');
                        } else {
                            echo ('<li class="page-item"><a class="page-link page-link-dark" href="./press_release.php?page=' . $i . '" >' . $i . '</a></li>');
                        }
                    }
                    ?>
                    <?php
                    if ($paging_info['page_next'] < $paging_info['page_total']) {
                        echo ('<li class="page-item">');
                        echo ('    <a class="page-link page-link-dark" href="./press_release.php?page=' . $paging_info['page_next'] . '" aria-label="Next">');
                        echo ('        <span aria-hidden="true">&raquo;</span>');
                        echo ('    </a>');
                        echo ('</li>');
                    }
                    ?>
                </ul>
            </nav>
        </div>

    </div>

</div>

<?php require_once('./fragment/footer.php'); ?>

<?php require_once('./fragment/tail.php'); ?>