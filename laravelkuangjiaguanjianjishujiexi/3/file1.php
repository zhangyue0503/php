<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/4/8
 * Time: 下午10:32
 */

namespace App\Http\Controllers\Auth;

function index(){
	echo '命名空间'.__NAMESPACE__."<br/>";
}

class Controller{
	public static function index(){
		echo '命名空间'.__NAMESPACE__."<br/>";
	}
}