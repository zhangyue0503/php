<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/2
 * Time: 下午1:52
 */

require 'tDebug.php';
require 'Rectangle.php';

$r = new Rectangle(42,37);
$r->dumpObject();

unset($r);