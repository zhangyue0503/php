<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/3/11
 * Time: 下午11:19
 */

//字符串中存储二进制数据
$packed = pack('S4',1974,106,28225,32725);
print_r($packed);

$nums = unpack('S4',$packed);
print_r($nums);


