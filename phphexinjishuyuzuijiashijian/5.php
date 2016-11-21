<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/21
 * Time: 上午11:30
 */
//简单的模板引擎骨架
include 'Template.php';
$tpl = new Template(array('php_trun'=>true,'debug'=>true));
$tpl->assign('data','hello world');
$tpl->assign('person','cafeCAT');
$tpl->assign('pai',3.14);
$arr = [1,2,3,4,'hahattt',6];
$tpl->assignArray('b',$arr);
$tpl->show('member');
