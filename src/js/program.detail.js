$(document).ready(function () {
    getDirecionMap();
});

function getDirecionMap() {
    const map_x = $('#directions_map_x').val();
    const map_y = $('#directions_map_y').val();
    const marker_name = $('#directions_name').val();

    if(map_x == '' || map_y == '') {
        return false;
    }
    
    const coords = new kakao.maps.LatLng(map_y, map_x);
    const container = document.getElementById('directions_map');
    const options = { 
        center: coords, 
        level: 3 //지도의 레벨(확대, 축소 정도)
    }
    
    const mapObj = new kakao.maps.Map(container, options);
    const marker = new kakao.maps.Marker({
        map: mapObj,
        position: coords
    });
    
    let $markerTag = '';
    $markerTag += '<div style="width:150px;text-align:center;padding:6px 0;">';
    $markerTag += '<a id="direction_map_marker_link" ';
    $markerTag += 'href="https://map.kakao.com/link/map/' + marker_name + ',' + map_y + ',' + map_x + '" target="_blank">';
    $markerTag += marker_name;
    $markerTag += '</a></div>';

    const infowindow = new kakao.maps.InfoWindow({
        content: $markerTag
    });
    infowindow.open(mapObj, marker);
};
