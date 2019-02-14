<?php
// 使用php的iterator类
// http://php.net/manual/zh/class.iterator.php
// SPL相关迭代器类：http://php.net/manual/zh/class.iteratoriterator.php
// https://blog.csdn.net/hxx_yang/article/details/82915634
// 价值已经不大，foreach已经解决了不同结构和统一遍历接口的问题，如数字下标数组和字符数组的遍历，如果使用for来就很麻烦，需要对字符数组进行迭代器封装，但现在使用foreach就不用了，参考java中的ArrayList和数组更清晰，ArrayList的size()方法和get()取值，而数组是length()和下标，同样，java中也有forin来解决
// 外部只需要一种遍历方式就可以多态的遍历
// 我们可以尝试实现一个迭代器正向循环，而另外一个迭代器逆向循环，即从后往前遍历，只需要在迭代器中反转一下数组，而外部Client在遍历方法并不知道我们其实是从后往前遍历的，如发短信，用户很多，我们切分成两半，一边正序发送，一边倒序发送

class MyIterator implements Iterator
{
    private $position = 0;
    private $list     = [];

    public function __construct($list)
    {
        $this->position = 0;
        $this->list     = $list;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {

        return $this->list[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return isset($this->list[$this->position]);
    }
}

// Client
$list = [
    "a",
    "b",
    "c",
];
$it = new MyIterator($list);

foreach ($it as $key => $value) {
    var_dump($key, $value);
    echo PHP_EOL;
}
