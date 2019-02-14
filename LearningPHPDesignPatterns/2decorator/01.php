<?php
abstract class IComponent {
	protected $site;
	abstract public function getSite();
	abstract public function getPrice();
}

abstract class Decorator extends IComponent {
	// 继承getSite()和getPrice()
	// 这仍是一个抽象类
	// 这里不需要实现任何一个抽象方法
	// 任务是维护Component的引用
	// public function getSite(){}
	// public function getPrice(){}
}

// 具体组件
class BasicSite extends IComponent {
	public function __construct() {
		$this->site = "Basic Site";
	}
	public function getSite() {
		return $this->site;
	}
	public function getPrice() {
		return 1200;
	}
}

// 具体装饰器
class Maintenance extends Decorator {
	public function __construct(IComponent $siteNow) {
		$this->site = $siteNow;
	}
	public function getSite() {
		$fmat = "<br/>&nbsp;&nbsp; Maintenance";
		return $this->site->getSite() . $fmat;
	}
	public function getPrice() {
		return 950 + $this->site->getPrice();
	}
}

class Video extends Decorator {
	public function __construct(IComponent $siteNow) {
		$this->site = $siteNow;
	}
	public function getSite() {
		$fmat = "<br/>&nbsp;&nbsp; Video";
		return $this->site->getSite() . $fmat;
	}
	public function getPrice() {
		return 350 + $this->site->getPrice();
	}
}

class Database extends Decorator {
	public function __construct(IComponent $siteNow) {
		$this->site = $siteNow;
	}
	public function getSite() {
		$fmat = "<br/>&nbsp;&nbsp; MySQL Database";
		return $this->site->getSite() . $fmat;
	}
	public function getPrice() {
		return 800 + $this->site->getPrice();
	}
}

// 客户
class Client {
	private $basicSite;

	public function __construct() {
		$this->basicSite = new BasicSite();
		$this->basicSite = $this->wrapComponent($this->basicSite);

		$siteNow = $this->basicSite->getSite();
		$format = "<br/>&nbsp;&nbsp; <strong>Total=$";
		$price = $this->basicSite->getPrice();
		echo $siteNow . $format . $price . "</strong><p/>";
	}

	private function wrapComponent(IComponent $component) {
		$component = new Maintenance($component);
		$component = new Video($component);
		$component = new Database($component);
		return $component;
	}
}

$worker = new Client();