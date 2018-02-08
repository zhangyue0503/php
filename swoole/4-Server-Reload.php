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
        $this->serv->on('WorkerStart', [$this, 'onWorkerStart']);
        $this->serv->on('Connect', [$this, 'onConnect']);
        $this->serv->on('Receive', [$this, 'OnReceive']);
        $this->serv->on('Close', [$this, 'onClose']);

        $this->serv->start();
    }

    public function onStart($serv)
    {
        echo "Start\n";
        cli_set_process_title("reload_master");
    }

    public function onWorkerStart($serv,$worker_id){
        require_once "reload_page.php";
        Test();
    }

    public function onReceive(swoole_server $serv, $fd, $from_id, $data)
    {
        echo "Get Message From Client {$fd}:{$data}\n";
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