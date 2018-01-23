<?php
require_once 'vendor/autoload.php';

//phpunit\vendor\bin\phpunit phpunit\DataTest.php

use PHPUnit\Framework\TestCase;

require_once 'CsvFileIterator.php';

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/23
 * Time: 14:48
 */
class DataTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     */
    public function testAdd($a, $b, $expected)
    {
        $this->assertEquals($expected, $a + $b);
    }

    public function additionProvider()
    {
        return [
            'adding zeros'  => [0, 0, 0],
            'zero plus one' => [0, 1, 1],
            'one plus zero' => [1, 0, 1],
            'one plus one'  => [1, 1, 3]
        ];
//        return new CsvFileIterator('data.csv');
    }


}