<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/2
 * Time: 下午1:41
 */
trait tDebug{
    public function dumpObject(){
        $class = get_class($this);
        $attributes = get_object_vars($this);

        $methods = get_class_methods($this);

        echo "<h2>Information about the $class object</h2>";

        echo '<h3>Attributes</h3><ul>';
        foreach($attributes as $k=>$v){
            echo "<li>$k:$v</li>";
        }
        echo "</ul>";

        echo '<h3>Methods</h3><ul>';
        foreach ($methods as $v){
            echo "<li>$v</li>";
        }
        echo "</ul>";
    }
}
