<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/4/7
 * Time: 下午9:45
 */
$app['router']->get('/',function(){
	return '<h1>路由成功</h1>';
});

$app['router']->get('welcome','App\Http\Controllers\WelcomeController@index');
