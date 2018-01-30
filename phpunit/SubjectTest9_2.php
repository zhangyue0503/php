<?php
require_once 'vendor/autoload.php';
require_once 'SubjectAndObserver9_2.php';

//phpunit\vendor\bin\phpunit phpunit\SubjectTest9_2.php

use PHPUnit\Framework\TestCase;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/30
 * Time: 14:56
 */
class SubjectTest9_2 extends TestCase
{
    public function testObserversAreUpdated(){
        // 为 Observer 类建立仿件对象，只模仿 update() 方法。
        $observer = $this->getMockBuilder(Observer::class)
            ->setMethods(['update'])
            ->getMock();

        // 建立预期状况：update() 方法将会被调用一次，
        // 并且将以字符串 'something' 为参数。
        $observer->expects($this->once())
            ->method('update')
            ->with($this->equalTo('something'));

        // 创建 Subject 对象，并将模仿的 Observer 对象连接其上。
        $subject = new Subject('My subject');
        $subject->attach($observer);

        // 在 $subject 对象上调用 doSomething() 方法，
        // 预期将以字符串 'something' 为参数调用
        // Observer 仿件对象的 update() 方法。
        $subject->doSomething();
    }

    public function testErrorReported()
    {
        // 为 Observer 类建立仿件，对 reportError() 方法进行模仿
        $observer = $this->getMockBuilder(Observer::class)
            ->setMethods(['reportError'])
            ->getMock();

        $observer->expects($this->once())
            ->method('reportError')
            ->with(
                $this->greaterThan(0),
                $this->stringContains('Something'),
                $this->anything()
            );

        $subject = new Subject('My subject');
        $subject->attach($observer);

        // doSomethingBad() 方法应当会通过（observer的）reportError()方法
        // 向 observer 报告错误。
        $subject->doSomethingBad();
    }

    public function testFunctionCalledTwoTimesWithSpecificArguments()
    {
        $mock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['set'])
            ->getMock();

        $mock->expects($this->exactly(2))
            ->method('set')
            ->withConsecutive(
                [$this->equalTo('foo'), $this->greaterThan(0)],
                [$this->equalTo('bar'), $this->greaterThan(0)]
            );

        $mock->set('foo', 21);
        $mock->set('bar', 48);
    }

    public function testErrorReported1()
    {
        // 为 Observer 类建立仿件，模仿 reportError() 方法
        $observer = $this->getMockBuilder(Observer::class)
            ->setMethods(['reportError'])
            ->getMock();

        $observer->expects($this->once())
            ->method('reportError')
            ->with($this->greaterThan(0),
                $this->stringContains('Something'),
                $this->callback(function($subject){
                    return is_callable([$subject, 'getName']) &&
                        $subject->getName() == 'My subject';
                }));

        $subject = new Subject('My subject');
        $subject->attach($observer);

        // doSomethingBad() 方法应当会通过（observer的）reportError()方法
        // 向 observer 报告错误。
        $subject->doSomethingBad();
    }

    public function testIdenticalObjectPassed()
    {
        $expectedObject = new stdClass;

        $mock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['foo'])
            ->getMock();

        $mock->expects($this->once())
            ->method('foo')
            ->with($this->identicalTo($expectedObject));

        $mock->foo($expectedObject);
    }

    public function testIdenticalObjectPassed1()
    {
        $cloneArguments = true;

        $mock = $this->getMockBuilder(stdClass::class)
            ->enableArgumentCloning()
            ->getMock();

        // 现在仿件将对参数进行克隆，因此 identicalTo 约束将会失败。
    }

    public function testObserversAreUpdated2()
    {
        $subject = new Subject('My subject');

        // 为 Observer 类建立预言(prophecy)。
        $observer = $this->prophesize(Observer::class);

        // 建立预期状况：update() 方法将会被调用一次，
        // 并且将以字符串 'something' 为参数。
        $observer->update('something')->shouldBeCalled();

        // 揭示预言，并将仿件对象链接到主体上。
        $subject->attach($observer->reveal());

        // 在 $subject 对象上调用 doSomething() 方法，
        // 预期将以字符串 'something' 为参数调用
        // Observer 仿件对象的 update() 方法。
        $subject->doSomething();
    }
}