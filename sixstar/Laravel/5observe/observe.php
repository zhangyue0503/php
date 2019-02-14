<?php

// 抽象观察者，定义具体观察者的规范
// 约定方法名称
abstract class observe {
	public abstract function update();
}

// 具体的观察者
// 必须实现抽象类的接口
// 具体主题对象的引用 
class concreteOberse extends observe {
	private $subject;
	private $name;
	private $observeStatus;

	public function __construct( concreteSubject $subject, string $name ){
		$this->subject = $subject;
		$this->name = $name;
	}

	public function update(){
		$this->observeStatus = $this->subject->getSubjectStatus();
		// 不同状态可以做不同的动作
		print_r('观察者：' . $this->name . '状态：' . $this->observeStatus);

	}
}

// 抽象的主体类
abstract class subject{
	private $observes = [];

	public function attach(observe $observe){
		$this->observe[] = $observe;
	}

	public function detach(observe $observe){
		$tempArr = array_flip($this->$observes);
		unset($tempArr[$observe]);
		$this->observe[] = $tempArr;
	}

	public function notify(){
		foreach($this->observe as $k => $v){
			$v->update();
		}
	}
}

// 具体的主体类
// 将状态存入具体的观察者对象
// 状态发生改变，向观察者发送通知
class concreteSubject extends subject {
	private $subjectStatus;

	public function create(){
		$status = 'pay';
		if($status == 'pay'){
			$this->setSubjectStatus($status);
		}
	}

	public function getSubjectStatus(){
		return $this->$subjectStatus;
	}
	public function setSubjectStatus($value){
		$this->$subjectStatus = $value;
	}
}

class Client {
	public static function init(){
		$obj = new concreteSubject();
		$obj->attach(new concreteOberse($obj, 'Pack'));
		$obj->attach(new concreteOberse($obj, 'Peter'));
		// 接收到了结果通知
		$obj->setSubjectStatus('pay');
		$obj->notify();
	}
}

Client::init();

