<?php
require_once 'vendor/autoload.php';
require_once 'SomeClass9_1.php';

//phpunit\vendor\bin\phpunit phpunit\StubTest9_1.php

use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/30
 * Time: 10:42
 */
class StubTest9_1 extends TestCase
{
    public function testStub()
    {
        // 为 SomeClass 类创建桩件。
        $stub = $this->createMock(SomeClass9_1::class);

        // 配置桩件。
        $stub->method('doSomething')
            ->willReturn('foo');

        // 现在调用 $stub->doSomething() 将返回 'foo'。
        $this->assertEquals('foo', $stub->doSomething());
    }

    public function testStub2(){
        $stub = $this->getMockBuilder(SomeClass9_1::class)->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
        // 配置桩件。
        $stub->method('doSomething')
            ->willReturn('foo1');

        // 现在调用 $stub->doSomething() 将返回 'foo'。
        $this->assertEquals('foo1', $stub->doSomething());
    }

    public function testReturnArgumentStub()
    {
        // 为 SomeClass 类创建桩件。
        $stub = $this->createMock(SomeClass9_1::class);

        // 配置桩件。
        $stub->method('doSomething')
            ->will($this->returnArgument(0));

        // $stub->doSomething('foo') 返回 'foo'
        $this->assertEquals('foo', $stub->doSomething('foo'));

        // $stub->doSomething('bar') 返回 'bar'
        $this->assertEquals('bar', $stub->doSomething('bar'));
    }

    public function testReturnSelf()
    {
        // 为 SomeClass 类创建桩件。
        $stub = $this->createMock(SomeClass9_1::class);

        // 配置桩件。
        $stub->method('doSomething')
            ->will($this->returnSelf());

        // $stub->doSomething() 返回 $stub
        $this->assertSame($stub, $stub->doSomething());
    }

    public function testReturnValueMapStub()
    {
        // 为 SomeClass 类创建桩件。
        $stub = $this->createMock(SomeClass9_1::class);

        // 创建从参数到返回值的映射。
        $map = [
            ['a', 'b', 'c', 'd'],
            ['e', 'f', 'g', 'h']
        ];

        // 配置桩件。
        $stub->method('doSomething')
            ->will($this->returnValueMap($map));

        // $stub->doSomething() 根据提供的参数返回不同的值。
        $this->assertEquals('d', $stub->doSomething('a', 'b', 'c'));
        $this->assertEquals('h', $stub->doSomething('e', 'f', 'g'));
    }

    public function testReturnCallbackStub()
    {
        // 为 SomeClass 类创建桩件。
        $stub = $this->createMock(SomeClass9_1::class);

        // 配置桩件。
        $stub->method('doSomething')
            ->will($this->returnCallback('str_rot13'));

        // $stub->doSomething($argument) 返回 str_rot13($argument)
        $this->assertEquals('fbzrguvat', $stub->doSomething('something'));

    }

    public function testOnConsecutiveCallsStub()
    {
        // 为 SomeClass 类创建桩件。
        $stub = $this->createMock(SomeClass9_1::class);

        // 配置桩件。
        $stub->method('doSomething')
            ->will($this->onConsecutiveCalls(2, 3, 5, 7));

        // $stub->doSomething() 每次返回值都不同
        $this->assertEquals(2, $stub->doSomething());
        $this->assertEquals(3, $stub->doSomething());
        $this->assertEquals(5, $stub->doSomething());
    }

    public function testThrowExceptionStub()
    {
        // 为 SomeClass 类创建桩件
        $stub = $this->createMock(SomeClass9_1::class);

        // 配置桩件。
        $stub->method('doSomething')
            ->will($this->throwException(new Exception));

        // $stub->doSomething() 抛出异常
        $stub->doSomething();
    }
}