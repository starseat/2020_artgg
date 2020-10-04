$(function() {
    $('#artist_select_year').on('change', function() {
        resetArtistList($(this).val());
    });
});

function doUpdate(artist_seq) {
    //alert('[doUpdate] artist_seq: ' + artist_seq);
    location.href = './artist_edit.php?seq=' + artist_seq;
}

function doDelete(artist_seq) {
    if(confirm('작가 정보를 정말로 삭제하시겠습니까?\n삭제된 정보는 복구할 수 없습니다.')) {
        $.ajax({
            type: 'post',
            url: './action/artist_delete.php',
            data: { seq: artist_seq },
            dataType: 'json',
            success: function (result) {
                console.log('[doDelete] ajax result:: ', result);
                alert('작가 정보가 삭제되었습니다.');
                location.reload(true);
            },
            error: function (xhr, status, error) {
                console.error('[doDelete] ajax error:: ', error);
            },
        });
    }
}

function resetArtistList(artist_year) {
    getArtistList(artist_year, function (artist_list) {
        console.log('[resetArtistList] getArtistList.callback - artist_list:: ', artist_list);
        const $listBox = $('#artist-list-box');

        $listBox.empty();
        if (artist_list.length > 0) {
            for(let i=0; i<artist_list.length; i++) {
                let newArtistItem = '';
                newArtistItem += '<div class="col-sm-4 col-md-3">';
                newArtistItem += '    <div class="card">';
                newArtistItem += '        <img src="' + artist_list[i].thumbnail + '" class="card-img-top" alt="thumbnail" width="220" height="220">';
                newArtistItem += '        <div class="card-body artgg-border-top">';
                newArtistItem += '            <h5 class="card-title">' + artist_list[i].name + '</h5>';
                newArtistItem += '            <p class="card-text">' + artist_list[i].en_name + '</p>';
                newArtistItem += '            <div class="row">';
                newArtistItem += '                <div class="col-6"><button class="btn btn-primary w-100" onclick="doUpdate('  + artist_list[i].seq + ')">수정</button></div>';
                newArtistItem += '                <div class="col-6"><button class="btn btn-danger w-100" onclick="doDelete(' + artist_list[i].seq + ')">삭제</button></div>';
                newArtistItem += '            </div>';
                newArtistItem += '        </div>';
                newArtistItem += '    </div>';
                newArtistItem += '</div>';

                $listBox.append(newArtistItem);
            }
        }
        else {
            $listBox.append('<div class="d-none d-md-inline-block" style="margin: 8rem auto;">등록된 작가 정보가 없습니다.</div>');
        }
    });
}


function getArtistList(artist_year, callback) {
    $.ajax({
        type: 'get',
        url: './action/artist_get_list.php',
        data: { year: artist_year },
        dataType: 'json',
        success: function (result) {
            console.log('[getArtistList] ajax result:: ', result);

            if(result.result == 1) {
                callback(result.artist_list);
            }
        },
        error: function (xhr, status, error) {
            console.error('[getArtistList] ajax error:: ', error);
        },
    });
}
