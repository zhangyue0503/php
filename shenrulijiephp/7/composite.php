<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/3
 * Time: 下午3:51
 */
require 'WorkUnit.php';

$alpha = new Team('Alpha');
$john = new Employee('John');
$cynthia = new Employee('Cynthia');
$rashid = new Employee('Rashid');

$alpha->add($john);
$alpha->add($rashid);

$alpha->assignTask('Do somthing great.');
$cynthia->assignTask('Do something grand.');

$alpha->completeTask('Do something great.');

$alpha->remove($john);

unset($alpha,$john,$cynthia,$rashid);