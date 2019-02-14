<?php

// 参与者
// 增加维护observers，观察者列表
// 定义update方法
abstract class Subject
{
    protected $stateNow;
    protected $observers = [];

    public function attachObser(Observer $obser)
    {
        array_push($this->observers, $obser);
    }

    public function detachObser(Observer $obser)
    {
        $position = 0;
        foreach ($this->observers as $viewer) {
            ++$position;
            if ($viewer == $obser) {
                array_splice($this->observers, ($position), 1);
            }
        }
    }
    protected function notify()
    {
        foreach ($this->observers as $viewer) {
            $viewer->update($this);
        }
    }
}

// 参与者实现
class ConcreteSubject extends Subject
{
    public function setState($stateSet)
    {
        $this->stateNow = $stateSet;
        $this->notify();
    }

    public function getState()
    {
        return $this->stateNow;
    }
}

// 观察者接口
interface Observer
{
    public function update(Subject $subject);
}

// 观察者实现1
class ConcreteObserverDT implements Observer
{
    private $currentState;

    public function update(Subject $subject)
    {
        $this->currentState = $subject->getState();
        echo "DT：" . $this->currentState . PHP_EOL;
    }
}
// 观察者实现2
class ConcreteObserverPhone implements Observer
{
    private $currentState;

    public function update(Subject $subject)
    {
        $this->currentState = $subject->getState();
        echo "Phone：" . $this->currentState . PHP_EOL;
    }
}
// 观察者实现3
class ConcreteObserverTablet implements Observer
{
    private $currentState;

    public function update(Subject $subject)
    {
        $this->currentState = $subject->getState();
        echo "Tablet：" . $this->currentState . PHP_EOL;
    }
}

class Client
{
    public function __construct()
    {
        $sub = new ConcreteSubject();

        $ob1 = new ConcreteObserverPhone();
        $ob2 = new ConcreteObserverTablet();
        $ob3 = new ConcreteObserverDT();

        $sub->attachObser($ob1);
        $sub->attachObser($ob2);
        $sub->attachObser($ob3);

        $sub->setState('decoCar');
    }
}

$worker = new Client();
