<?php
require_once 'vendor/autoload.php';

//phpunit\vendor\bin\phpunit phpunit\Database4_3.php

use PHPUnit\Framework\TestCase;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/25
 * Time: 11:09
 */
class Database4_3
{
    protected static $dbh;
    public static function setUpBeforeClass(){
        self::$dbh = new PDO('sqlite::memory:');
    }

    public static function tearDownAfterClass(){
        self::$dbh = null;
    }
}