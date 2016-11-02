<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/2
 * Time: 上午10:52
 */
//简单的闭包
$closure = function($name){
    return sprintf('Hello %s',$name);
};

echo $closure("Josh");

//在array_map()函数中使用闭包
$numbersPlusOne = array_map(function($number){
    return $number+1;
},[1,2,3]);
print_r($numbersPlusOne);

//使用use关键字附加闭包的状态
function enclosePerson($name){
    return function($doCommand) use ($name){
        return sprintf("%s, %s",$name,$doCommand);
    };
}

$clay = enclosePerson('Clay');

echo $clay("get me tsweet tea!");

//使用bindTo方法附加闭包的状态
class App{
    protected $routes = array();
    protected $responseStatus = '200 ok';
    protected $responseContentType = 'text/html';
    protected $responseBody = "Hello world";

    public function addRoute($routePath,$routeCallback){
        $this->routes[$routePath] = $routeCallback->bindTo($this,__CLASS__);
    }

    public function dispatch($currentPath){
        foreach($this->routes as $routePath => $callback){
            if($routePath === $currentPath){
                $callback();
            }
        }
        header('Http/1.1 '.$this->responseStatus);
        header('Content-type: '.$this->responseContentType);
        header('Content-length: '.mb_strlen($this->responseBody));
        echo $this->responseBody;
    }
}

$app = new App();
$app->addRoute('/users/josh',function(){
    $this->responseContentType = 'application/json;charset=utf8';
    $this->responseBody = '{"name":"Josh"}';
});
$app->dispatch('/users/josh');

