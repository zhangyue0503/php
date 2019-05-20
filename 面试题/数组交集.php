<?php
/**
 * 要求：
 * 两个数组中的交集及数量
 * 步骤
 * array_count_values统计数量
 * array_intersect_key键值交集
 * 循环交集结果key进行累加
 */

$a = str_split(md5('test1'));
$b = str_split(md5('test2'));

print_r($a);
print_r($b);

$aa = array_count_values($a);
$bb = array_count_values($b);

print_r($aa);
print_r($bb);

$cc = array_intersect_key($a, $b);

print_r($cc);

$res = [];
foreach($cc as $c){
    $res[$c] = $aa[$c] + $bb[$c];
}

arsort($res);

print_r($res);