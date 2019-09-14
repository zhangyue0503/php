<?php

interface Implementor
{
    public function OperationImp();
}

class ConcreteImplementorA implements Implementor
{
    function OperationImp()
    {
        echo 'ImpA';
    }
}

class ConcreteImplementorB implements Implementor
{
    public function OperationImp()
    {
        echo 'ImpB';
    }
}

abstract class Abstraction
{
    protected $imp;

    public function setImplementor(Implementor $imp)
    {
        $this->imp = $imp;
    }

    abstract public function Operation();
}

class RefinedAbstration extends Abstraction
{
    public function Operation()
    {
        $this->imp->OperationImp();
    }
}

$impA = new ConcreteImplementorA();
$impB = new ConcreteImplementorB();

$ref = new RefinedAbstration();

$ref->setImplementor($impA);
$ref->Operation();

$ref->setImplementor($impB);
$ref->Operation();
