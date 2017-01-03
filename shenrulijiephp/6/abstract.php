<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/2
 * Time: 下午12:02
 */

require "Shape.php";
require "Triangle.php";

$side1 = 5;
$side2 = 10;
$side3 = 13;


echo "<h2>With sides of $side1,$side2 and $side3 …</h2>";

$t = new Triangle($side1,$side2,$side3);

echo "<p>The area of the triangle is ".$t->getArea()."</p>";

echo "<p>The perimeter of the triangle is ".$t->getPerimeter()."</p>";

unset($t);

