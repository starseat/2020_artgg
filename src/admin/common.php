<?php

function isEmpty($value) {
    if (isset($value) && !empty($value) && $value != null && $value != '') {
        return false;
    } else {
        return true;
    }
}

function viewAlert($message) {
    echo ("<script>alert('$message');</script>");
}

function debug_console($msg) {
    echo ("<script>console.log('$msg');</script>");
}

function historyBack() {
    $prevPage = $_SERVER['HTTP_REFERER'];
    header('location:' . $prevPage);
}

function uuidgen() {
    return sprintf('%08x-%04x-%04x-%04x-%04x%08x',
        mt_rand(0, 0xffffffff),
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff), mt_rand(0, 0xffffffff)
    );
}

function getCharacter() {
    return var_dump(iconv_get_encoding('all'));
}

function removeFileExt($file_name) {
    $file_ext = strtolower(substr(strrchr($file_name, "."), 1)); 
    $fileNameWithoutExt = substr($file_name, 0, strrpos($file_name, "."));
    return $fileNameWithoutExt;
}

function getFileExt($file_name) {
    // 1. strrchr함수를 사용해서 확장자 구하기
    $ext = substr(strrchr($file_name, '.'), 1); 
    
    // // 2. strrpos 함수와 substr함수를 사용해서 확장자 구하기
    // $ext = substr($file_name, strrpos($file_name, '.') + 1); 

    // // 3. expload 함수와 end 함수를 사용해서 확장자 구하기
    // end(explode('.', $file_name)); 
  
    // // 4. preg_replace 함수에 정규식을 대입해서 확장자 구하기
    // $ext = preg_replace('/^.*\.([^.]+)$/D', '$1', $file_name);

    // // 5. pathinfo 함수를 사용해서 확장자 구하기
    // $fileinfo = pathinfo($file_name);
    // $ext = $fileinfo['extension'];

    $ext = strtolower($ext);
    return $ext;
}

