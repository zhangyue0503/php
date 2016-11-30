<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/30
 * Time: 上午9:12
 */

//debug函数
function debug(){
    $numargs = func_num_args();
    $arg_list = func_get_args();
    for($i=0;$i<$numargs;$i++){
        echo "第${i}个变量的值为：",$arg_list[$i],PHP_EOL;
    }
    echo '当前所处的文件名为：',__FILE__,PHP_EOL;
}
function factorl($n){
    $factor = 1;
    for($i=1;$i<$n;$i++){
        $factor*=i;
        debug($factor,$i);
    }
    return $factor;
}
factorl(4);


//debug_zval_dump
$debugArray = array(1,2,3);
foreach($debugArray as $v) {
    $v *= 2;
    debug_zval_dump($v);
}
var_dump($debugArray);
$debugArray2 = array(1,2,3);
foreach($debugArray2 as $v) {
    $v *= 2;
    debug_zval_dump($v);
}
var_dump($debugArray2);

//debug_print_backtrace
function a(){
    b();
}
function b(){
    c();
}
function c(){
    debug_print_backtrace();
}
a();

















//JMeter压力测试
$num = 4;
if(isset($_POST['num'])) $num = $_POST['num'];
$sum = 0;
for($i=0;$i<=$num;$i++){
    $sum+=$i;
}
echo $sum;