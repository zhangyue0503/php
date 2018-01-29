<?php
require_once 'vendor/autoload.php';

//phpunit\vendor\bin\phpunit phpunit\GuestbookTest8_3.php

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/29
 * Time: 14:58
 */
class GuestbookTest8_3 extends TestCase
{
    use TestCaseTrait;
    protected function getConnection()
    {
        $pdo = new PDO('sqlite::memory:');
        return $this->createDefaultDBConnection($pdo, ':memory:');
    }

    protected function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__).'/guestbook-seed.xml');
    }

    public function testAddEntry()
    {
        $this->assertEquals(2, $this->getConnection()->getRowCount('guestbook'), "Pre-Condition");

        $guestbook = new Guestbook();
        $guestbook->addEntry("suzy", "Hello world!");

        $this->assertEquals(3, $this->getConnection()->getRowCount('guestbook'), "Inserting failed");
    }

    public function testAddEntry1()
    {
        $guestbook = new Guestbook();
        $guestbook->addEntry("suzy", "Hello world!");

        $queryTable = $this->getConnection()->createQueryTable(
            'guestbook', 'SELECT * FROM guestbook'
        );
        $expectedTable = $this->createFlatXmlDataSet("expectedBook.xml")
            ->getTable("guestbook");
        $this->assertTablesEqual($expectedTable, $queryTable);
    }

}