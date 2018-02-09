<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/9
 * Time: 14:30
 */
class Server
{
    private $http;

    function __construct()
    {
        $this->http = new swoole_http_server("127.0.0.1", 9501);

        $this->http->set([
            'worker_num'    => 16,
            'daemonize'     => false,
            'max_request'   => 10000,
            'dispatch_mode' => 1
        ]);

        $this->http->on('Start', [$this, 'onStart']);
        $this->http->on('request', [$this, 'onRequest']);
        $this->http->on('message', [$this, 'onMessage']);
        $this->http->start();
    }

    public function onStart($serv)
    {
        echo "Start\n";
    }

    public function onRequest($request, $response)
    {
        $response->end("<h1>Hello Swoole.</h1>");
    }

    public function onMessage($request, $response)
    {
        echo $request->message;
        $response->message(json_encode(["data1", "data2"]));
    }
}

new Server();