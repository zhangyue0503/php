<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/4/8
 * Time: 下午11:29
 */
//后期静态绑定
class A{
	public static function call(){
		echo "class A.<br/>";
	}
	public static function test(){
		self::call();
		static::call();
	}
}
class B extends A{
	public static function call(){
		echo "class B.<br/>";
	}
}
B::test();

//后期静态绑定
class AA{
	public function call(){
		echo "class A.<br/>";
	}
	public function test(){
		self::call();
		static::call();
	}
}
class BB extends AA{
	public function call(){
		echo "class B.<br/>";
	}
}

$bb = new BB();
$bb->test();

class AAA{
	public static function create(){
		$self = new self();
		$static = new static();
		return [$self,$static];
	}
}
class BBB extends AAA{

}

$arr = BBB::create();
foreach($arr as $value){
	var_dump($value);
}