<?php
/**
 * Command类用来声明执行操作的接口
 * 定义接口标准
 */
abstract class Command
{
    protected $receiver;

    function __construct(Receiver $receiver )
    {
        $this->receiver = $receiver;
    }

    public abstract function execute();
}

/**
 * ConcreteCommand类，将一个接收者对象绑定于一个动作，调用接收者相应的操作，以实习execute
 */
class ConcreteCommand extends Command
{
    public function execute()
    {
        $this->receiver->action();
    }
}

/**
 * Invoker类，要求该命令执行这个请求
 */
class Invoker
{
    private $command;

    public function setCommand(Command $command)
    {
        $this->command = $command;
    }

    public function executeCommand()
    {
        $this->command->execute();
    }
}

/**
 * Receiver类，知道如何实施与执行一个与请求相关的操作，如何类都可以作为一个接收者
 */
class Receiver
{
    public function action()
    {
        echo "执行请求!<br>";
    }
}

/**
 *
 */
class Client
{
    public static function index()
    {
        $r = new Receiver();            //实例化具体业务对象
        $c = new ConcreteCommand($r);   //实例化具体的命令对象（注入业务对象）
        $i = new Invoker();             //实例化命令对象

        $i->setCommand($c);             //设置好命令
        $i->executeCommand();           //执行命令

    }
}

Client::index();
