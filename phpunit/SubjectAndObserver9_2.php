<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/30
 * Time: 14:55
 */
class Subject
{
    protected $observers = [];
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function attach(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    public function doSomething()
    {
        // 做点什么
        // ...

        // 通知观察者发生了些什么
        $this->notify('something');
    }

    public function doSomethingBad()
    {
        foreach ($this->observers as $observer) {
            $observer->reportError(42, 'Something bad happened', $this);
        }
    }

    protected function notify($argument)
    {
        foreach ($this->observers as $observer) {
            $observer->update($argument);
        }
    }

    // 其他方法。
}

class Observer
{
    public function update($argument)
    {
        // 做点什么。
    }

    public function reportError($errorCode, $errorMessage, Subject $subject)
    {
        // 做点什么。
    }

    // 其他方法。
}