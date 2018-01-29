<?php
require_once 'vendor/autoload.php';

//phpunit\vendor\bin\phpunit phpunit\MyGuestbookTest8_1.php

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/26
 * Time: 14:42
 */
class MyGuestbookTest8_1 extends TestCase
{
    use TestCaseTrait;

    protected function getConnection()
    {
        $pdo = new PDO('sqlite::memory:');
        return $this->createDefaultDBConnection($pdo, ':memory:');
    }

    protected function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__).'/_files/guestbook-seed.xml');
    }


}