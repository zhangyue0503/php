<?php
require_once 'vendor/autoload.php';

//phpunit\vendor\bin\phpunit phpunit\TraitClassTest9_3.php

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

class TraitClassTest9_3 extends TestCase
{
    public function testConcreteMethod()
    {
        $mock = $this->getMockForTrait(AbstractTrait::class);

        $mock->expects($this->any())
            ->method('abstractMethod')
            ->will($this->returnValue(true));

        $this->assertTrue($mock->concreteMethod());
    }
}