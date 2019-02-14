<?php
/**
 * Iterators迭代器抽象类
 */
abstract class Iterators
{
    /*
     * 用于定义得到开始对象、得到下一个对象、判断是否到结尾、
     * 当前对象等抽象方法、统一接口
     */

    public abstract function first();
    public abstract function next();
    public abstract function isDone();
    public abstract function currentItem();
}
/**
 * Aggregate聚集抽象类
 */
abstract class Aggregate
{
    /**
     * 创建迭代器
     * @var Iterator
     */
    public abstract function CreateIterator();
}

/**
 * ConcreteIterator具体迭代器类，继承iterator
 */
class ConcreteIterator extends Iterators
{
    /**
     * 定义了一个具体聚集对象
     * @var ConcreteAggregate
     */
    private $aggregate;
    private $current = 0;

    // 初始化时将具体的聚集对象传入
    function __construct(ConcreteAggregate $aggregate)
    {
        $this->aggregate = $aggregate->getItmes();
    }
    /**
     * 得到聚集的第一个对象
     * @return ConcreteAggregate
     */
    public function first()
    {
        return $this->aggregate[0];
    }

    /**
     * 得到聚集的下一个对象
     * @return ConcreteAggregate
     */
    public function next()
    {
        $ret = null;

        $this->current++;
        if ($this->current < count($this->aggregate)) {
            $ret = $this->aggregate[$this->current];
        }
        return $ret;
    }
    /**
     * 判断当前是否遍历到结尾，到结尾返回true
     * @return ConcreteAggregate
     */
    public function isDone()
    {
        return $this->current >= count($this->aggregate) ? true : false;
    }
    /**
     * 返回当前的聚集对象
     * @return ConcreteAggregate
     */
    public function currentItem()
    {
        return $this->aggregate[$this->current];
    }
}

/**
 * 具体的聚集类
 */
class ConcreteAggregate extends Aggregate
{
    /**
     * 声明一个IList泛型变量，用于存放聚合对象，用ArrayList同样可以实现
     * @var array
     */
    private $items = [];

    public function CreateIterator()
    {
        return new ConcreteIterator($this);
    }

    public function getItmesCount()
    {
        return count($this->items);
    }

    public function getItmes($index = '')
    {
        return ($index == '') ? $this->items : $this->items[$index];
    }

    public function setItmes($index, $value)
    {
        $this->items[$index] = $value;
    }
}

/**
 * 客户端
 */
class Client
{
    public static function index()
    {
        // 公交车，聚集对戏
        $a = new ConcreteAggregate;

        $a->setItmes(0,'美团');       //美团支付类
        $a->setItmes(1,'饿了么');
        $a->setItmes(2,'微信扫码');
        $a->setItmes(3,'被动扫码');
        $a->setItmes(4,'现金');
        // $a[0] = "ads";
        // $a[1] = "小飞";
        // $a[2] = "西西";
        // $a[3] = "栗子";
        // $a[4] = "老王";

        $i = new ConcreteIterator($a);
        $item = $i->first();

        while (!$i->isDone()) {
            echo $i->currentItem()."  -- 买票<br>";
            $i->next();
        }
    }
}
Client::index();
