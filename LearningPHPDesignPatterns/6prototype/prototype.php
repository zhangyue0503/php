<?php

abstract class CloneMe
{
    public $name;
    public $picture;
    abstract function __clone();
}

class Person extends CloneMe{
    public function __construct(){
        $this->picture = 'cloneMan.png';
        $this->name = 'Original';
        echo 111; // 克隆不会调用构造函数
    }
    public function display(){
        echo 'picture: ' . $this->picture . "\n";
        echo 'name: ' . $this->name . "\n";
    }
    function __clone(){}
}

$worker = new Person();
$worker->display();

$slacker = clone $worker;
$slacker->name = 'Cloned';
$slacker->display();

$worker->display();
