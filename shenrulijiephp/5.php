<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/1
 * Time: 上午9:54
 */
class Pet{
    public $name;
    function __construct($pet_name)
    {
        $this->name = $pet_name;
        self::sleep();
    }

    function eat(){
        echo "<p>$this->name is eating</p>";
    }
    function sleep(){
        echo "<p>$this->name is sleeping</p>";
    }

    function play(){
        echo "<p>$this->name is playing";
    }
}

class Cat extends Pet{
    function climb(){
        echo "<p>$this->name is climbing</p>";
    }
    function play()
    {
        parent::play();
        echo "<p>$this->name is climbing</p>";
    }
}
class Dog extends Pet{
    function fetch(){
        echo "<p>$this->name is fetching</p>";
    }
    function play(){
        parent::play();
        echo "<p>$this->name is fetching</p>";
    }
}

$dog = new Dog("Satchel");
$cat = new Cat("Bucky");

$dog->eat();
$cat->eat();

$dog->sleep();
$cat->sleep();

$dog->fetch();
$cat->climb();

$dog->play();
$cat->play();
$pet = new Pet('Rob');
$pet->play();

unset($dog,$cat,$pet);

class Test{
    public $public = 'public';
    protected $protected = 'protected';
    private $_private = 'private';

    function printVar($var){
        echo "<p>In Test,\$$var: '{$this->$var}'</p>";
    }
}

class LittleTest extends Test{
    function printVar($var){
        echo "<p>In LittleTest,\$$var: '{$this->$var}'</p>";
    }
}

$parent = new Test();
$child = new LittleTest();

echo '<h1>Public</h1>';
echo '<h2>Initially...</h2>';
$parent->printVar('public');
$child->printVar('public');

echo '<h2>Modifying $parent->public...</h2>';

$parent->public = 'modified';
$parent->printVar('public');
$child->printVar('public');

echo '<h1>Protected</h1>';
echo '<h2>Initially...</h2>';
$parent->printVar('protected');
$child->printVar('protected');

echo '<h2>Modifying $parent->protected...</h2>';

//$parent->protected = 'modified';
//$parent->printVar('protected');
//$child->printVar('protected');

class Pet1{
    protected $name;
    private static $_count = 0;
    function __construct($pet_name)
    {
        $this->name = $pet_name;
        self::$_count++;
    }
    function __destruct()
    {
        // TODO: Implement __destruct() method.
        self::$_count--;
    }
    public static function getCount(){
        return self::$_count;
    }
}
class Cat1 extends Pet1{

}
class Dog1 extends Pet1{

}
class Ferret extends Pet1{

}
class PygmyMarmoset extends Pet1{

}

$dog1 = new Dog1('Old Yeller');
echo "<p>".Pet1::getCount()."</p>";
$cat1 = new Cat1('Bucky');
echo "<p>".Pet1::getCount()."</p>";


