<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/12/8
 * Time: 上午11:05
 */
include 'phar://animals.phar/wild.php';
include 'phar://animals.phar/domestic.php';
$a = new animal();
printf("%s\n",$a->get_type());
$b = new \wild\animal();
printf("%s\n",$b->get_type());

