<?php

class Product {
	private $parts = [];

	public function addPart($name) {
		array_push($this->parts, $name);
	}

	public function showPart() {
		foreach ($this->parts as $part) {
			echo $part, PHP_EOL;
		}
	}
}

abstract class Builder {
	protected $product;

	abstract public function buildPart1();
	abstract public function buildPart2();

	public function getResut() {
		return $this->product;
	}
}

class ConcreteBuilder1 extends Builder {
	function __construct() {
		$this->product = new Product();
	}
	public function buildPart1() {
		$this->product->addPart('PartA');
	}
	public function buildPart2() {
		$this->product->addPart('PartB');
	}
}

class ConcreteBuilder2 extends Builder {
	function __construct() {
		$this->product = new Product();
	}
	public function buildPart1() {
		$this->product->addPart('PartX');
	}
	public function buildPart2() {
		$this->product->addPart('PartY');
	}
}

class Director {
	public function construct(Builder $builder) {
		$builder->buildPart1();
		$builder->buildPart2();
		return $builder->getResut();
	}
}

$director = new Director();
$product1 = $director->construct(new ConcreteBuilder1());
$product1->showPart();

$product2 = $director->construct(new ConcreteBuilder2());
$product2->showPart();
