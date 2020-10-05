$(function() {
    $('#select_year').on('change', function () {
        resetProgramList($(this).val());
    });
});

function doUpdate(program_seq) {
    //alert('[doUpdate] program_seq: ' + program_seq);
    location.href = './program_edit.php?seq=' + program_seq;
}

function doDelete(program_seq) {
    if(confirm('프로그램 정보를 정말로 삭제하시겠습니까?\n삭제된 정보는 복구할 수 없습니다.')) {
        $.ajax({
            type: 'post',
            url: './action/program_delete.php',
            data: { seq: program_seq },
            dataType: 'json',
            success: function (result) {
                console.log('[doDelete] ajax result:: ', result);
                alert('프로그램 정보가 삭제되었습니다.');
                location.reload(true);
            },
            error: function (xhr, status, error) {
                console.error('[doDelete] ajax error:: ', error);
            },
        });
    }
}

function resetProgramList(program_year) {
    getProgramtList(program_year, function (program_list) {
        console.log('[resetProgramList] getProgramtList.callback - program_list:: ', program_list);
        const $listBox = $('#program-list-box');

        $listBox.empty();
        if (program_list.length > 0) {
            for(let i=0; i<program_list.length; i++) {
                let newProgramItem = '';
                newProgramItem += '<div class="col-sm-4 col-md-3">';
                newProgramItem += '    <div class="card">';
                newProgramItem += '        <img src="' + program_list[i].thumbnail + '" class="card-img-top" alt="thumbnail" width="220" height="220">';
                newProgramItem += '        <div class="card-body artgg-border-top">';
                newProgramItem += '            <h5 class="card-title">' + program_list[i].name + '</h5>';
                newProgramItem += '            <p class="card-text">' + program_list[i].program_date + '</p>';
                newProgramItem += '            <p class="card-text">' + program_list[i].place + '</p>';
                newProgramItem += '            <div class="row">';
                newProgramItem += '                <div class="col-6"><button class="btn btn-primary w-100" onclick="doUpdate('  + program_list[i].seq + ')">수정</button></div>';
                newProgramItem += '                <div class="col-6"><button class="btn btn-danger w-100" onclick="doDelete(' + program_list[i].seq + ')">삭제</button></div>';
                newProgramItem += '            </div>';
                newProgramItem += '        </div>';
                newProgramItem += '    </div>';
                newProgramItem += '</div>';

                $listBox.append(newProgramItem);
            }
        }
        else {
            $listBox.append('<div class="d-none d-md-inline-block" style="margin: 8rem auto;">등록된 프로그램 정보가 없습니다.</div>');
        }
    });
}


function getProgramtList(program_year, callback) {
    $.ajax({
        type: 'get',
        url: './action/program_get_list.php',
        data: { year: program_year },
        dataType: 'json',
        success: function (result) {
            console.log('[getProgramtList] ajax result:: ', result);

            if(result.result == 1) {
                callback(result.program_list);
            }
        },
        error: function (xhr, status, error) {
            console.error('[getProgramtList] ajax error:: ', error);
        },
    });
}
