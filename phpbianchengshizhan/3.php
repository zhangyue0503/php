<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/12/7
 * Time: 上午9:37
 */
if(preg_match('/i(Phone|Pad)|Android|Blackberry|Symbian|windows (ce|phone)/i',$_SERVER['HTTP_USER_AGENT'])){
    print_r($_SERVER['HTTP_USER_AGENT']);
    echo 'mobile',PHP_EOL;
}

