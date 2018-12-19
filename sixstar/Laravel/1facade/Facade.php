<?php
include './Function1.php';
include './Function2.php';
class Facade {
	private $obj1;
	private $obj2;


	public function __construct() {
		$this->obj1 = new Function1();
		$thos->obj2 = new Function2();
	}

	public functio method1(){
		$this->obj1->method1();
	}
}

$facde = new Facade();
$facde->method1();