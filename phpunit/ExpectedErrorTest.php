<?php
require_once 'vendor/autoload.php';

//phpunit\vendor\bin\phpunit phpunit\ExpectedErrorTest.php

use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/23
 * Time: 16:12
 */
class ExpectedErrorTest extends TestCase
{

    /**
     * @expectedException PHPUnit\Framework\Error\Error
     */
    public function testFailingInclude(){
        include 'not_existing_file.php';
    }
}