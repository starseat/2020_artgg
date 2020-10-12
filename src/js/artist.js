$(document).ready(function () {
    getArtistList('0', makeArtistInfo);

    $('#yearSelect').on('change', function () {
        getArtistList($(this).val(), makeArtistInfo);
    });
});

function getArtistList(artist_year, callback) {
    $.ajax({
        type: 'get',
        url: './api/artist_list.php',
        data: { year: artist_year },
        dataType: 'json',
        success: function (result) {
            console.log('[getArtistList] ajax result:: ', result);
            if(result.result == 1) {
                callback(result);
            }
            else {
                console.log('작가 조회 실패.. ', result);
            }
        },
        error: function (xhr, status, error) {
            console.error('[getArtistList] ajax error:: ', error);
        },
    });
}


function makeArtistInfo(data) {
    console.log('[makeArtistInfo] data:: ', data);

    // 작가 소개글 빼기로 협의됨. 2020.10.12
    //$('#artist_info_text').html(data.greeting.introduction);

    const $artist_list = $('#artist_list');
    $artist_list.empty();
    const artist_list = data.artist_list;
    for(let i=0; i<artist_list.length; i++) {
        let artist_item = '';
        artist_item += '<li class="mdil_inner">';
        artist_item += '    <a href="./artist_detail.php?seq=' + artist_list[i].seq + '" class="mdil_cont">';
        artist_item += '        <span class="mdil_thumb_w">';
        artist_item += '            <img src="' + artist_list[i].thumbnail + '" alt="' + artist_list[i].name + '" class="mdil_image">';
        artist_item += '        </span>';
        artist_item += '        <strong class="mdil_text_w">';
        artist_item += '            <span class="mdil_text">' + artist_list[i].name + '</span>';
        artist_item += '        </strong>';
        artist_item += '    </a>';
        artist_item += '</li>';
        $artist_list.append(artist_item);
    }

    // if (data.year_list.length == 0) {
    //     doNewWrite();
    //     return;
    // }

    // let $select_year = $('#artist_select_year');
    // $select_year.empty();
    // for (let i = 0; i < data.year_list.length; i++) {
    //     let $option = '<option value="' + data.year_list[i].year + '">' + data.year_list[i].year + '</option>';
    //     $select_year.append($option);
    // }

    // setGreetingInfo(data);
}
