<?php require_once('fragment/content_layout.php'); ?>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

<script>
    const _visit_main_list = {
        date: [],
        count: []
    };
    const _visit_viewing_list = {
        date: [],
        count: []
    };
</script>
<?php

include('common.php');
include('db_conn.php');

$today = date("Ymd");

function changeDateFormat($_dateStr)
{
    return substr($_dateStr, 0, 4)
        . '-' . substr($_dateStr, 4, 2)
        . '-' . substr($_dateStr, 6, 2);
}

// ----------------------------------------------------------------------------------------------------
// visit - main
$sql = "SELECT IFNULL(SUM(count), 0) as total FROM artgg_visit WHERE type = 'main'";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$visit_main_total = $result->fetch_array();
$result->free();

$sql = "SELECT IFNULL(SUM(count), 0) as count FROM artgg_visit WHERE date = '" . $today . "' AND type = 'main'";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$visit_main_today = $result->fetch_array();
$result->free();

$sql = "SELECT temp2.* FROM (SELECT temp1.* FROM artgg_visit as temp1 WHERE type = 'main' ORDER BY date DESC LIMIT 7) as temp2 ORDER BY temp2.date ASC ";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
echo '<script>';
while ($row = $result->fetch_array()) {
    echo " _visit_main_list.date.push('" . changeDateFormat($row['date']) . "'); ";
    echo " _visit_main_list.count.push(" . $row['count'] . "); ";
}
echo '</script>';
$result->free();


// ----------------------------------------------------------------------------------------------------
// visit - viewingroom
$sql = "SELECT IFNULL(SUM(count), 0) as total FROM artgg_visit WHERE type = 'viewingroom'";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$visit_viewingroom_total = $result->fetch_array();
$result->free();

$sql = "SELECT IFNULL(SUM(count), 0) as count FROM artgg_visit WHERE date = '" . $today . "' AND type = 'viewingroom'";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
$visit_viewingroom_today = $result->fetch_array();
$result->free();

$sql = "SELECT temp2.* FROM (SELECT temp1.* FROM artgg_visit as temp1 WHERE type = 'viewingroom' ORDER BY date DESC LIMIT 7) as temp2 ORDER BY temp2.date ASC ";
$result = mysqli_query($conn, $sql) or exit(mysqli_error($conn));
echo '<script>';
while ($row = $result->fetch_array()) {
    echo " _visit_viewing_list.date.push('" . changeDateFormat($row['date']) . "'); ";
    echo " _visit_viewing_list.count.push(" . $row['count'] . "); ";
}
echo '</script>';
$result->free();

?>


<h1 class="mt-4">방문자 수</h1>

<div class="row" style="text-align: right;">
    <div class="col-md-6"></div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-xl-4"><input id="excel_start_date" class="date-picker form-control" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" pattern="\d{4}-\d{2}-\d{2}"></div>
            <div class="col-xl-1">~ </div>
            <div class="col-xl-4"><input id="excel_end_date" class="date-picker form-control" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" pattern="\d{4}-\d{2}-\d{2}"></div>
            <div class="col-xl-3"><button class="btn btn-outline-dark" onclick="getExcelVisitData();">Excel 다운로드</button></div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-light mb-4">
            <div class="card-body row justify-content-between">
                <div class="col-8">오늘 방문자 수</div>
                <div class="col-4" style="text-align: right;"><span class="badge badge-light"><?php echo $visit_main_today['count']; ?></span></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-secondary text-white mb-4">
            <div class="card-body row justify-content-between">
                <div class="col-8">누적 방문자 수</div>
                <div class="col-4" style="text-align: right;"><span class="badge badge-light"><?php echo $visit_main_total['total']; ?></span></div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-light mb-4">
            <div class="card-body row justify-content-between">
                <div class="col-8">뷰잉룸 방문자 수</div>
                <div class="col-4" style="text-align: right;"><span class="badge badge-light"><?php echo $visit_viewingroom_today['count']; ?></span></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-secondary text-white mb-4">
            <div class="card-body row justify-content-between">
                <div class="col-8">뷰잉룸 누적 방문자 수</div>
                <div class="col-4" style="text-align: right;"><span class="badge badge-light"><?php echo $visit_viewingroom_total['total']; ?></span></div>
            </div>
        </div>
    </div>
</div>

<div class="row  mt-4">
    <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-area mr-1"></i>
                방문자 수
            </div>
            <div class="card-body"><canvas id="visit_main_bar_chart" width="100%" height="40"></canvas></div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-bar mr-1"></i>
                뷰잉룸 방문자 수
            </div>
            <div class="card-body"><canvas id="visit_viewroom_bar_chart" width="100%" height="40"></canvas></div>
        </div>
    </div>
</div>

<?php
mysqli_close($conn);
flush();
?>

<?php require_once('fragment/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ko-KR.js"></script>

<script src="./vendor/jw-excel/sheetjs/xlsx.full.min.js"></script>
<script src="./vendor/jw-excel/FileSaver/FileSaver.min.js"></script>
<script src="./vendor/jw-excel/jw.excel.js"></script>

<script src="./js/common.js"></script>
<script src="./js/visit.js"></script>

<?php require_once('fragment/tail.php'); ?>