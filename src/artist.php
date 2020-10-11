<?php require_once('./fragment/header.php'); ?>

<!-- 콘텐츠 -->
<div class="container">
    <div class="content_inner">
        <div class="section_box_w">
            <h2 class="content_title">Artist</h2>
            <p class="content_info_text" id="artist_info_text"></p>
        </div>
        <div class="module_image_list_w">
            <ul class="module_image_list" id="artist_list">
                <li class="mdil_inner">
                    <a href="#none" class="mdil_cont">
                        <span class="mdil_thumb_w">
                            <img src="//via.placeholder.com/220x220" alt="작가명제공" class="mdil_image">
                        </span>
                        <strong class="mdil_text_w"><!-- 작가이름 추가된부분!!! -->
                           <span class="mdil_text">작가이름노출 작가이름노출 작가이름노출 작가이름노출</span>
                        </strong>
                    </a>
                </li>
            </ul>
        </div>
    </div>

</div>

<?php require_once('./fragment/footer.php'); ?>

<script src="./js/artist.js"></script>

<?php require_once('./fragment/tail.php'); ?>