<?php
/**
 * 指定文字的所有顺序组合形式
 * 如：a,b,c
 * 组成：abc,ab,ac,a,bc,b,c
 *
 * @author zhangyue
 * @blog www.zyblog.net
 *
 */

// abcd的显示用2进制来标明是否输出
// 起始全显示，然后依次减1一直到0

$arr = array('s', 'ht', 'hp', 'a', 'o');
$bitArr = [];
for ($i = 0; $i < count($arr); $i++) {
    if ($i == 0) {
        $bitArr[] = 1;
    } else {
        $bitArr[] = $bitArr[$i - 1] * 2;
    }
}
// 数组类似：[16,8,4,2,1]
$bitArr = array_reverse($bitArr);
// 获取总和
$bit_set = array_sum($bitArr);
while ($bit_set > 0) {
    $s = "";
    $nowArr = [];
    foreach ($bitArr as $key => $bit) {
        if ($bit_set & $bit) {
            $s = $s . $arr[$key] . ',';
            $nowArr[] = $arr[$key];
        }
    }
//    echo(trim($s, ',') . PHP_EOL);
    echo implode($nowArr, ',') . PHP_EOL;
    --$bit_set;
}