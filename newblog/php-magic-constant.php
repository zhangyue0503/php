<?php
namespace test\magic\constant;
/////////////////////////////
/// __LINE__
echo __LINE__ . PHP_EOL; // 3

function testLine()
{
    echo __LINE__ . PHP_EOL; // 7
}

class TestLineClass
{
    function testLine()
    {
        echo __LINE__ . PHP_EOL; // 14
    }
}

testLine();
$test = new TestLineClass();
$test->testLine();

/////////////////////////////
/// __FILE__
echo __FILE__ . PHP_EOL; // D:\phpproject\php\newblog\php-magic-constant.php

/////////////////////////////
/// __DIR__
echo __DIR__ . PHP_EOL; // D:\phpproject\php\newblog

/////////////////////////////
/// __FUNCTION__
echo __FUNCTION__ . PHP_EOL; // 啥都没输出
function testFunction()
{
    echo __FUNCTION__ . PHP_EOL; // test\magic\constant\testFunction
}

class TestFunctionClass
{
    function testFunction1()
    {
        echo __FUNCTION__ . PHP_EOL; // testFunction1
    }
}

testFunction();
$test = new TestFunctionClass();
$test->testFunction1();

/////////////////////////////
/// __CLASS__
echo __CLASS__ . PHP_EOL; // 什么也没有
function testClass()
{
    echo __CLASS__ . PHP_EOL; // 什么也没有
}

trait TestClassTrait
{
    function testClass2()
    {
        echo __CLASS__ . PHP_EOL; // test\magic\constant\TestClassClass
    }
}

class TestClassClass
{
    use TestClassTrait;

    function testClass1()
    {
        echo __CLASS__ . PHP_EOL; // test\magic\constant\TestClassClass
    }
}

testClass();
$test = new TestClassClass();
$test->testClass1();
$test->testClass2();

/////////////////////////////
/// __TRAIT__
echo __TRAIT__ . PHP_EOL; // 什么也没有
function testTrait()
{
    echo __TRAIT__ . PHP_EOL; // 什么也没有
}

trait TestTrait
{
    function testTrait2()
    {
        echo __TRAIT__ . PHP_EOL; // test\magic\constant\TestTrait
    }
}

class TestTraitClass
{
    use TestTrait;

    function testTrait1()
    {
        echo __TRAIT__ . PHP_EOL; // 什么也没有
    }
}

testTrait();
$test = new TestTraitClass();
$test->testTrait1();
$test->testTrait2();

/////////////////////////////
/// __METHOD__
echo __METHOD__ . PHP_EOL; // 什么也没有
function testMethod()
{
    echo __METHOD__ . PHP_EOL; // test\magic\constant\testMethod
}

class TestMethodClass
{
    function testMethod1()
    {
        echo __METHOD__ . PHP_EOL; // test\magic\constant\TestMethodClass::testMethod1
    }
}

testMethod();
$test = new TestMethodClass();
$test->testMethod1();

/////////////////////////////
/// __NAMESPACE__
echo __NAMESPACE__ . PHP_EOL; // test\magic\constant
class TestNameSpaceClass
{
    function testNamespace()
    {
        echo __NAMESPACE__ . PHP_EOL; // test\magic\constant
    }
}

$test = new TestNameSpaceClass();
$test->testNamespace();