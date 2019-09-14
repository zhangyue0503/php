<?php

class Singleton
{
    private static $uniqueInstance;
    public $singletonData;

    private function __construct()
    {
        $this->singletonData = '单例数据';
    }

    public static function GetInstance(): Singleton
    {
        if (self::$uniqueInstance == null) {
            self::$uniqueInstance = new Singleton();
        }
        return self::$uniqueInstance;
    }

    public function SingletonOperation()
    {
        echo $this->singletonData, PHP_EOL;
    }

}

$singleA = Singleton::GetInstance();
$singleB = Singleton::GetInstance();

if ($singleA === $singleB) {
    echo '相同的', PHP_EOL;
}

$singleA->SingletonOperation();
$singleB->SingletonOperation();
