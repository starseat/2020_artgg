$(document).ready(function () {
    $('#yearSelect').on('change', function () {
        getProgramList($(this).val(), makeProgramInfo);
    });
});

function getProgramList(program_year, callback) {
    $.ajax({
        type: 'get',
        url: './api/program_list.php',
        data: { year: program_year },
        dataType: 'json',
        success: function (result) {
            console.log('[getProgramList] ajax result:: ', result);
            if(result.result == 1) {
                callback(result);
            }
            else {
                console.log('프로그램 조회 실패.. ', result);
            }
        },
        error: function (xhr, status, error) {
            console.error('[getProgramList] ajax error:: ', error);
        },
    });
}


function makeProgramInfo(data) {
    console.log('[makeArtistInfo] data:: ', data);

    const $program_list = $('#program_list');
    $program_list.empty();
    const program_list = data.program_list;
    for(let i=0; i<program_list.length; i++) {
        let item = '';
        item += '<li class="pl_inner">';
        item += '    <a href="./program_detail.php?seq=' + program_list[i].seq + '" class="pl_cont">';
        item += '        <span class="program_thumb_w">';
        item += '            <img src="' + program_list[i].thumbnail + '" alt="' + program_list[i].name + '" class="program_image">';
        item += '        </span>';
        item += '        <div class="program_text_w">';
        item += '            <strong class="ptext_name">' + program_list[i].name + '</strong>';
        item += '            <span class="ptext_date">' + program_list[i].program_date + '</span>';
        item += '            <span class="ptext_host">' + program_list[i].place + '</span>';
        item += '        </div>';
        item += '    </a>';
        item += '</li>';
        $program_list.append(item);
    }
}
