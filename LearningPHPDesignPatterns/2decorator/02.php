<?php
abstract class IComponent
{
    protected $date;
    protected $ageGroup;
    protected $feature;

    abstract public function setAge($ageNow);
    abstract public function getAge();
    abstract public function getFeature();
    abstract public function setFeature($fea);
}

// 具体组件
class Male extends IComponent
{
    public function __construct()
    {
        $this->date = "Male";
        $this->setFeature("Dude programmer features: ");
    }
    public function getAge()
    {
        return $this->ageGroup;
    }
    public function setAge($ageNow)
    {
        $this->ageGroup = $ageNow;
    }
    public function getFeature()
    {
        return $this->feature;
    }
    public function setFeature($fea)
    {
        $this->feature = $fea;
    }
}
class Female extends IComponent
{
    public function __construct()
    {
        $this->date = "Female";
        $this->setFeature("Grrrl programmer features: ");
    }
    public function getAge()
    {
        return $this->ageGroup;
    }
    public function setAge($ageNow)
    {
        $this->ageGroup = $ageNow;
    }
    public function getFeature()
    {
        return $this->feature;
    }
    public function setFeature($fea)
    {
        $this->feature = $fea;
    }
}

// 装饰器参与者
abstract class Decorator extends IComponent
{
	public function setAge($ageNow)
	{
		$this->ageGroup = $ageNow;
	}
	public function getAge()
	{
		return $this->ageGroup;
	}
}

// 具体装饰器
class ProgramLang extends Decorator
{
	private $languageNow;

	public function __construct(IComponent $dateNow)
	{
		$this->date = $dateNow;
	}

	private $language = [
		"php"	=> "php",
		"cs"	=> "C#",
		"js"	=> "JavaScript",
		"as3"	=> "ActionScript 3.0"
	];

	public function setFeature($lan)
	{
		$this->languageNow = $this->language[$lan];
	}

	public function getFeature()
	{
		$output = $this->date->getFeature() 
			. " Preferred programming language: "
			. $this->languageNow;
		return $output;
	}
}

class Hardware extends Decorator
{
	private $hardwareNow;

	public function __construct(IComponent $dateNow)
	{
		$this->date = $dateNow;
	}

	private $box = [
		"mac"	=> "Mac",
		"dell"	=> "Dell",
		"hp"	=> "Hewleet-Packard",
		"lin"	=> "Linux"
	];

	public function setFeature($hdw)
	{
		$this->hardwareNow = $this->box[$hdw];
	}

	public function getFeature()
	{
		$output = $this->date->getFeature() 
			. " Current Hardware: "
			. $this->hardwareNow;
		return $output;
	}
}

class Food extends Decorator
{
	private $chowNow;

	public function __construct(IComponent $dateNow)
	{
		$this->date = $dateNow;
	}

	private $snacks = [
		"piz"	=> "Pizza",
		"burg"	=> "Burgers",
		"nach"	=> "Nachos",
		"veg"	=> "Veggies"
	];

	public function setFeature($yum)
	{
		$this->chowNow = $this->snacks[$yum];
	}

	public function getFeature()
	{
		$output = $this->date->getFeature() 
			. " Favorite food: "
			. $this->chowNow;
		return $output;
	}
}

// 练习扩展一个电影的
class Movie extends Decorator
{
	private $movieNow;

	public function __construct(IComponent $dateNow)
	{
		$this->date = $dateNow;
	}

	public $movies = [
		"tt"	=> "TT",
		"vv"	=> "VV"
	];

	public function setFeature($m)
	{
		$this->movieNow = $this->movies[$m];
	}

	public function getFeature()
	{
		$output = $this->date->getFeature()
			. " Like Moive is:"
			. $this->movieNow;
		return $output;
	}
}

// 客户
class Client {
	private $hotDate;

	public function __construct() {
		$this->hotDate = new Male();
		$this->hotDate->setAge("Age Group 4");
		echo $this->hotDate->getAge();
		$this->hotDate = $this->wrapComponent($this->hotDate);
		echo $this->hotDate->getFeature();
	}

	private function wrapComponent(IComponent $component) {
		$component = new ProgramLang($component);
		$component->setFeature('php');
		$component = new Hardware($component);
		$component->setFeature('mac');
		$component = new Food($component);
		$component->setFeature('piz');

		$component = new Movie($component);
		$component->setFeature('tt');

		return $component;
	}
}

$worker = new Client();
