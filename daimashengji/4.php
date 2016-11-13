<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/13
 * Time: 下午11:35
 */
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php

//宽字节注入
$sql = "where id='".urldecode("-1%df%5c' --")."'";
print_r(mb_convert_encoding($sql,"UTF-8","GBK"));

$a = '1'.chr(130).'2';
echo $a;
echo PHP_EOL;
echo iconv("UTF-8","gbk",$a);

//十余种sql注入
//....没试出来
//$value=" 1 and LINESTRING((select * from(select * from(select user())a)b))";
//$sql = "select * from userinfo where id = ".$value;
//
//$conn = new mysqli("localhost","root","root","books");
//
//$result = $conn->query($sql);
//
//print_r($result->fetch_row());

//可变变量
$a = 'seay';
$$a = 123;
echo $seay;
//双引号中的变量是会被解析的，存在安全隐患
$b = "${@phpinfo()}";


?>

