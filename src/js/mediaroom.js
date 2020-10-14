$(document).ready(function () {
    initPage();

    $('.ht_link').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();

        $('.ht_inner').removeClass('current');
        const $this = $(this);
        const $parent = $this.parent();
        $parent.addClass('current');

        const title = $this.find('.ht_title').text();
        const youtube_id = $this.find('.ht_youtube_id').val();

        $('#target_mediaroom_title').text(title);
        $('#target_youtube_view').attr('src', getIFrameYoutubeLink(youtube_id));
    });
});

function initPage() {
    const $list = $('.ht_inner');
    if($list.length == 0) {
        return;
    }

    const $firstItem = $($list[0]);
    $firstItem.addClass('current');

    const title = $firstItem.find('.ht_title').text();
    const link = $firstItem.find('.ht_youtube_link').val();
    const youtube_id = $firstItem.find('.ht_youtube_id').val();

    console.log('title:: ', title);
    $('#target_mediaroom_title').text(title);
    $('#target_youtube_view').attr('src', getIFrameYoutubeLink(youtube_id));
}

function getIFrameYoutubeLink(youtube_id) {
    return 'https://www.youtube.com/embed/' + youtube_id + '?rel=0';
}