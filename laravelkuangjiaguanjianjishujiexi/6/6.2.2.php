<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/4/12
 * Time: 下午9:50
 *
 * 请求处理管道
 *
 */
interface Middleware{
	public static function handle(Closure $next);
}
class VerifyCsrfToken implements Middleware {
	public static function handle(Closure $next)
	{
		echo "验证Csrf Token<br/>" . PHP_EOL;
		$next();
	}
}
class ShareErrorsFromSession implements Middleware {
	public static function handle(Closure $next)
	{
		echo "如果session中有'errors'变量，则共享它<br/>" . PHP_EOL;
		$next();
	}
}
class StartSession implements Middleware {
	public static function handle(Closure $next)
	{
		echo "开启session，获取数据<br/>" . PHP_EOL;
		$next();
		echo "保存数据，关闭session<br/>" . PHP_EOL;
	}
}
class AddQueuedCookiesToResponse implements Middleware {
	public static function handle(Closure $next)
	{
		$next();
		echo "添加下次请求需要的cookie<br/>" . PHP_EOL;
	}
}
class EncryptCookies implements Middleware {
	public static function handle(Closure $next)
	{
		echo "对输入请求的cookie进行解密<br/>" . PHP_EOL;
		$next();
		echo "对输出响应的cookie进行加密<br/>" . PHP_EOL;
	}
}
class CheckForMaintenanceMode implements Middleware {
	public static function handle(Closure $next)
	{
		echo "确定当前程序是否处于维护状态<br/>" . PHP_EOL;
		$next();
	}
}
function getSlice(){
	return function($stack, $pipe){
		return function() use ($stack, $pipe) {
			return $pipe::handle($stack);
		};
	};
}
function then(){
	$pipes = [
		"CheckForMaintenanceMode",
		"EncryptCookies",
		"AddQueuedCookiesToResponse",
		"StartSession",
		"ShareErrorsFromSession",
		"VerifyCsrfToken"
	];
	$firstSlice = function(){
		echo "请求向路由器传递，返回响应<br/>" . PHP_EOL;
	};
	$pipes = array_reverse($pipes);
	call_user_func(
		array_reduce($pipes, getSlice(),$firstSlice)
	);
}
then();

echo "================" . PHP_EOL;
echo "================" . PHP_EOL;
echo "================" . PHP_EOL;

interface Step{
	public static function go(Closure $next);
}
class FirstStep implements Step {
	public static function go(Closure $next)
	{
		echo "开启session，获取数据<br/>" . PHP_EOL;
		$next();
		echo "保存数据，关闭session<br/>" . PHP_EOL;
	}
}
function goFun($step, $className){
	return function() use ($step, $className){
		return $className::go($step);
	};
}
function then2(){
	$steps = ["FirstStep"];
	$prepare = function(){
		echo "请求向路由器传递，返回响应<br/>" . PHP_EOL;
	};

//	$go = function(){
//		return FirstStep::go(function(){
//			echo "请求向路由器传递，返回响应<br/>" . PHP_EOL;
//		});
//	};
	$go = array_reduce($steps, "goFun", $prepare);
	$go();
}
then2();