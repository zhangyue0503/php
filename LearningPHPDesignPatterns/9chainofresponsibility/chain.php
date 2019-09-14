<?php

abstract class Handler {
	protected $successor;

	public function setSuccessor(Handler $nextHandler) {
		$this->successor = $nextHandler;
	}

	abstract public function HandleRequest();
}

class ConcreteHandler1 extends Handler {
	public function HandleRequest() {
		echo 'ConcreteHandler1->HandleRequest' . PHP_EOL;

		if ($this->successor != null) {
			$this->successor->HandleRequest();
		} else {
			echo 'Success1' . PHP_EOL;
		}
	}
}

class ConcreteHandler2 extends Handler {
	public function HandleRequest() {
		echo 'ConcreteHandler2->HandleRequest' . PHP_EOL;

		if ($this->successor != null) {
			$this->successor->HandlerRequest();
		} else {
			echo 'Success2' . PHP_EOL;
		}
	}
}

$ch1 = new ConcreteHandler1();
$ch2 = new ConcreteHandler2();
$ch1->setSuccessor($ch2);
$ch1->HandleRequest();
