<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/22
 * Time: 上午11:01
 */
//写时复制
$a = "this is variable";
xdebug_debug_zval('a');

$b = $a;
xdebug_debug_zval('b');

$a = "changed value";
xdebug_debug_zval('a');