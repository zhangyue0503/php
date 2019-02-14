<?php

interface Middleware
{
    public static function handle(Closure $next);
}

class VerifyCsrfToken implements Middleware
{
    public static function handle(Closure $next)
    {
        echo "验证Csrf-Token"."<br/>";
        $next();
    }
}
class ShareErrorsFromSession implements Middleware
{
    public static function handle(Closure $next)
    {
        echo "如果Session中有'errors'变量，则共享它"."<br/>";
        $next();
    }
}
class StartSession implements Middleware
{
    public static function handle(Closure $next)
    {
        echo "开启session,获取数据"."<br/>";
        $next();
        echo "保存数据，关闭session"."<br/>";
    }
}
class AddQueuedCookiesToResponse implements Middleware
{
    public static function handle(Closure $next)
    {
        $next();
        echo "添加下一次请求需要的cookie"."<br/>";
    }
}
class EncryptCookies implements Middleware
{
    public static function handle(Closure $next)
    {
        echo "对输入的cookies进行解密"."<br/>";
        $next();
        echo "对输出响应的cookie进行加密"."<br/>";
    }
}
class CheckForMaintenanceMode implements Middleware
{
    public static function handle(Closure $next)
    {
        echo "确定当前程序是否处于维护状态"."<br/>";
        $next();
    }
}

/*
*函数getSlice()中的"()"需要留意。
*使用"function getSlice())"时，在array_reduce()中需要用“array($a,getSlice(),$b)”
*使用"function getSlice"时，在array_reduce()中需要用“array($a,"getSlice",$b)”。
*具体情况可以参考《Laravel框架关键技术解析---高清版.pdf》中“请求处理管道”一章
*/

function getSlice()
{
    return function ($stack, $pipe) {
        return function () use ($stack,$pipe) {
            return $pipe::handle($stack);
        };
    };
}

function then()
{
    $pipes = [
        "CheckForMaintenanceMode",
        "EncryptCookies",
        "AddQueuedCookiesToResponse",
        "StartSession",
        "ShareErrorsFromSession",
        "VerifyCsrfToken"
    ];
    $firstSlice = function () {
        echo "请求向路由传递，返回响应"."<br/>";
    };
    $pipes	= array_reverse($pipes); //把数组里的顺序颠倒一下，头变尾，尾变头
    call_user_func(
        array_reduce($pipes, getSlice(), $firstSlice)  //把$pipes传入getSlice()里的$pipe,$firstSlice传入getSlice()里的$stack。且$firstSlice只传一次，$pipes数组每次传一个值，从尾部开始传，直到传完所有制为止。
    );
}

then();
