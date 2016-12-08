<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/12/8
 * Time: 上午9:32
 */
class animal{
    function __construct()
    {
        $this->type = "dog";
    }
    function get_type(){
        return $this->type;
    }
}
class animal2{
    public $species;
    public $name;
    function __construct($kind,$name)
    {
        $this->species = $kind;
        $this->name = $name;
    }
    function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->species.".".$this->name;
    }
}
