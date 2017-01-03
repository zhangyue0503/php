<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/2
 * Time: 下午2:36
 */

require 'Company.php';



$hr = new MyNamespace\Company\Department("Human Resources");

$e1 = new MyNamespace\Company\Employee('Jane Doe');
$e2 = new MyNamespace\Company\Employee('John Doe');

$hr->addEmployee($e1);
$hr->addEmployee($e2);

unset($hr,$e1,$e2);