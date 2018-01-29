<?php
require_once 'vendor/autoload.php';

//phpunit\vendor\bin\phpunit phpunit\Generic_Tests_DatabaseTestCase8_3.php

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/29
 * Time: 10:52
 */
class Generic_Tests_DatabaseTestCase8_3
{
    use TestCaseTrait;
    static private $pdo = null;
    private $conn = null;

    protected function getConnection()
    {
        if($this->conn == null ){
            if(self::$pdo==null){
                self::$pdo = new PDO($GLOBALS['DB_DSN'],$GLOBALS['DB_USER'],$GLOBALS['DB_PASSWD']);
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo,$GLOBALS['DB_DBNAME']);
        }
        return $this->conn;
    }

    protected function getDataSet()
    {
        // TODO: Implement getDataSet() method.
    }


}