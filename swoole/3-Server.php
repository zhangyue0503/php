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
            'worker_num'               => 8,
            'daemonize'                => false,
            'max_request'              => 10000,
            'dispatch_mode'            => 2,
            'debug_mode'               => 1,
            'heartbeat_check_interval' => 60,//心跳检测，遍历一次全部连接
            'heartbeat_idle_time'      => 600,//差值大于则强制关闭连接
        ]);

        $this->serv->on('WorkerStart', [$this, 'onWorkerStart']);
        $this->serv->on('Connect', [$this, 'onConnect']);
        $this->serv->on('Receive', [$this, 'OnReceive']);
        $this->serv->on('Close', [$this, 'onClose']);
        $this->serv->on('Timer', [$this, 'onTimer']);

        $this->serv->start();
    }

    public function onTimer($serv, $interval)
    {
        switch ($interval) {
            case 500: {
                echo "Do Thing A at interval 500\n";
                break;
            }
            case 1000: {
                echo "Do Thing B at interval 1000\n";
                break;
            }
            case 100: {
                echo "Do Thing C at interval 100\n";
                break;
            }
        }
    }


    public function onWorkerStart($serv, $worker_id)
    {
        //在Worker进程开启时绑定定时器
        echo "onWorkerStart\n";
        //只有当worker_id为0时才添加定时器，避免重复添加
        if ($worker_id == 0) {
//            $serv->addtimer(100);
//            $serv->addtimer(500);
//            $serv->addtimer(1000);
            swoole_timer_tick(100, function ($timer_id) {
                echo "tick-100ms\n";
            });
            swoole_timer_after(500, function ($timer_id) {
                echo "tick-500ms\n";
            });
            swoole_timer_tick(1000, function ($timer_id) {
                echo "tick-1000ms\n";
            });

        }
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