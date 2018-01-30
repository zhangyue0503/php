<?php
require_once 'vendor/autoload.php';

//phpunit\vendor\bin\phpunit phpunit\AbstractClassTest9_3.php

use PHPUnit\Framework\TestCase;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/30
 * Time: 15:12
 */

trait AbstractTrait
{
    public function concreteMethod()
    {
        return $this->abstractMethod();
    }

    public abstract function abstractMethod();
}

class AbstractClassTest9_3 extends TestCase
{
    public function testConcreteMethod()
    {
        $stub = $this->getMockForAbstractClass(AbstractClass::class);

        $stub->expects($this->any())
            ->method('abstractMethod')
            ->will($this->returnValue(true));

        $this->assertTrue($stub->concreteMethod());
    }
}