<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/3/6
 * Time: 下午11:10
 */
//生成固定宽度字段数据记录
$books = array(
    ['Elmer Gantry','Sinclair Lewis',1927],
    ['The Scarlatti Inheritance','Robert Ludlum',1971],
    ['The parsifal Mosaic','William Styron',1979],
);
foreach($books as $book){
    print pack('A25A15A4',$book[0],$book[1],$book[2])."\n";
}

foreach($books as $book){
    $title = str_pad(substr($book[0],0,25),25,'.');
    $author = str_pad(substr($book[1],0,15),15,'.');
    $year = str_pad(substr($book[2],0,4),4,'.');
    print "$title$author$year\n";
}