<?php
/**
 * Created by PhpStorm.
 * User: 11041
 * Date: 2019/4/26
 * Time: 15:57
 */

class PHPMagic
{

    public function __construct()
    {
        echo '构造函数' . PHP_EOL;
    }

    public function __destruct()
    {
        echo '析构函数' . PHP_EOL;
    }

    public function __call($name, $arguments)
    {
        echo '===call===' . PHP_EOL;
        echo '未定义的方法找我' . PHP_EOL;
        echo '您需要的是' . $name . '，参数是：';
        print_r($arguments);
        echo '===call===' . PHP_EOL;
    }

    public static function __callStatic($name, $arguments)
    {
        echo '===callStatic===' . PHP_EOL;
        echo '未定义的静态方法找我' . PHP_EOL;
        echo '您需要的是' . $name . '，参数是：';
        print_r($arguments);
        echo '===callStatic===' . PHP_EOL;
    }

    public function __set($name, $value)
    {
        echo '===set===' . PHP_EOL;
        echo '给不可访问的属性赋值时找我' . PHP_EOL;
        echo '您需要的是' . $name . '，值是：' . $value . PHP_EOL;
        echo '===set===' . PHP_EOL;
        if ($name == 'a') {
            $this->$name = $value;
        }
    }

    public function __get($name)
    {
        echo '===get===' . PHP_EOL;
        echo '获取不可访问的属性赋值时找我' . PHP_EOL;
        echo '您需要的是' . $name . PHP_EOL;
        echo '===get===' . PHP_EOL;
        return $this->$name;
    }

    public function __isset($name)
    {
        echo '===isset===' . PHP_EOL;
        echo '调用isset()或empty()时来找我了' . PHP_EOL;
        echo '您要找的是' . $name . PHP_EOL;
        echo '===isset===' . PHP_EOL;
        return property_exists($this, $name);
    }

    public function __unset($name)
    {
        echo '===unset===' . PHP_EOL;
        echo '调用unset()时来找我' . PHP_EOL;
        echo '您要找的是' . $name . PHP_EOL;
        echo '===unset===' . PHP_EOL;
    }

    private $a;

    public function __sleep()
    {
        echo '===sleep===' . PHP_EOL;
        echo '调用serialize()时来找我，先睡一会的' . PHP_EOL;
        echo '===unset===' . PHP_EOL;
        return ['a'];
    }

    public function __wakeup()
    {
        echo '===wakeup===' . PHP_EOL;
        echo '调用unserialize()时来找我，起床吧' . PHP_EOL;
        echo '===wakeup===' . PHP_EOL;
    }

    public function __toString()
    {
        echo '===toString===' . PHP_EOL;
        echo '调用echo、print时会使用我' . PHP_EOL;
        echo '===toString===' . PHP_EOL;
        return '打印出来看看吧';
    }

    public function __invoke()
    {
        echo '===invoke===' . PHP_EOL;
        echo '把类当方法使用时就进这里了' . PHP_EOL;
        echo '===invoke===' . PHP_EOL;
    }

    public function __clone()
    {
        echo '===clone===' . PHP_EOL;
        echo '复制类的时候我就发挥作用了' . PHP_EOL;
        echo '===clone===' . PHP_EOL;
    }

    public $var1;
    public $var2;

    public static function __set_state($an_array)
    {
        echo '===set_state===' . PHP_EOL;
        echo '使用var_export()的时候使用调用我哦' . PHP_EOL;
        echo '===set_state===' . PHP_EOL;
        $m = new PHPMagic();
        $m->var1 = 111;
        $m->var2 = 222;
        return $m;
    }

    public function __debugInfo()
    {
        echo '===debugInfo===' . PHP_EOL;
        echo '使用var_dump()的时候就是我来啦' . PHP_EOL;
        echo '===debugInfo===' . PHP_EOL;
        return [
            'var1' => $this->var1,
            'var2' => $this->var2,
        ];
    }

}

$magic = new PHPMagic();
// call、callStatic
$magic->lalala(1, '2');
PHPMagic::yoyoyo(2, '1');

// 可以是私有的或者根本就不存在的
// set、get
$magic->a = 88;
echo $magic->a;
// isset、unset
var_dump(isset($magic->b));
unset($magic->c);

// sleep、wakeup
$m = serialize($magic);
echo $m . PHP_EOL;
print_r(unserialize($m));

// toString
echo $magic . PHP_EOL;
print $magic . PHP_EOL;

// invoke
$magic();

// clone
$magic2 = clone $magic;

//set_state、debugInfo
$magic->var1 = 11;
$magic->var2 = 22;
eval('$b = ' . var_export($magic, true) . ';');
var_dump($b);
var_dump($magic);
