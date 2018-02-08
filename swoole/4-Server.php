<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/6
 * Time: 9:55
 */
//https://github.com/LinkedDestiny/swoole-doc/blob/master/04.Swoole多端口监听、热重启以及Timer进阶：简单crontab.md

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
            'debug_mode'    => 1
        ]);

        $this->serv->on('Start', [$this, 'onStart']);
        $this->serv->on('Connect', [$this, 'onConnect']);
        $this->serv->on('Receive', [$this, 'OnReceive']);
        $this->serv->on('Close', [$this, 'onClose']);

        $this->serv->addlistener("127.0.0.1", 9502, SWOOLE_TCP);

        $this->serv->start();
    }

    public function onStart($serv)
    {
        echo "Start\n";
    }

    public function onReceive(swoole_server $serv, $fd, $from_id, $data)
    {
        $info = $serv->connection_info($fd, $from_id);
        //来自9502的内网管理接口
        if ($info['from_port'] == 9502) {
            $serv->send($fd, "welcome admin\n");
        } else {
            $serv->send($fd, "Swoole: " . $data);
        }
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