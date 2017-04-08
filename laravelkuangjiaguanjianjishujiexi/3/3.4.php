<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/4/8
 * Time: 下午11:18
 */
//反射
class A {
	public function call(){
		echo "Hello wshuo";
	}
}

$ref = new ReflectionClass('A');
$inst = $ref->newInstanceArgs();
$inst->call();