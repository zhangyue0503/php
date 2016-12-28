<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/12/26
 * Time: 上午11:11
 */

//多维数组排序
$a = array(
    array('key1'=>940,'key2'=>'blah'),
    array('key1'=>23,'key2'=>'this'),
    array('key1'=>894,'key2'=>'that')
);
function asc_number_sort($x,$y){
    if($x['key1']>$y['key1']){
        return true;
    }elseif($x['key1']<$y['key1']){
        return false;
    }else{
        return 0;
    }
}
usort($a,'asc_number_sort');
print_r($a);

function string_sort($x,$y){
    return strcasecmp($x['key2'],$y['key2']);
}
usort($a,'string_sort');
print_r($a);


//递归函数
function list_dir($start){
    $contents = scandir($start);
    foreach ($contents as $item){
        if(is_dir("$start/$item")&&(substr($item,0,1)!='.')){
            list_dir("$start/$item");
        }else{
            echo $item,PHP_EOL;
        }
    }
}
list_dir(".");

//匿名函数使用
array_map(function($value){echo $value['key1'],PHP_EOL;},$a);


