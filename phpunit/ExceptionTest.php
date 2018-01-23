<?php
require_once 'vendor/autoload.php';

//phpunit\vendor\bin\phpunit phpunit\ExceptionTest.php

use PHPUnit\Framework\TestCase;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/23
 * Time: 16:05
 */
class ExceptionTest extends TestCase
{
    public function testException(){
        $this->expectException(InvalidArgumentException::class);
    }

    /**
     * @expectException InvalidArgumentException
     */
    public function testException2(){

    }

}