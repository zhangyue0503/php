<?php

class Context
{
    public $strategy;
    public function __construct($strategy){
        $this->strategy = $strategy;
    }
    public function contextInterface()
    {
        return $this->strategy->algorithmInterface();
    }
}

interface Strategy
{
    public function algorithmInterface();
}

class ConcreateStrategyA implements Strategy
{
    public function algorithmInterface()
    {
        echo 'A';
    }
}

class ConcreateStrategyB implements Strategy
{
    public function algorithmInterface()
    {
        echo 'B';
    }
}

class ConcreateStrategyC implements Strategy
{
    public function algorithmInterface()
    {
        echo 'C';
    }
}

$ctx = new Context(new ConcreateStrategyA());
echo $ctx->contextInterface();

$ctx = new Context(new ConcreateStrategyB());
echo $ctx->contextInterface();

$ctx = new Context(new ConcreateStrategyC());
echo $ctx->contextInterface();

