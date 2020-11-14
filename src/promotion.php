<?php require_once('./fragment/header.php'); ?>

<?php

// 게시굴 수
$item_row_count = 10;
// 하단 페이지 block 수 (1, 2, 3, 4, ...  이런거)
$page_block_count = 10;

$sql = "SELECT COUNT(*) FROM artgg_promotion WHERE deleted_at IS NULL";

$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$total_count = mysqli_fetch_array($result);
$total_count = intval($total_count[0]);
$result->free();

// 현재 페이지
$page = isset($_GET['page']) ? trim($_GET['page']) : 1;
$paging_info = getPagingInfo($page, $total_count, $item_row_count, $page_block_count);

?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
<link href="./css/promotion.css" type="text/css" rel="stylesheet">

<div class="container">
    <div class="content_inner">
        <h2 class="content_title">홍보자료</h2>
        <br>
        <table class="table table-hover table-hover-pointer">
            <colgroup>
                <col width="8%">
                <col width="57%">
                <col width="20%">
                <col width="15%">
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

                $sql  = "SELECT promotion.seq, promotion.title, promotion.view_count, promotion.created_at, ";
                $sql .= " (SELECT count(*) as file_count FROM artgg_file WHERE target_type = 'promotion' AND target_seq = promotion.seq) as file_count";
                $sql .= " FROM artgg_promotion promotion ";
                $sql .= " WHERE deleted_at IS NULL ORDER BY seq desc LIMIT " . $paging_info['page_db'] . ", $item_row_count";
                $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
                $promotion_length = $result->num_rows;

                if ($promotion_length > 0) {
                    while ($row = $result->fetch_array()) {
                        $viewTitle = RemoveXSS($row['title']);
                        if (intval($row['file_count']) > 0) {
                            $viewTitle = '<i class="fa fa-paperclip"></i> ' . $viewTitle;
                        }
                        echo ('<tr onclick=getPromotionInfo(' . RemoveXSS($row['seq']) . ')>');
                        echo ('    <th scope="row">' . RemoveXSS($row['seq']) . '</th>');
                        echo ('    <td class="promotion-title">' . $viewTitle . '</td>');
                        echo ('    <td>' . $row['created_at'] . '</td>');
                        echo ('    <td>' . RemoveXSS($row['view_count']) . '</td>');
                        echo ('</tr>');
                    }
                } else {
                    echo ('<tr><th scope="row"></th><td>등록된 홍보자료가 없습니다.</td><td></td><td></td></tr>');
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
                        echo ('    <a class="page-link page-link-dark" href="./promotion.php?page=' . $paging_info['page_prev'] . '" aria-label="Previous">');
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
                            echo ('<li class="page-item"><a class="page-link page-link-dark" href="./promotion.php?page=' . $i . '" >' . $i . '</a></li>');
                        }
                    }
                    ?>
                    <?php
                    if ($paging_info['page_next'] < $paging_info['page_total']) {
                        echo ('<li class="page-item">');
                        echo ('    <a class="page-link page-link-dark" href="./promotion.php?page=' . $paging_info['page_next'] . '" aria-label="Next">');
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
    function getPromotionInfo(seq) {
        location.href = './promotion_detail.php?seq=' + seq;
    }
</script>

<?php require_once('./fragment/tail.php'); ?>