<?php

class Context
{
    private $state;
    public function __construct(State $state)
    {
        $this->state = $state;
    }

    public function setState(State $state)
    {
        echo '当前状态：' . get_class($this->state), PHP_EOL;
        $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }

    public function Request()
    {
        $this->state->Handle($this);
    }
}

interface State
{
    public function Handle(Context $context);
}

class ConcreteStateA implements State
{
    public function Handle(Context $context)
    {
        $context->setState(new ConcreteStateB());
    }
}

class ConcreteStateB implements State
{
    public function Handle(Context $context)
    {
        $context->setState(new ConcreteStateA());
    }
}

$context = new Context(new ConcreteStateA());

$context->Request();
$context->Request();
$context->Request();
$context->Request();
