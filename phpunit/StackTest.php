<?php
require_once 'vendor/autoload.php';

//phpunit\vendor\bin\phpunit phpunit\StackTest.php

use PHPUnit\Framework\TestCase;

class StackTest extends TestCase
{
    public function testPushAndPop()
    {
        $stack = [];
        $this->assertEquals(0, count($stack));

        array_push($stack, 'foo');
        $this->assertEquals('foo', $stack[count($stack)-1]);
        $this->assertEquals(1, count($stack));

        $this->assertEquals('foo', array_pop($stack));
        $this->assertEquals(0, count($stack));

    }

    public function testEmpty(){
        $stack = [];
        $this->assertEmpty($stack);
        return $stack;
    }

    /**
     * @depends testEmpty
     */
    public function testPush(array $stack){
        array_push($stack,'foo');
        $this->assertEquals('foo',$stack[count($stack) - 1]);
        $this->assertNotEmpty($stack);
        return $stack;
    }

    /**
     * @depends testPush
     */
    public function testPop(array $stack){
        $this->assertEquals('foo',array_pop($stack));
        $this->assertEmpty($stack);
    }

}

//$stackTest = new StackTest();
//$stackTest->testPushAndPop();