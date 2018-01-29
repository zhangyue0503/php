<?php
require_once 'vendor/autoload.php';

//phpunit\vendor\bin\phpunit phpunit\MyApp_Tests_DatabaseTestCase8_2.php

use PHPUnit\Framework\TestCase;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/29
 * Time: 9:33
 */
class MyApp_Tests_DatabaseTestCase8_2 extends TestCase
{
    use \PHPUnit\DbUnit\TestCaseTrait;

    static private $pdo = null;
    private $conn = null;

    protected function getConnection()
    {
        if($this->conn === null){
            if(self::$pdo == null){
                self::$pdo = new PDO('sqlite:memory');
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo,':memory:');
        }
        return $this->conn;
    }


    protected function getDataSet()
    {
        // TODO: Implement getDataSet() method.
    }

}