function isIE() {
    // IE 11
    if (stripos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0') !== false) return true;
    // IE 나머지
    if (stripos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) return true;
 
    return false;
}

function uploadImage($upload_file, $type) {
    $ret_upload_file_array_item = [
        'upload_file_path' => '',
        'file_name' => '',
        'file_save_name' => ''
    ];

    $file_name = basename(convertUTF8String($upload_file['name']));

    if (empty($file_name)) {
        return null;
    }

    $file_temp_name = convertUTF8String($upload_file['tmp_name']);
    //$file_type = $upload_files['type'][$i];
    //$file_size = $upload_files['size'][$i];
    //$file_error = $upload_files['error'][$i];

    if (!isUploadBannedItem($file_name)) {
        return null;
    }

    // if( $file_error != UPLOAD_ERR_OK ) {
    //     $upload_error_msg = "";
    //     switch( $error ) {
    //         case UPLOAD_ERR_INI_SIZE:
    //         case UPLOAD_ERR_FORM_SIZE:
    //             $upload_error_msg = "파일이 너무 큽니다. ($error)";
    //             break;
    //         case UPLOAD_ERR_NO_FILE:
    //             $upload_error_msg = "파일이 첨부되지 않았습니다. ($error)";
    //             break;
    //         default:
    //             $upload_error_msg = "파일이 제대로 업로드되지 않았습니다. ($error)";
    //     }
    //     //error_alert($upload_error_msg);
    //     exit;
    // }

    // if($file_size > 500000) {
    //     //error_alert ("파일이 너무 큽니다.");
    //     exit;
    // }

    $upload_path = '../upload/' . $type . '/';
    $real_upload_path = '../' . $upload_path;
    if (!is_dir($real_upload_path)) {
        mkdir($real_upload_path, 766, true);
    }

    $today = date("Ymd");
    $file_save_name = $today . '_' . uuidgen() . '_' . $file_name;
    $real_upload_file = $upload_path . $file_save_name;
    //$move_resuslt = move_uploaded_file($file_temp_name, $upload_file);
    // 경로를 action 으로 하나 더 줬으니 실제 저장되는 경로는 한단계 앞으로 가야함.
    $move_resuslt = move_uploaded_file($file_temp_name, '../' . $real_upload_file);
    $ret_upload_file_array_item = [
        'upload_file_path' => $real_upload_file,
        'file_name' => $file_name,
        'file_save_name' => $file_save_name
    ];

    return $ret_upload_file_array_item;
}

function uploadImages($upload_files, $type) {
    //echo 'upload_files => '; var_dump($upload_files);
    $upload_file_count = count($upload_files['name']); // echo 'upload_file_count => ' . $upload_file_count;
    $upload_file_names = array(); // /echo 'upload_file_names => ';  var_dump($upload_file_names);

    for ($i = 0; $i < $upload_file_count; $i++) {
        $temp_upload_file = [
            'name' => $upload_files['name'][$i],
            'tmp_name' => $upload_files['tmp_name'][$i],
            'type' => $upload_files['type'][$i], 
            'size' => $upload_files['size'][$i], 
            'error' => $upload_files['error'][$i]
        ];

        $temp_upload_file_array_item = uploadImage($temp_upload_file, $type);
        if($temp_upload_file_array_item != null) {
            array_push($upload_file_names, $temp_upload_file_array_item);
        }
        else {
            array_push($upload_file_names, [
                'upload_file_path' => '',
                'file_name' => '',
                'file_save_name' => ''
            ]);
        }
    } // end of for ($i = 0; $i <= $upload_file_count; $i++)

    return $upload_file_names;
} // end of function uploadImages($upload_files, $type) 

function isUploadBannedItem($file_name) {
    // 파일 업로드 금지
    $ban_list = array('php', 'html', 'css', 'js'); // 금지 파일 확장자 수정 필요!!
    $exp_file_name = explode('.', $file_name);

    // 확장자 소문자로 가져오기
    $ext = strtolower($exp_file_name[sizeof($exp_file_name) - 1]);
    if (in_array($ext, $ban_list)) {
        return false;
    }
    return true;
}

function getFileExtension($file_name) {
    $exp_file_name = explode('.', $file_name);

    // 확장자 소문자로 가져오기
    return strtolower($exp_file_name[sizeof($exp_file_name) - 1]);
}

function uploadFile($upload_file, $type){
    $ret_upload_file_array_item = [
        'upload_file_path' => '',
        'file_name' => '',
        'file_save_name' => ''
    ];

    $file_name = basename(convertUTF8String($upload_file['name']));
    if (empty($file_name)) {
        return null;
    }

    $file_temp_name = convertUTF8String($upload_file['tmp_name']);

    $upload_path = '../upload/' . $type . '/';
    $real_upload_path = '../' . $upload_path;
    if (!is_dir($real_upload_path)) {
        mkdir($real_upload_path, 766, true);
    }

    $today = date("Ymd");
    $file_save_name = $today . '_' . uuidgen() . '_' . $file_name;
    //$file_save_name = $today . '_' . uuidgen() . '.' . getFileExtension($file_name);
    $real_upload_file = $upload_path . $file_save_name;
    //$move_resuslt = move_uploaded_file($file_temp_name, $upload_file);
    // 경로를 action 으로 하나 더 줬으니 실제 저장되는 경로는 한단계 앞으로 가야함.
    $move_resuslt = move_uploaded_file($file_temp_name, '../' . $real_upload_file);
    $ret_upload_file_array_item = [
        'upload_file_path' => $real_upload_file,
        'file_name' => $file_name,
        'file_save_name' => $file_save_name
    ];

    return $ret_upload_file_array_item;
}

function uploadFiles($upload_files, $type) {

    $upload_file_count = count($upload_files['name']); // echo 'upload_file_count => ' . $upload_file_count;
    $upload_file_names = array(); // /echo 'upload_file_names => ';  var_dump($upload_file_names);

    for ($i = 0; $i < $upload_file_count; $i++) {
        $temp_upload_file = [
            'name' => $upload_files['name'][$i],
            'tmp_name' => $upload_files['tmp_name'][$i],
            'type' => $upload_files['type'][$i],
            'size' => $upload_files['size'][$i],
            'error' => $upload_files['error'][$i]
        ];

        $temp_upload_file_array_item = uploadFile($temp_upload_file, $type);
        if ($temp_upload_file_array_item != null) {
            array_push($upload_file_names, $temp_upload_file_array_item);
        } else {
            array_push($upload_file_names, [
                'upload_file_path' => '',
                'file_name' => '',
                'file_save_name' => ''
            ]);
        }
    } // end of for ($i = 0; $i <= $upload_file_count; $i++)

    return $upload_file_names;
} // end of function uploadFiles($upload_files, $type) 

function SQLFiltering($sql){
    // 해킹 공격을 대비하기 위한 코드
    $sql = preg_replace("/\s{1,}1\=(.*)+/", "", $sql); // 공백이후 1=1이 있을 경우 제거
    $sql = preg_replace("/\s{1,}(or|and|null|where|limit)/i", " ", $sql); // 공백이후 or, and 등이 있을 경우 제거
    $sql = preg_replace("/[\s\t\'\;\=]+/", "", $sql); // 공백이나 탭 제거, 특수문자 제거
    return $sql;
}

function xss_clean($data) {

    // jw add
    //$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

    // Fix &entity\n;
    $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

    // Remove any attribute starting with "on" or xmlns
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

    // Remove javascript: and vbscript: protocols
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);

    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);

    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

    // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

    // Remove namespaced elements (we do not need them)
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

    do {
        // Remove really unwanted tags
        $old_data = $data;
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    }

    while ($old_data !== $data);

    // we are done...
    return $data;
}

