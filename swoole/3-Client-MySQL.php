<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/6
 * Time: 14:38
 */
class Client
{
    private $client;
    private $i = 0;
    private $time;

    public function __construct()
    {
        $this->client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
        $this->client->on("Connect", [$this, 'onConnect']);
        $this->client->on("Receive", [$this, 'onReceive']);
        $this->client->on("Close", [$this, 'onClose']);
        $this->client->on("Error", [$this, 'onError']);
    }

    public function connect()
    {
        if (!$this->client->connect("127.0.0.1", 9501, 1)) {
            echo "Error: {$fp->errMsg}[{$fp->errCode}]\n";
            return;
        }
    }

    public function onReceive($cli, $data)
    {
        $this->i++;
        if($this->i >= 10000){
            echo "Use Time: ". (time() - $this->time);
            exit(0);
        }else{
            $cli->send("Get");
        }
    }

    public function onConnect($cli)
    {
        $cli-<send("Get");
        $this->time = time();
    }

    public function onClose($cli){
        echo "Client close connection\n";
    }

    public function onError(){

    }

    public function send($data){
        $this->client->send($data);
    }

    public function isConnected(){
        return $this->client->isConnected();
    }
}

$client = new Client();
$client->connect();