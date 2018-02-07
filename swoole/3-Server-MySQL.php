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
    private $pdo;

    public function __construct()
    {
        $this->serv = new swoole_server('0.0.0.0', 9501);
        $this->serv->set([
            'worker_num'      => 8,
            'daemonize'       => false,
            'max_request'     => 10000,
            'dispatch_mode'   => 3,
            'debug_mode'      => 1,
            'task_worker_num' => 8,
        ]);

        $this->serv->on('WorkerStart', [$this, 'onWorkerStart']);
        $this->serv->on('Connect', [$this, 'onConnect']);
        $this->serv->on('Receive', [$this, 'OnReceive']);
        $this->serv->on('Close', [$this, 'onClose']);

        $this->serv->on('Task', [$this, 'onTask']);
        $this->serv->on('Finish', [$this, 'onFinish']);

        $this->serv->start();
    }

    public function onTask($serv, $task_id, $from_id, $data)
    {
        try {
            $sql = json_decode($data, true);
            $statement = $this->pdo->prepare($sql['sql']);
            $statement->execute($sql['param']);

            $serv->send($sql['fd'], "Insert");
            return true;
        } catch (PDOException $e) {
            var_dump($e);
            return false;
        }
    }

    public function onFinish($task, $task_id, $data)
    {
        echo "Task {$task_id} finish\n";
        echo "Result: {$data}\n";
    }


    public function onWorkerStart($serv, $worker_id)
    {
        //在Worker进程开启时绑定定时器
        echo "onWorkerStart\n";
        //判定是否为Task Worker进程
        if ($worker_id >= $serv->setting['worker_num']) {
            $this->pdo = new PDO(
                "mysql:host=localhost;port=3306;dbname=Test",
                "root", "", [
//                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8';",
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_PERSISTENT         => true

                ]
            );
        }
    }

    public function onReceive(swoole_server $serv, $fd, $from_id, $data)
    {
        echo "Get Message From Client {$fd}:{$data}\n";

        $sql = [
            'sql'   => 'Insert into test values(pid=?,name=?)',
            'param' => [
                null, "'name'"
            ],
            'fd'    => $fd
        ];
        $serv->task(json_encode($sql));
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