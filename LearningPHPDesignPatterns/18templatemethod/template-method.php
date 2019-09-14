<?php

abstract class AbstractClass
{
    public function TemplateMethod(): void
    {
        echo "模板方法开始", PHP_EOL;
        $this->PrimitiveOperation1();
        $this->PrimitiveOperation2();
        echo "模板方法结束", PHP_EOL;
    }

    abstract public function PrimitiveOperation1();
    abstract public function PrimitiveOperation2();
}

class ConcreteClass extends AbstractClass
{
    public function PrimitiveOperation1()
    {
        echo "我是方法1", PHP_EOL;
    }

    public function PrimitiveOperation2()
    {
        echo "我是方法2", PHP_EOL;
    }
}


$c = new ConcreteClass();
$c->TemplateMethod();