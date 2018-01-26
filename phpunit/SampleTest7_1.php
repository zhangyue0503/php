<?php
require_once 'vendor/autoload.php';

//phpunit\vendor\bin\phpunit phpunit\SampleTest7_1.php

use PHPUnit\Framework\TestCase;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/26
 * Time: 11:11
 */
class SampleTest7_1 extends TestCase
{
    public function testSomething(){
        $this->assertTrue(true,'这应该是已经能正常工作的。');
        $this->markTestIncomplete('此测试目前尚未实现。');
    }
}