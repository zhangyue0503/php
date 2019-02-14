<?php
/**
 * 原型类
 */
abstract class Prototype
{
    protected $name;

    protected $title;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public abstract function copy();

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }
}

/**
 * 具体实现 1
 *
 */
class ConcretePrototype1 extends Prototype
{

    protected $category = 'Bar';

    /**
     * 创建当前对象的浅表副本。方法是创建一个新对象，然后将当前对象的
     * 非静态字段复制到该新对象。如果字段是值类型的，则对该字段执行逐
     * 位复制。如果字段是引用类型，则复制引用但不复制引用的对象：因此。
     * 原始对象及其副本引用同一对象
     */
    public function copy()
    {
        return clone $this;
    }
}



class Client
{
    public static function index()
    {
        $p1 = new ConcretePrototype1("client -- 1");
        $p2 = $p1->copy();
        $p3 = $p1->copy();

        $p2->setTitle("p2");
        $p3->setTitle("p3");

        var_dump($p1);
        var_dump($p2);
        var_dump($p3);
    }
}
Client::index();
