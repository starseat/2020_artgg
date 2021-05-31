$(function() {
    initChartDateLabel();
    loadVisitBarChart_main();
    loadVisitBarChart_viewingroom();

    initDate();
});

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';


let _chart_date_label_list = [];
function initChartDateLabel() {
    if(_chart_date_label_list.length == 7) {
        return _chart_date_label_list;
    }
    
    _chart_date_label_list = [];
    _chart_date_label_list.length = 0;
    for(let i=6; i>=0; i--) {
        let dateObj = new Date();
        let _tempDate;

        if(i > 0) {
            _tempDate = dateObj.getTime() - (i * 24 * 60 * 60 * 1000);
            dateObj.setTime(_tempDate);
        } 

        let year = dateObj.getFullYear();
        let month = dateObj.getMonth() + 1;
        let day = dateObj.getDate();

        if(month < 10) { month = '0' + month; }
        if(day < 10) { day = '0' + day; }

        let dateString = year + '-' + month + '-' + day;
        _chart_date_label_list.push(dateString);
    }
}

function loadVisitBarChart_main() {
    var _chart = document.getElementById('visit_main_bar_chart');
    var _lineChart = new Chart(_chart, {
        type: 'bar',
        data: {
            labels: _visit_main_list.date,
            datasets: [{
                label: "방문자 수 ", 
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: _visit_main_list.count,
            }],
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }, 
                    gridLines: {
                        display: true
                    }
                }]
            }, 
            legend: {
                display: false
            }
        }
    });

    return _lineChart;
}

function loadVisitBarChart_viewingroom() {
    var _chart = document.getElementById('visit_viewroom_bar_chart');
    var _lineChart = new Chart(_chart, {
        type: 'bar',
        data: {
            labels: _visit_viewing_list.date,
            datasets: [{
                label: "방문자 수 ", 
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: _visit_viewing_list.count,
            }],
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }, 
                    gridLines: {
                        display: true
                    }
                }]
            }, 
            legend: {
                display: false
            }
        }
    });

    return _lineChart;
}

function initDate() {
    let lastWeekDate = new Date();
    let dayOfMonth = lastWeekDate.getDate();
    lastWeekDate.setDate(dayOfMonth - 6);
    $('#excel_start_date').val(getFormatDate(lastWeekDate));
    $('#excel_end_date').val(getFormatDate(new Date()));
}

function getFormatDate(_date) {
    let year = _date.getFullYear();
    let month = (1 + _date.getMonth());
    month = month >= 10 ? month : '0' + month;
    let day = _date.getDate();
    day = day >= 10 ? day : '0' + day;
    return year + '-' + month + '-' + day;
}

function getExcelVisitData() {
    const startDate = $('#excel_start_date').val();
    const endDate = $('#excel_end_date').val();

    if(startDate > endDate) {
        alert('시작날짜는 종료날짜보다 클 수 없습니다.');
        return false;
    }

    const dateObj = {
        start: startDate.replace('-', '').replace('-', ''), 
        end: endDate.replace('-', '').replace('-', '')
    };

    console.log('[getExcelVisitData] dateObj:: ', dateObj);

    $.ajax({
        type: 'get',
        data: dateObj, 
        url: './action/visit_excel_get.php',
        success: function (result) {
            // console.log('[getExcelVisitData] result:: ', result);
            const resultObj = JSON.parse(result);
            // console.log('[getExcelVisitData] resultObj:: ', resultObj);
            const excelData = resultObj.visit_excel_data;
            if(excelData.length > 0) {
                JwExcel.exportExcel(excelData, '아트경기_방문자수');
            }
            else {
                alert('엑셀로 출력할 데이터가 없습니다.');
            }
        }, 
        error: function (xhr, status, error) {
            console.error('[getExcelVisitData] ajax error:: ', error);
        },
        
    });
}

function timeFunctionLong(input) {
    setTimeout(function() {
        input.type = 'text';
    }, 60000);
}