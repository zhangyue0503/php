<?php

class Originator
{
    private $state;
    public function SetMemento(Memento $memento)
    {
        $this->state = $memento->getState();
    }
    public function CreateMemento()
    {
        return new Memento($this->state);
    }

    public function getState()
    {
        return $this->state;
    }
    public function setState($val)
    {
        $this->state = $val;
    }
    public function ShowState()
    {
        echo 'State = ' . $this->state . PHP_EOL;
    }
}

class Memento
{
    private $state;
    public function __construct($state)
    {
        $this->state = $state;
    }
    public function getState()
    {
        return $this->state;
    }
}

class Caretaker
{
    private $memento;
    public function getMemento()
    {
        return $this->memento;
    }
    public function setMemento($memento)
    {
        $this->memento = $memento;
    }
}

$originator = new Originator();
$originator->setState('aa');
$originator->ShowState();

$caretaker = new Caretaker();
$caretaker->setMemento($originator->CreateMemento());

$originator->setState('bb');
$originator->ShowState();

$originator->SetMemento($caretaker->getMemento());
$originator->ShowState();
