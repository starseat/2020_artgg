<?php

// 비밀번호 암호화  // https://cnpnote.tistory.com/entry/passwordhash-%EC%82%AC%EC%9A%A9%EB%B2%95
$options = [
    'salt' => 'artgg_admin',
    'cost' => 12 // the default cost is 10
];

function password_encrypt($password) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT /*, $options */);
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT, $options);
    // $hashed_password = password_hash($password, PASSWORD_BCRYPT, $options);
    return $hashed_password;
}

function password_matches($password, $hashed_password) {
    if (password_verify($password, $hashed_password /*, options */)) {
        //return true;
        return 1;
    } else {
        //return false;
        return 0;
    }
}

?>

