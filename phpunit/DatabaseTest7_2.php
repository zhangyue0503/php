<?php
require_once 'vendor/autoload.php';

//phpunit\vendor\bin\phpunit phpunit\DatabaseTest7_2.php

use PHPUnit\Framework\TestCase;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/26
 * Time: 11:55
 */
class DatabaseTest7_2 extends TestCase
{
    protected function setUp(){
        if(!extension_loaded('mysqli')){
            $this->markTestSkipped('MySQLi 扩展不可用');
        }
    }
    public function testConnection(){

    }
}