<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/1
 * Time: 下午5:08
 * 生成器
 */
function myGenerator(){
    yield "value1";
    yield "value2";
    yield "value3";
}
foreach(myGenerator() as $yeildValue){
    echo $yeildValue,PHP_EOL;
}

//示例1 -- 普通方式
function makeRange($length){
    $dataset = [];
    for($i=0;$i<$length;$i++){
        $dataset[] = $i;
    }
    return $dataset;
}
$customRange = makeRange(1000);
foreach($customRange as $i){
    echo $i,PHP_EOL;
}

//示例2 -- 使用yeild
function makeRange2($length){
    for ($i=0;$i<$length;$i++){
        yield $i;
    }
}
foreach(makeRange2(100000) as $i){
    echo $i,PHP_EOL;
}