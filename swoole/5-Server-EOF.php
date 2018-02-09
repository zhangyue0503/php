<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/6
 * Time: 9:55
 */
//https://github.com/LinkedDestiny/swoole-doc/blob/master/02-Swoole的Task使用以及swoole_client.md

class Server
{
    private $serv;

    public function __construct()
    {
        $this->serv = new swoole_server('0.0.0.0', 9501);
        $this->serv->set([
            'worker_num'         => 8,
            'daemonize'          => false,
            'max_request'        => 10000,
            'dispatch_mode'      => 2,
            'debug_mode'         => 1,
            'package_max_length' => 8192,
            'open_eof_check'     => true,
            'package_eof'        => "\r\n"
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
        $data_list = explode("\r\n", $data);
        foreach($data_list as $msg){
            if(!empty($msg)){
                echo "Get Message From Client {$fd}:{$msg}\n";
            }
        }
    }

    public function onConnect($serv, $fd, $from_id)
    {
        $serv->send($fd, "Hello {$fd}!");
    }

    function onClose($serv, $fd, $from_id)
    {
        echo "Client {$fd} close connection\n";
    }
}

$server = new Server();