<?php
// GoF迭代器类图实现
interface Aggregate{
    static function CreateIterator();
}

class ConcreteAggregate implements Aggregate{
    static function CreateIterator(){
        $aggregates = [
            'a',
            'b',
            'c',
            'd'
        ];
        return new ConcreteIterator($aggregates);
    }
}

interface MyIterator{
    function First();
    function Next();
    function IsDone();
    function CurrentItem();
}

class ConcreteIterator implements MyIterator{
    private $current = 0;
    private $list = [];

    function __construct($list = []){
        $this->list = $list;
    }
    function First(){
        $this->current = 0;
    }
    function Next(){
        $this->current++;
    }
    function IsDone(){
        return $this->current >= count($this->list);
    }
    function CurrentItem(){
        if($this->IsDone()){
            throw new Exception('数据错误'); 
        }
        return $this->list[$this->current];
    }
}

// Client
$iterator = ConcreteAggregate::CreateIterator();

// 遍历迭代器
while(!$iterator->IsDone()){
    print_r($iterator->CurrentItem());
    echo PHP_EOL;
    $iterator->next();
}
// 回到第一条
$iterator->First();
print_r($iterator->CurrentItem());