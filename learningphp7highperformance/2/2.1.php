<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/10/26
 * Time: 下午10:31
 */
//形参类型声明
class Person
{
	public function age(int $age):int
	{
		return $age;
	}

	public function name(string $name):string
	{
		return $name;
	}

	public function isAlive(bool $alive):bool
	{
		return $alive;
	}
}

$person = new Person();
echo $person->name('Altaf Hussain');
echo $person->age(30);
echo $person->isAlive(TRUE);

//匿名类
class Packt{
	protected $number;
	public function __construct()
	{
		echo 'I am parent constructor';
	}
	public function getNumber() : float{
		return $this->number;
	}
}

$number = new class(5) extends Packt {
	public function __construct(float $number)
	{
		parent::__construct();
		$this->number = $number;
	}
};
echo $number->getNumber();

//统一变量语法
$first = ['name'=>'second'];
$second = 'Howdy';
echo $$first['name'];
echo ${$first['name']};