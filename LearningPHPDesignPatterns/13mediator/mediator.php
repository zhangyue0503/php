<?php

abstract class Colleague {
	protected $mediator;
	public function __construct(Mediator $mediator) {
		$this->mediator = $mediator;
	}
}

abstract class Mediator {
	public abstract function Send(string $message, Colleague $colleague): void;
}

class ContcreteMediator extends Mediator {
	public $colleague1;
	public $colleague2;

	public function Send(string $message, Colleague $colleague): void {
		if ($colleague == $this->colleague1) {
			$this->colleague2->Notify($message);
		} else {
			$this->colleague1->Notify($message);
		}
	}
}

class ConcreteColleague1 extends Colleague {
	public function Send(string $message) {
		$this->mediator->Send($message, $this);
	}
    public function Notify(string $message){
        echo "同事1得到信息：" . $message;
    }
}

class ConcreteColleague2 extends Colleague {
	public function Send(string $message) {
		$this->mediator->Send($message, $this);
	}
    public function Notify(string $message){
        echo "同事2得到信息：" . $message;
    }
}

$m = new ContcreteMediator();

$c1 = new ConcreteColleague1($m);
$c2 = new ConcreteColleague2($m);

$m->colleague1 = $c1;
$m->colleague2 = $c2;

$c1->Send("吃过饭了吗？");
$c2->Send("没有呢，你打算请客？");
