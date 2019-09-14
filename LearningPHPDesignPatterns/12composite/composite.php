<?php

abstract Class Component
{
    protected $name;

    public function __construct($name){
        $this->name = $name;
    }
    public abstract function Add(Component $c):void;
    public abstract function Remove(Component $c):void;
    public abstract function Display(int $depth):void;
}

Class Leaf extends Component
{
    public function Add(Component $c):void{
        echo 'Cannot add to a leaf' . PHP_EOL;
    }
    public function Remove(Component $c):void{
        echo 'Cannot remove from a leaf' . PHP_EOL;
    }
    public function Display(int $depth):void{
        echo str_repeat('-', $depth) . $this->name . PHP_EOL;
    }
}

Class Composite extends Component
{
    private $children = [];

    public function Add(Component $c):void{
        array_push($this->children, $c);
    }
    public function Remove(Component $c):void{
        $position = 0;
        foreach ($this->children as $child) {
            ++$position;
            if ($child == $c) {
                array_splice($this->children, ($position), 1);
            }
        }
    }
    public function Display(int $depth):void{
        echo str_repeat('-', $depth) . $this->name . PHP_EOL;
        foreach($this->children as $child){
            $child->Display($depth + 2);
        }
    }
}

$root = new Composite("root");
$root->Add(new Leaf("Leaf A"));
$root->Add(new Leaf("Leaf B"));

$comp = new Composite("Composite X");
$comp->Add(new Leaf("Leaf XA"));
$comp->Add(new Leaf("Leaf XB"));

$root->Add($comp);

$comp2 = new Composite("Composite XY");
$comp2->Add(new Leaf("Leaf XYA"));
$comp2->Add(new Leaf("Leaf XYB"));

$comp->Add($comp2);

$root->Add(new Leaf("Leaf C"));

$leaf = new Leaf("Leaf D");
$root->Add($leaf);
$root->remove($leaf);

$root->Display(1);

