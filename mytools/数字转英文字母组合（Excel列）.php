<?php
/**
 * Created by PhpStorm.
 * User: 11041
 * Date: 2019/6/10
 * Time: 16:23
 */

function IntToChr($index, $start = 65) {
    $str = '';
    if (floor($index / 26) > 0) {
        $str .= IntToChr(floor($index / 26)-1);
    }
    return $str . chr($index % 26 + $start);
}
echo IntToChr(120121);