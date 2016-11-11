<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/10
 * Time: 下午12:00
 */
class Test{
    //__call魔术方法
    public function __call($name,$arguments){
        switch (count($arguments)){
            case 2:
                echo $arguments[0]*$arguments[1],PHP_EOL;
                break;
            case 3:
                echo array_sum($arguments),PHP_EOL;
                break;
            default:
                echo '参数不对',PHP_EOL;
                break;
        }
    }

    //toString重载
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return 'Test对象的toString方法';
    }
}
$a = new Test();
$a->make(5);
$a->make(5,6);
$a->make(5,6,7);
echo $a;

//traits
trait Hello
{
    public function sayHello()
    {
    echo 'Hello';
    }
}
trait World
{
    function sayWorld()
    {
        echo 'World';
    }
}
class MyHelloWorld{
    use Hello,World;
    public function sayExclamationMark(){
        echo '!';
    }
}
$o = new MyHelloWorld();
$o->sayHello();
$o->sayWorld();
$o->sayExclamationMark();

//反射
class person{
    public $name;
    public $gender;
    public function say(){
        echo $this->name,"\tis ",$this->gender,"\r\n";
    }
    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        echo "Setting $name to $value \r\n";
        $this->$name = $value;
    }
    public function __get($name)
    {
        // TODO: Implement __get() method.
        if(!isset($this->$name)){
            echo '未设置';
            $this->$name = '正在为你设置默认值';
        }
        return $this->$name;
    }
}
$student = new person();
$student->name = 'Tom';
$student->gender = 'male';
$student->age=24;

$reflect = new ReflectionObject($student);
$props = $reflect->getProperties();
foreach ($props as $prop){
    print $prop->getName()."\n";
}
$m = $reflect->getMethods();
foreach ($m as $prop){
    print $prop->getName()."\n";
}

var_dump(get_object_vars($student));
var_dump(get_class_methods(get_class($student)));
echo get_class($student);


$obj = new ReflectionClass('person');
$className = $obj->getName();
$Methods = $Properties = [];
foreach($obj->getProperties() as $v){
    $Properties[$v->getName()] = $v;
}
foreach ($obj->getMethods() as $v){
    $Methods[$v->getName()] = $v;
}
echo "class {$className}\n{\n";
is_array($Properties)&&is_array($Methods);

foreach ($Properties as $k=>$v){
    echo "\t";
    echo $v->isPublic()?' public':'',$v->isPrivate?' private':'',$v->isProtected()?' protected':'',$v->isStatic()?' static':'';
    echo "\t{$k}\n";
}
echo "\n";
if(is_array($Methods)) ksort($Methods);
foreach ($Methods as $k=>$v){
    echo "\tfunction {$k}()()\n";
}
echo "}\n";

//反射实现动态代理
class mysql{
    public function connect($db){
        echo '连接到数据库'.$db[0]."\r\n";
    }
}
class sqlproxy{
    private $target;
    function __construct($tar)
    {
        $this->target[] = new $tar();
    }
    function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        foreach($this->target as $obj){
            $r = new ReflectionClass($obj);
            if($method = $r->getMethod($name)){
                if($method->isPublic()&&!$method->isAbstract()){
                    echo "方法前拦截记录LOG\r\n";
                    $method->invoke($obj,$arguments);
                    echo "方法后拦截.\r\n";
                }
            }
        }
    }
}
$obj = new sqlproxy('mysql');
$obj->connect('member');

//错误与异常
$a = null;
try {
    $a = 5 / 0;
} catch (Exception $e) {
    echo $e->getMessage();
    $a = -1;
    echo $a;
}
echo $a;

//错误
$date='2012-12-20';
if(ereg("([0-9]{4})-([0-9][1,2])-([0-9][1,2])",$data,$regs)){
    echo "$regs[3].$regs[2].$regs[1]";
}else{
    echo "Invalid date format:$date";
}


echo fun();
echo '致命错误后呢？还会执行吗？';
//echo '最高级别的错误',$55;

function customError($errno,$errstr,$errfile,$errline){
    echo "<b>错误代码：</b>[{$errno}]{$errstr}",PHP_EOL;
    echo "错误所在的代码行：{$errline}文件{$errfile}",PHP_EOL;
    echo "PHP版本",PHP_VERSION,"(",PHP_OS,")",PHP_EOL;
    //die();
}
set_error_handler("customError",E_ALL|E_STRICT);
$a = array('o'=>2,4,6,8);
echo $a[o];

if($i>5){
    echo '$i 没有初始化啊',PHP_EOL;
}