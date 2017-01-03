<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/3
 * Time: 下午3:11
 */
require 'ShapFactory.php';
require 'Shape.php';
require 'Triangle.php';
require 'tDebug.php';
require 'Rectangle.php';


if(isset($_GET['shape'],$_GET['dimensions'])){
    $obj = ShapFactory::Create($_GET['shape'],$_GET['dimensions']);
    echo "<h2>Creating a {$_GET['shape']}...</h2>";
    echo "<p>The area is ".$obj->getArea()."</p>";
    echo "<p>The perimeter is ".$obj->getPerimeter()."</p>";
}else{
    echo "<p class='error'>Please provide a shape type and size.</p>";
}
unset($obj);
