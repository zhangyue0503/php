<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/1
 * Time: 上午10:02
 */
require "Rectangle.php";
class Square extends Rectangle{
    function __construct($side = 0)
    {
        $this->width = $side;
        $this->height = $side;
    }
}
$width = 21;
$height = 98;
echo "<h2>With a width of $width and a height of $height...</h2>";

$r = new Rectangle($width,$height);

echo "<p>The perimeter of the rectangle is ".$r->getPerimeter()."</p>";

$side = 60;

echo "<h2>With each side being $side...</h2>";

$s = new Square($side);

echo "<p>The area of the square is ".$s->getArea()."</p>";

echo "<p>The perimeter of the square is ".$s->getPerimeter()."</p>";

unset($r,$s);

