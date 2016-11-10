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