function RemoveXSS($val) {
    return $val;
}

function RemoveXSS_bak($val) {
    // jw add
    //$val = htmlspecialchars($val, ENT_QUOTES, 'UTF-8');

    // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
    // this prevents some character re-spacing such as <java\0script>
    // note that you have to handle splits with \n, \r, and \t later since they *are*
    // allowed in some inputs
    $val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);

    // straight replacements, the user should never need these since they're normal characters
    // this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&
    // #X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>
    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search .= '1234567890!@#$%^&*()';
    $search .= '~`";:?+/={}[]-_|\'\\';
    for ($i = 0; $i < strlen($search); $i++) {
        // ;? matches the ;, which is optional
        // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

        // &#x0040 @ search for the hex values
        $val = preg_replace('/(&#[x|X]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val);
        // with a ;

        // &#00064 @ 0{0,7} matches '0' zero to seven times
        $val = preg_replace('/(&#0{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val); // with a ;
    }

    // now the only remaining whitespace attacks are \t, \n, and \r
    $ra1 = array(
        'javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style',
        'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base'
    );
    $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
    $ra = array_merge($ra1, $ra2);

    $found = true; // keep replacing as long as the previous round replaced something
    while ($found == true) {
        $val_before = $val;
        for ($i = 0; $i < sizeof($ra); $i++) {
            $pattern = '/';
            for ($j = 0; $j < strlen($ra[$i]); $j++) {
                if ($j > 0) {
                    $pattern .= '(';
                    $pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
                    $pattern .= '|(&#0{0,8}([9][10][13]);?)?';
                    $pattern .= ')?';
                }
                $pattern .= $ra[$i][$j];
            }
            $pattern .= '/i';
            $replacement = substr($ra[$i], 0, 2) . '<x>' . substr($ra[$i], 2); // add in <> to nerf the tag
            $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
            if ($val_before == $val) {
                // no replacements were made, so exit the loop
                $found = false;
            }
        }
    }
    return $val;
}

function getPagingInfo($current_page, $total_item_count, $item_row_count, $page_block_count) {
    $page_db = ($current_page - 1) * $item_row_count;

    // 전체 block 수
    $page_total = ceil($total_item_count / $page_block_count);
    if ($page_total == 0) {
        $page_total = 1;
    }
    // block 시작
    $page_start = (((ceil($current_page / $page_block_count) - 1) * $page_block_count) + 1);

    // block 끝
    $page_end = $page_start + $page_block_count - 1;
    if ($page_total < $page_end) {
        $page_end = $page_total;
    }

    // 시작 바로 전 페이지
    $page_prev = $page_start - 1;
    // 마지막 다음 페이지
    $page_next = $page_end + 1;

    return array(
        'page_db' => $page_db,  // db 조회시 사용
        'page_start' => $page_start, 
        'page_end' => $page_end,
        'page_prev' => $page_prev,
        'page_next' => $page_next, 
        'page_total' => $page_total
    );
}

function getNoticeListViewTitme($level, $title) {
    $retViewTitle = '';
    switch($level) {
        case 3: { $retViewTitle = '[긴급] ' . $title; } break;
        case 2: { $retViewTitle = '(중요) ' . $title; } break;
        default: { $retViewTitle = $title; } break; 
    }

    return $retViewTitle;
}

function convertUTF8String($str) {
    $enc = mb_detect_encoding($str, array("UTF-8", "EUC-KR", "SJIS"));
    if($str != "UTF-8") {
        $str = iconv($enc, "UTF-8", $str);
    }

    return $str;
}
?>
