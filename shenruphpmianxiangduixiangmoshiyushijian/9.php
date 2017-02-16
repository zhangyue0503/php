<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/2/15
 * Time: 上午11:06
 */


/**
 * 单例模式
 * Class Preferences
 */
class Preferences{
    private $props = array();
    private static $instance;

    private function __construct(){}

    public static function getInstance(){
        if(empty(self::$instance)){
            self::$instance = new Preferences();
        }
        return self::$instance;
    }

    public function setProperty($key,$val){
        $this->props[$key] = $val;
    }
    public function getProperty($key){
        return $this->props[$key];
    }
}

$pref = Preferences::getInstance();
$pref->setProperty("name","matt");
unset($pref); //移除引用

$pref2 = Preferences::getInstance();
print $pref2->getProperty("name")."\n";  //属性值没有丢失








