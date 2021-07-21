<?php require_once('./fragment/header.php'); ?>

<!-- 콘텐츠 -->
<div class="container">
    <div class="content_inner">
        <div class="section_box_w">
            <h2 class="content_title">Artists</h2>
            <!-- <p class="content_info_text" id="artist_info_text"></p> -->
            <!-- 옵션 select -->
            <div class="select_box_w">
                <label for="yearSelect"><i class="blind">연도를 선택해주세요</i></label>
                <select id="yearSelect" name="yearSelect" title="연도를 선택해주세요">
                    <option value="0">전체</option>
                    <?php
                    $sql  = "SELECT distinct year FROM artgg_artist WHERE name != 'artist_greeting' ORDER BY year desc";
                    $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
                    $year_length = $result->num_rows;
                    
                    // 전체가 아닌 첫번째 항목이 선택되도록 수정
                    $yearIsFirst = true;  // selected=selected
                    while ($year_row = $result->fetch_array()) {
                        $yearOption = '<option value="' . RemoveXSS($year_row['year']) . '"';
                        
                        if($yearIsFirst) {
                            $yearOption = $yearOption . ' selected=selected ';
                            $yearIsFirst = false;
                        }

                        $yearOption = $yearOption . '>' . RemoveXSS($year_row['year']) . '</option>';

                        echo $yearOption;
                    }
                    $result->free();
                    ?>
                </select>
            </div>
        </div>
        <div class="module_image_list_w artist_list_w">
            <ul class="module_image_list" id="artist_list">
            </ul>
        </div>
    </div>

</div>

<?php require_once('./fragment/footer.php'); ?>

<script src="./js/artist.js"></script>

<?php require_once('./fragment/tail.php'); ?>