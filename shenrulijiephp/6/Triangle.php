<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/2
 * Time: 上午11:32
 */
class Triangle extends Shape
{
    private $_sides = array();
    private $_perimeter = NULL;

    function __construct($s0=0,$s1=0,$s2=0)
    {
        $this->_sides[] = $s0;
        $this->_sides[] = $s1;
        $this->_sides[] = $s2;

        $this->_perimeter = array_sum($this->_sides);
    }
    public function getArea()
    {
        // TODO: Implement getArea() method.
        return (SQRT(
            ($this->_perimeter/2)*
            (($this->_perimeter/2)-$this->_sides[0])*
            (($this->_perimeter/2)-$this->_sides[1])*
            (($this->_perimeter/2)-$this->_sides[2])
        ));
    }
    public function getPerimeter()
    {
        // TODO: Implement getPerimeter() method.
        return $this->_perimeter;
    }

}