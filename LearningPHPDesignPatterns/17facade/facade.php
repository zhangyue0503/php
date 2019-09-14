<?php

class SubSystemOne
{
    public function MethodOne(): void
    {
        echo '子系统方法一' . PHP_EOL;
    }
}

class SubSystemTwo
{
    public function MethodTwo(): void
    {
        echo '子系统方法二' . PHP_EOL;
    }
}

class SubSystemThree
{
    public function MethodThree(): void
    {
        echo '子系统方法三' . PHP_EOL;
    }
}

class SubSystemFour
{
    public function MethodFour(): void
    {
        echo '子系统方法四' . PHP_EOL;
    }
}

class Facade
{
    public $subSystemOne;
    public $subSystemTwo;
    public $subSystemThree;
    public $subSystemFour;
    
    public function __construct()
    {
        $this->subSystemOne   = new SubSystemOne();
        $this->subSystemTwo   = new SubSystemTwo();
        $this->subSystemThree = new SubSystemThree();
        $this->subSystemFour  = new SubSystemFour();
    }

    public function MethodA(): void
    {
        echo '方法组A() ---- ' . PHP_EOL;
        $this->subSystemOne->MethodOne();
        $this->subSystemTwo->MethodTwo();
        $this->subSystemThree->MethodThree();
    }

    public function MethodB(): void
    {
        echo '方法组B() ---- ' . PHP_EOL;
        $this->subSystemThree->MethodThree();
        $this->subSystemFour->MethodFour();
    }
}

$facade = new Facade();

$facade->MethodA();
$facade->MethodB();
