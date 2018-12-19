<?php

class db {
	public function __construct(){

	}
	public function connect(){
		echo 'packphp';
	}
}

class IoC {
	// 容器数组
	protected static $reg = [];

	// 添加反转对象到容器中
	public static function register($name, Closure $reslove){
		static::$reg[$name] = $reslove;
	}

	// 根据name返回实例
	// 内部控制对象创建，实现控制反转
	public static function resolve($name){
		if(static::$reg[$name]){
			// laravel中此处使用ReflectionClass创建对象
			$obj = static::$reg[$name];
			// 返回的时候才创建对象
			return $obj();
		}
	}
}

// 闭包不会马上创建对象
IoC::register('db', function() {
	return new db();
});
// 调用容器指定对象
// 控制反转到外部
$db = IoC::resolve('db');

$db->connect();