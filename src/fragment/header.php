<?php
require_once('head.php');
?>

<?php
include('./common.php');
include('./db_conn.php');
?>

<body>
    <div class="wrap">
        <!-- GNB -->
        <div class="common_gnb_w">
            <!-- lnbtype_main / sticky / 모바일:gnb_open -->
            <div class="artgg_lnb_w">
                <h1 class="artgg_h1_logo">
                    <a href="./index.php" class="logolink_main">
                        <span class="icn icon_logo_gnb"><i class="ir">아트경기</i></span>
                    </a>
                </h1>
                <h2 class="artgg_allmenu_w">
                    <button type="button" class="btn_allmenu">
                        <span class="icn icon_gnb"><i class="ir">아트경기 전체메뉴</i></span>
                    </button>
                </h2>
                <div class="artgg_lnb_inner">
                    <ul id="lnb" class="artgg_lnb">
                        <li class="slnb_inner">
                            <!--활성화시 current 추가-->
                            <a href="./artist.php" class="slnb_link">
                                <!--활성화시 current 추가-->
                                <span class="slnb_txt_box">
                                    <span class="slnb_txt">
                                        Artist
                                    </span>
                                </span>
                                <span class="icn icon_menu_arrow"><i class="ir">서브메뉴 보기</i></span>
                            </a>
                            <ul class="artgg_snb">
                                <li class="ssnb_inner">
                                    <a href="./artist.php" class="ssnb_link">
                                        <span class="ssnb_txt_box">
                                            <span class="ssnb_txt">전체 작가</span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="slnb_inner">
                            <a href="./program.php" class="slnb_link">
                                <span class="slnb_txt_box">
                                    <span class="slnb_txt">
                                        Program
                                    </span>
                                </span>
                                <span class="icn icon_menu_arrow"><i class="ir">서브메뉴 보기</i></span>
                            </a>
                            <ul class="artgg_snb">
                                <?php

                                $sql = "SELECT seq, year, name FROM artgg_program WHERE year = (SELECT max(year) FROM artgg_program) ORDER BY name ASC";
                                $result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
                                $program_count = $result->num_rows;

                                if ($program_count > 0) {
                                    while ($row = $result->fetch_array()) {
                                        echo ('<li class="ssnb_inner">');
                                        echo ('    <a href="./program_detail.php?seq=' . RemoveXSS($row['seq']) . '" class="ssnb_link">');
                                        echo ('        <span class="ssnb_txt_box">');
                                        echo ('            <span class="ssnb_txt">' . RemoveXSS($row['name']) . '</span>');
                                        echo ('        </span>');
                                        echo ('    </a>');
                                        echo ('</li>');
                                    }
                                }

                                $result->free();

                                ?>
                            </ul>
                        </li>
                        <li class="slnb_inner">
                            <a href="./viewingroom.php" class="slnb_link">
                                <span class="slnb_txt_box">
                                    <span class="slnb_txt">
                                        Space
                                    </span>
                                </span>
                                <span class="icn icon_menu_arrow"><i class="ir">서브메뉴 보기</i></span>
                            </a>
                            <ul class="artgg_snb">
                                <li class="ssnb_inner">
                                    <a href="./viewingroom.php" class="ssnb_link">
                                        <!-- 활성화시 ssnb_current 추가-->
                                        <span class="ssnb_txt_box">
                                            <span class="ssnb_txt">뷰잉 룸</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="ssnb_inner">
                                    <a href="./mediaroom.php" class="ssnb_link">
                                        <span class="ssnb_txt_box">
                                            <span class="ssnb_txt">미디어 룸</span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="slnb_inner">
                            <a href="#none" class="slnb_link">
                                <span class="slnb_txt_box">
                                    <span class="slnb_txt">
                                        Art Shop (준비중)
                                    </span>
                                </span>
                                <span class="icn icon_menu_arrow"><i class="ir">서브메뉴 보기</i></span>
                            </a>
                        </li>
                        <li class="slnb_inner">
                            <a href="./about.php" class="slnb_link">
                                <span class="slnb_txt_box">
                                    <span class="slnb_txt">
                                        About
                                    </span>
                                </span>
                                <span class="icn icon_menu_arrow"><i class="ir">서브메뉴 보기</i></span>
                            </a>
                            <ul class="artgg_snb">
                                <li class="ssnb_inner">
                                    <a href="./about.php" class="ssnb_link">
                                        <span class="ssnb_txt_box">
                                            <span class="ssnb_txt">사업 소개</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="ssnb_inner">
                                    <a href="./notice.php" class="ssnb_link">
                                        <span class="ssnb_txt_box">
                                            <span class="ssnb_txt">공지사항</span>
                                        </span>
                                    </a>
                                </li>
                                <!--
                                <li class="ssnb_inner">
                                    <a href="./news.php" class="ssnb_link">
                                        <span class="ssnb_txt_box">
                                            <span class="ssnb_txt">보도자료</span>
                                        </span>
                                    </a>
                                </li>
                                -->
                            </ul>
                        </li>
                    </ul>
                    <button type="button" class="btn_allmenu_x">
                        <span class="icn icon_close"><i class="ir">전체메뉴 닫기</i></span>
                    </button>
                </div>
                <i class="snb_bg"></i>
            </div>
        </div>