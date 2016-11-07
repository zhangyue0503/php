<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/7
 * Time: 下午10:04
 */
$uid = $_GET['id'];
$sql = "SELECT * FROM userinfo where id=$uid";
$conn = new mysqli('localhost','root','root','books');
mysqli_select_db('books');
$result = $conn->query($sql);
print_r('当前SQL语句：'.$sql.'<br/>结果：');
print_r($result->fetch_row());


$a=addslashes($_GET['p']);
$b=urldecode($a);
echo '$a='.$a;
echo '<br/>';
echo '$b='.$b;
