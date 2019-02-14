<?php

// Command 命令
abstract class Command{
    protected $receiver;

    public function __construct(Receiver $receiver){
        $this->receiver = $receiver;
    }

    abstract public function execute();
}

// 命令具体实现
class ConcreateCommand extends Command{
    public function execute(){
        $this->receiver->action();
    }
}

// Invoker 请求者
class Invoker{
    private $command;

    public function setCommand(Command $command){
        $this->command = $command;
    }

    public function executeCommand(){
        $this->command->execute();
    }
}

// Receiver 接收者
class Receiver{
    public function action(){
        echo "命令执行啦！";
    }
}



// 实例化Receiver
$receiver = new Receiver();
// 实例化Command
$command = new ConcreateCommand($receiver);
// 实例化Invoker
$invoker = new Invoker();

// 设置命令
$invoker->setCommand($command);
// 执行命令
$invoker->executeCommand();
