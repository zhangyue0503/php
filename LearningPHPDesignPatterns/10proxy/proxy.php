<?php

interface Subject{
    function request();
}

class RealSubject implements Subject{
    function request(){
        echo '这是真实的！';
    }
}

class Proxy implements Subject{
    private $realSubject;
    function __construct(){
        $this->realSubject = new RealSubject();
    }

    function request(){
        echo '这是代理！';
        $this->realSubject->request();
    }
}

$p = new Proxy();
$p->request();