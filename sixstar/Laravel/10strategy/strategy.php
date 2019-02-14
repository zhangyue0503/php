<?php

/**
 * 现金收费抽象类
 */
abstract class CashSuper
{
## 现金收取超类的抽象方法，收取现金，参数为原价，返回为当前价
    abstract public function acceptCash($money);
}
/**
 * 正常收费子类
 */
class CashNormal extends CashSuper
{
## 正常收费，原价返回
    public function acceptCash($money)
    {
        return $money;
    }
}
/**
 * 打折收费子类
 */
class CashRebate extends CashSuper
{
    private $moneyRebate = 1;
## 打折收费，初始化时，必须要输入打折折扣率 如八折，就是0.8
    public function __construct($moneyRebate)
    {
        $this->moneyRebate = $moneyRebate;
    }
    public function acceptCash($money)
    {
        return $money * $this->moneyRebate;
    }
}
/**
 * 返利收费子类
 */
class CashReturn extends CashSuper
{
    private $moneyCondition = 0;
    private $moneyReturn    = 0;
## 返利收费，初始化时必须要输入返回条件和返利值。比如满300返100，则$moneyCondition为300，$moneyReturn为100
    public function __construct($moneyCondition, $moneyReturn)
    {
        $this->moneyCondition = $moneyCondition;
        $this->moneyReturn    = $moneyReturn;
    }
    public function acceptCash($money)
    {
        $result = $money;
        if ($money >= $this->moneyCondition) {
## 若大于返利条件，则需要减去返利值
            $result = $money - $money / $this->moneyCondition * $this->moneyReturn;
        }
        return $result;
    }
}

//----策略模式实现
/**
 * CashContext类
 */
// class CashContext
// {
//     ## 声明一个CashSuper对象
//     private $cashSuper = null;
//
//     function __construct($cashSuper)
//     {
//         $this->cashSuper = $cashSuper;
//     }
//     ## 根据收费策略的不同，获得计算结果
//     public function getResult($money)
//     {
//         return $this->cashSuper->acceptCash($money);
//     }
// }
/**
 * 客户端
 */
// class Client
// {
//     public function index()
//     {
//         $cashContext = null;
//         switch ($_GET['discount']) {
//           case '正常收费':
//             $cashContext = new CashNormal();
//             break;
//           case '满300返100':
//             $cashContext = new CashReturn('300', '100');
//             break;
//           case '打八折':
//             $cashContext = new CashRebate('0.8');
//             break;
//         }
//         $price    = $_GET['price'];$quantity = $_GET['quantity'];
//         $money    = $price * $quantity;
//         ## 通过对Context的GetResult方法调用，可以得到收取费用的结果，让具体算法与客户进行了隔离
//         $result   = $cashContext->getResult($money);
//         echo "单价：$price 数量：$quantity 合计：$result";
//     }
// }

/**
 * CashContext类
 */
class CashContext
{
    ## 声明一个CashSuper对象
    private $cashSuper = null;
    ## 注意参数不是具体的收费策略对象，而是一个字符串，表示收费类型
    public function __construct($type)
    {
        switch ($type) {
            case '正常收费':
                $this->cashSuper = new CashNormal();
                break;
            case '满300返100':
                $this->cashSuper = new CashReturn('300', '100');
                break;
            case '打八折':
                $this->cashSuper = new CashRebate('0.8');
                break;
        }
    }
## 根据收费策略的不同，获得计算结果
    public function getResult($money)
    {
        return $this->cashSuper->acceptCash($money);
    }
}
/**
 * 客户端
 */
class Client
{
    public function index()
    {
        $cashContext = new CashContext($_GET['discount']);
        $price       = $_GET['price'];
        $quantity    = $_GET['quantity'];
        $money       = $price * $quantity;
        $result      = $cashContext->getResult($money);
        echo "单价：$price 数量：$quantity 合计：$result";
    }
}

$client = new Client();
$client->index();

## 简单工厂模式的用法
$cashSuper = $cashFactory->createCashAccept($_GET['discount']);
//...
$cashSuper->getResult($money);

## 策略模式与简单工厂结合的用法
$cashContext = new CashContext($_GET['discount']);
//...
$cashContext->getResult($money);
