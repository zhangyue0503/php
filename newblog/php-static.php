<?php

class Test
{
    static $v = 'a';

    static function showV()
    {
        echo self::$v;
    }

    function showVV()
    {
        echo self::$v;
    }

    static function showVVV()
    {
        // $this->showVV(); // 会直接报错
    }
}

$t = new Test();
$t->showV();
//echo $t->v; // 报错
echo Test::$v;
//Test::showVV(); // 报异常

// php5.3起可以用一个变量来动态调用类
$test = 'Test';
$test::showV();

// 初始化特性
class Calculate
{
    function cacl()
    {
        static $a = 1;
        echo $a;
        $a++;
    }

    static function cacl2()
    {
        static $a = 1;
        echo $a;
        $a++;
    }

    static $b = 1;

    static function cacl3()
    {
        echo self::$b;
        self::$b++;
    }
}

$calculate = new Calculate();
$calculate->cacl();
$calculate->cacl();

Calculate::cacl2();
Calculate::cacl2();

Calculate::cacl3();
Calculate::cacl3();

// 例子，递归处理
function test()
{
    static $count = 0;

    $count++;
    echo $count;
    if ($count < 10) {
        test();
    }
    $count--;
}

test();


// 引用对象问题
// 引用不是静态地存储
class Foo
{
    public $a = 1;
}

function getRefObj($o)
{
    static $obj;
    var_dump($obj);
    if (!isset($obj)) {
        $obj = &$o;
    }
    $obj->a++;
    return $obj;
}

function getNoRefObj($o)
{
    static $obj;
    var_dump($obj);
    if (!isset($obj)) {
        $obj = $o;
    }
    $obj->a++;
    return $obj;
}

$o    = new Foo;
$obj1 = getRefObj($o);
$obj2 = getRefObj($o);

$obj3 = getNoRefObj($o);
$obj4 = getNoRefObj($o);

// 后期静态绑定
// self取决于当前定义方法所在的类
class A
{
    static function who()
    {
        echo __CLASS__ . "\n";
    }

    static function test()
    {
        self::who();
    }
}

class B extends A
{
    static function who()
    {
        echo __CLASS__ . "\n";
    }
}

B::test(); // A

// static 表示运行最初时的类，不是方法定义时的类
// 在非静态环境下，所调用的类即为该对象实例所属的类。由于 $this-> 会在同一作用范围内尝试调用私有方法，而 static:: 则可能给出不同结果。另一个区别是 static:: 只能用于静态属性。
class AA
{
    static function who()
    {
        echo __CLASS__ . "\n";
    }

    static function test()
    {
        static::who();
    }
}

class BB extends AA
{
    static function who()
    {
        echo __CLASS__ . "\n";
    }
}

BB::test(); // BB

// parent和self会转发调用信息
class AAA
{
    public static function foo()
    {
        static::who();
    }

    public static function who()
    {
        echo __CLASS__ . "\n";
    }
}

class BBB extends AAA
{
    public static function test()
    {
        AAA::foo();
        parent::foo();
        self::foo();
    }

    public static function who()
    {
        echo __CLASS__ . "\n";
    }
}

class CCC extends BBB
{
    public static function who()
    {
        echo __CLASS__ . "\n";
    }
}

CCC::test(); // AAA、CCC、CCC