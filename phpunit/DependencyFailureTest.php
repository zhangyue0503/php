<?php
require_once 'vendor/autoload.php';

//phpunit\vendor\bin\phpunit phpunit\DependencyFailureTest.php

use PHPUnit\Framework\TestCase;

class DependencyFailureTest extends TestCase
{
    public function testOne()
    {
        $this->assertTrue(false);
    }

    /**
     * @depends testOne
     */
    public function testTwo()
    {

    }

}