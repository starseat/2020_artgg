<?php require_once('./fragment/header.php'); ?>

<?php

// 게시굴 수
$item_row_count = 10;
// 하단 페이지 block 수 (1, 2, 3, 4, ...  이런거)
$page_block_count = 10;

$sql = "SELECT COUNT(*) FROM artgg_notice WHERE deleted_at IS NULL";

$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$total_count = mysqli_fetch_array($result);
$total_count = intval($total_count[0]);
$result->free();

// 현재 페이지
$page = isset($_GET['page']) ? trim($_GET['page']) : 1;
$paging_info = getPagingInfo($page, $total_count, $item_row_count, $page_block_count);

?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<link href="./css/notice.css" type="text/css" rel="stylesheet">

<div class="container">
    <div class="content_inner">
        <div class="section_box_w">
            <h2 class="content_title">Space</h2>
        </div>
        <br>
        <table class="table table-hover table-hover-pointer">
            <colgroup>
                <col width="10%" />
                <col width="60%" />
                <col width="20%" />
                <col width="10%" />
            </colgroup>
            <thead class="thead-dark">
                <tr>
                    <th scope="col">no</th>
                    <th scope="col">제목</th>
                    <th scope="col">등록일</th>
                    <th scope="col">조회수</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $sql  = "SELECT seq, level, title, view_count, created_at FROM artgg_notice WHERE deleted_at IS NULL ORDER BY seq desc LIMIT " . $paging_info['page_db'] . ", $item_row_count";
                $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
                $notice_length = $result->num_rows;

                if ($notice_length > 0) {
                    while ($row = $result->fetch_array()) {
                        $viewTitle = getNoticeListViewTitme(intval(RemoveXSS($row['level'])), RemoveXSS($row['title']));
                        echo ('<tr onclick=getNoticeInfo(' . RemoveXSS($row['seq']) . ')>');
                        echo ('    <th scope="row">' . RemoveXSS($row['seq']) . '</th>');
                        echo ('    <td class="notice-title">' . $viewTitle . '</td>');
                        echo ('    <td>' . $row['created_at'] . '</td>');
                        echo ('    <td>' . RemoveXSS($row['view_count']) . '</td>');
                        echo ('</tr>');
                    }
                } else {
                    echo ('<tr><th scope="row"></th><td>등록된 공지사항이 없습니다.</td><td></td><td></td></tr>');
                }

                $result->free();

                ?>
            </tbody>
        </table>

        <div class="mt-4 d-flex justify-content-center">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php
                    if ($paging_info['page_prev'] > 0) {
                        echo ('<li class="page-item">');
                        echo ('    <a class="page-link page-link-dark" href="./notice.php?page=' . $paging_info['page_prev'] . '" aria-label="Previous">');
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
                            echo ('<li class="page-item"><a class="page-link page-link-dark" href="./notice.php?page=' . $i . '" >' . $i . '</a></li>');
                        }
                    }
                    ?>
                    <?php
                    if ($paging_info['page_next'] < $paging_info['page_total']) {
                        echo ('<li class="page-item">');
                        echo ('    <a class="page-link page-link-dark" href="./notice.php?page=' . $paging_info['page_next'] . '" aria-label="Next">');
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

<script>
    function getNoticeInfo(seq) {
        location.href = './notice_detail.php?seq=' + seq;
    }
</script>

<?php require_once('./fragment/tail.php'); ?>