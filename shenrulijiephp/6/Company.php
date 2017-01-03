<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/2
 * Time: 下午2:47
 */
namespace MyNamespace\Company;
class Employee{
    private $_name;
    function __construct($name)
    {
        $this->_name = $name;
    }
    function getName(){
        return $this->_name;
    }
}

class Department{
    private $_name;
    private $_employees;
    function __construct($name)
    {
        $this->_name = $name;
        $this->_employees = array();
    }
    function addEmployee(Employee $e){
        $this->_employees[] = $e;
        echo "<p>{$e->getName()} has been added to the {$this->_name} department.</p>";
    }
}