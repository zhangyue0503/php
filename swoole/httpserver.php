<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/5
 * Time: 14:42
 */

$http = new swoole_http_server('127.0.0.1',9501);
$http->on("start",function($server){
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$http->on("request",function($request,$response){
    $response->header("Content-Type", "text/plain");
    $response->end("Hello World\n");
});

$http->start();