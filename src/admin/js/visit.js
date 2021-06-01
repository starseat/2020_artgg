$(function() {
    initChartDateLabel(); 
    initDate();

    //loadVisitBarChart_main();
    //loadVisitBarChart_viewingroom();
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

let _main_chart = null;
let _viewing_chart = null;
function loadVisitBarChart_main() {
    var _chart = document.getElementById('visit_main_bar_chart');
    //var _lineChart = new Chart(_chart, {
    _main_chart = new Chart(_chart, {
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
}

function loadVisitBarChart_viewingroom() {
    var _chart = document.getElementById('visit_viewroom_bar_chart');
    //var _lineChart = new Chart(_chart, {
    _viewing_chart = new Chart(_chart, {
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
}

function initDate() {
    let lastWeekDate = new Date();
    let dayOfMonth = lastWeekDate.getDate();
    lastWeekDate.setDate(dayOfMonth - 6);
    $('#search_start_date').val(getFormatDate(lastWeekDate));
    $('#search_end_date').val(getFormatDate(new Date()));

    getVisitData('chart');
}

function getFormatDate(_date) {
    let year = _date.getFullYear();
    let month = (1 + _date.getMonth());
    month = month >= 10 ? month : '0' + month;
    let day = _date.getDate();
    day = day >= 10 ? day : '0' + day;
    return year + '-' + month + '-' + day;
}

function getVisitData(_type) {
    const startDate = $('#search_start_date').val();
    const endDate = $('#search_end_date').val();

    if(startDate > endDate) {
        alert('시작날짜는 종료날짜보다 클 수 없습니다.');
        return false;
    }

    if(typeof _type == 'undefined' || _type == null) {
        _type = '';
    }

    const dateObj = {
        start: startDate.replace('-', '').replace('-', ''), 
        end: endDate.replace('-', '').replace('-', '')
    };

    //console.log('[getVisitData] dateObj:: ', dateObj);

    $.ajax({
        type: 'get',
        data: dateObj, 
        url: './action/visit_get.php',
        success: function (result) {
            // console.log('[getVisitData] result:: ', result);
            const resultObj = JSON.parse(result);
            // console.log('[getVisitData] resultObj:: ', resultObj);
            const visitData = resultObj.visit_data;
            if(_type == 'excel') {
                outputExcel(visitData);
            }
            else {
                outputChart(visitData);
            }
        }, 
        error: function (xhr, status, error) {
            console.error('[getVisitData] ajax error:: ', error);
        },
        
    });
}

function outputChart(_visit_data) {
    chartClear();

    if(_visit_data.length > 0) {
        for(var i=0; i<_visit_data.length; i++) {
            _visit_main_list.date.push(changeDateFormat(_visit_data[i].MainView));
            _visit_main_list.count.push(_visit_data[i].MainCount);

            _visit_viewing_list.date.push(changeDateFormat(_visit_data[i].ViewingRoomView));
            _visit_viewing_list.count.push(_visit_data[i].ViewingRoomCount);
        }

        loadVisitBarChart_main();
        loadVisitBarChart_viewingroom();
    }
}

function outputExcel(_visit_data) {
    if(_visit_data.length > 0) {
        JwExcel.exportExcel(_visit_data, '아트경기_방문자수');
    }
    else {
        alert('엑셀로 출력할 데이터가 없습니다.');
    }
}

function changeDateFormat(_date) {
    return _date.substr(0, 4)
        + '-' + _date.substr(4, 2)
        + '-' + _date.substr(6, 2);
}

function chartClear() {
    _visit_main_list.date = [];
    _visit_main_list.count = [];

    _visit_viewing_list.date = [];
    _visit_viewing_list.count = [];

    if(_main_chart != null) {
        _main_chart.update();
        _main_chart.destroy();
    }

    if(_viewing_chart != null) {
        _viewing_chart.update();
        _viewing_chart.destroy();
    }    
}

function timeFunctionLong(input) {
    setTimeout(function() {
        input.type = 'text';
    }, 60000);
}