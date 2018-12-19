<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2018/11/8
 * Time: 6:17 PM
 */
// 递归+静态测试
function test()
{
	static $count = 0;
	$count++;
	echo $count;
	if ($count < 5) {
		test();
	}
}

test();


// 数组下标测试
$a      = ['a'];
$a[2]   = 'b';
$a[]    = 'c';
$a['1'] = 'd';
foreach ($a as $v) {
	echo $v, ',';
}
for ($i = 0; $i < count($a); ++$i) {
	echo $a[$i], ',';
}
// 直接累加
echo array_sum([1, 2, 3, 4, 'a']);
// if(count($arr) == count($arr, 1)) 判断是不是多维数组
echo count([1, 2, 3, [1, 2, 3]], COUNT_RECURSIVE);

print_r(array_filter([1, 2, '', 4, 0, 11, false, '0']));

