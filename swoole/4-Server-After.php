<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/6
 * Time: 9:55
 */
//https://github.com/LinkedDestiny/swoole-doc/blob/master/03.Timer定时器、心跳检测及Task进阶实例：mysql连接池.md

class Server
{
    private $serv;

    public function __construct()
    {
        $this->serv = new swoole_server('0.0.0.0', 9501);
        $this->serv->set([
            'worker_num'    => 8,
            'daemonize'     => false,
            'max_request'   => 10000,
            'dispatch_mode' => 2,
            'debug_mode'    => 1,
        ]);

        $this->serv->on('Start', [$this, 'onStart']);
        $this->serv->on('Connect', [$this, 'onConnect']);
        $this->serv->on('Receive', [$this, 'OnReceive']);
        $this->serv->on('Close', [$this, 'onClose']);

        $this->serv->start();
    }



    public function onStart($serv)
    {
        echo "Start\n";
    }

    public function onReceive(swoole_server $serv, $fd, $from_id, $data)
    {
        echo "Get Message From Client {$fd}:{$data}\n";

        $param = [
            'fd'  => $fd,
            'msg' => $data
        ];
        $str = json_encode($param);
        $serv->after(1000, [$this, 'onAfter'], $str);
    }

    public function onAfter($data)
    {
        $param = json_decode($data, true);
        $this->serv->send($param['fd'], $param['msg']);
    }

    public function onConnect($serv, $fd, $from_id)
    {
        echo "Client {$fd} connect\n";
    }

    function onClose($serv, $fd, $from_id)
    {
        echo "Client {$fd} close connection\n";
    }
}

$server = new Server();