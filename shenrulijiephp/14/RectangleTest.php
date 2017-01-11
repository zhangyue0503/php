<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/11
 * Time: 下午2:51
 */
require '../7/tDebug.php';
require '../7/Rectangle.php';
require 'vendor/autoload.php';

class RectangleTest extends PHPUnit_Framework_TestCase {
    function testGetArea(){
        $r = new Rectangle(8,9);

        $this->assertEquals(72,$r->getArea());
    }

}

