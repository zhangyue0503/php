<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/4/8
 * Time: 下午10:33
 */
namespace App\Http\Controllers;

include 'file1.php';
function index(){
	echo '命名空间'.__NAMESPACE__."<br/>";
}

class Controller{
	static function index(){
		echo '命名空间'.__NAMESPACE__."<br/>";
	}
}

index();

Controller::index();

Auth\index();
Auth\Controller::index();

\App\Http\Controllers\index();
\App\Http\Controllers\Auth\Controller::index();