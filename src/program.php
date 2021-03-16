<?php require_once('./fragment/header.php'); ?>

<!-- 콘텐츠 -->
<div class="container">
    <div class="content_inner">
        <div class="section_box_w">
            <h2 class="content_title">Programs</h2>
            <div class="list_title_w">
                <h3 class="list_title">아트경기 | Art Gyeonggi 프로그램</h3>
                <!-- 옵션 select -->
                <div class="select_box_w">
                    <label for="yearSelect"><i class="blind">연도를 선택해주세요</i></label>
                    <select id="yearSelect" name="yearSelect" title="연도를 선택해주세요">
                        <option value="title" selected=selected>전체</option>
                        <?php
                        $sql  = "SELECT distinct year FROM artgg_program ORDER BY year desc";
                        $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
                        $year_length = $result->num_rows;

                        while ($year_row = $result->fetch_array()) {
                            echo ('<option value="' . RemoveXSS($year_row['year']) . '">' . RemoveXSS($year_row['year']) . '</option>');
                        }
                        $result->free();
                        ?>
                    </select>
                </div>
            </div>

            <div class="section_programlist_w">
                <ul class="program_list" id="program_list">
                    <?php
                    $sql = "SELECT seq, year, name, thumbnail, program_date, place FROM artgg_program ORDER BY year DESC, name ASC";
                    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
                    while ($row = $result->fetch_array()) {
                        echo ('<li class="pl_inner">');
                        echo ('    <a href="./program_detail.php?seq=' . RemoveXSS($row['seq']) . '" class="pl_cont">');
                        echo ('        <span class="program_thumb_w">');
                        echo ('            <img src="' . getImagePath(RemoveXSS($row['thumbnail'])) . '" alt="' . RemoveXSS($row['name']) . '" class="program_image">');
                        echo ('        </span>');
                        echo ('        <div class="program_text_w">');
                        echo ('            <strong class="ptext_name">' . RemoveXSS($row['name']) . '</strong>');
                        echo ('            <span class="ptext_date">' . RemoveXSS($row['program_date']) . '</span>');
                        // echo ('            <span class="ptext_host">' . RemoveXSS($row['place']) . '</span>');  // 장소 삭제 요청 받음. - 2020.10.12
                        echo ('        </div>');
                        echo ('    </a>');
                        echo ('</li>');
                    }
                    ?>

                </ul>
            </div>
        </div>
    </div>

</div>

<?php require_once('./fragment/footer.php'); ?>

<script src="./js/program.js"></script>

<?php require_once('./fragment/tail.php'); ?>