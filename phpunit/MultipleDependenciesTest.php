<?php
require_once 'vendor/autoload.php';

//phpunit\vendor\bin\phpunit phpunit\MultipleDependenciesTest.php

use PHPUnit\Framework\TestCase;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/23
 * Time: 14:48
 */
class MultipleDependenciesTest extends TestCase
{
    public function testProducerFirst(){
        $this->assertTrue(true);
        return 'first';
    }

    public function testProducerSecond(){
        $this->assertTrue(true);
        return 'second';
    }

    /**
     * @depends testProducerFirst
     * @depends testProducerSecond
     */
    public function testConsumer(){
        $this->assertEquals(
            ['first', 'second'],
            func_get_args()
        );
    }
}