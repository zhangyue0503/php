<?php
require_once 'vendor/autoload.php';

//phpunit\vendor\bin\phpunit phpunit\OutputTest.php

use PHPUnit\Framework\TestCase;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/24
 * Time: 14:40
 */
class OutputTest extends TestCase
{
    public function testExpectFooActualFoo(){
        $this->expectOutputString('foo');
        echo 'foo';
    }
    public function testExpectBarActualBaz(){
        $this->expectOutputString('bar');
        echo 'baz';
    }
}