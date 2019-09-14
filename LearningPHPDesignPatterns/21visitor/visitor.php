<?php

abstract class Visitor
{
    abstract public function VisitConcreteElementA(ConcreteElementA $concreteElementA);
    abstract public function VisitConcreteElementB(ConcreteElementB $concreteElementB);
}

class ConcreteVisitor1 extends Visitor
{
    public function VisitConcreteElementA(ConcreteElementA $concreteElementA)
    {
        echo get_class($concreteElementA) . "被" . get_class($this) . "访问", PHP_EOL;
    }
    public function VisitConcreteElementB(ConcreteElementB $concreteElementB)
    {
        echo get_class($concreteElementB) . "被" . get_class($this) . "访问", PHP_EOL;
    }
}

class ConcreteVisitor2 extends Visitor
{
    public function VisitConcreteElementA(ConcreteElementA $concreteElementA)
    {
        echo get_class($concreteElementA) . "被" . get_class($this) . "访问", PHP_EOL;
    }
    public function VisitConcreteElementB(ConcreteElementB $concreteElementB)
    {
        echo get_class($concreteElementB) . "被" . get_class($this) . "访问", PHP_EOL;
    }
}

abstract class Element
{
    abstract public function Accept(Visitor $visitor);
}

class ConcreteElementA extends Element
{
    public function Accept(Visitor $visitor)
    {
        $visitor->VisitConcreteElementA($this);
    }

    public function OperationA()
    {

    }
}

class ConcreteElementB extends Element
{
    public function Accept(Visitor $visitor)
    {
        $visitor->VisitConcreteElementB($this);
    }

    public function OperationB()
    {

    }
}

class ObjectStructure
{
    private $elements = [];

    public function Attach(Element $element)
    {
        $this->elements[] = $element;
    }

    public function Detach(Element $element)
    {
        $position = 0;
        foreach ($this->elements as $e) {
            if ($e == $element) {
                unset($this->elements[$position]);
                break;
            }
            $position++;
        }
    }

    public function Accept(Visitor $visitor)
    {
        foreach ($this->elements as $e) {
            $e->Accept($visitor);
        }
    }
}

$o = new ObjectStructure();
$o->Attach(new ConcreteElementA());
$o->Attach(new ConcreteElementB());

$v1 = new ConcreteVisitor1();
$v2 = new ConcreteVisitor2();

$o->Accept($v1);
$o->Accept($v2);