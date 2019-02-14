<?php
/**
 *
 */
class Target
{
    public function request()
    {
        echo "普通请求！<br>";
    }
}
class Adaptee
{
    public function specificRequest()
    {
        echo "特殊请求！<br>";
    }
}

class Adapter extends Target
{
    /**
     * 创建一个私有的adaptee对象
     * @var Adaptee
     */
    private $adaptee;

    public function __construct()
    {
        $this->adaptee = new Adaptee;
    }

    /**
     * 这样就可以把表面上调用request()方法变成实际
     * 调用specificRequest()
     */
    public function request()
    {
        $this->adaptee->specificRequest();
    }
}

/**
 *
 */
class Client
{
    public static function index()
    {
        $target = new Adapter();
        $target->request();
    }
}
Client::index();
