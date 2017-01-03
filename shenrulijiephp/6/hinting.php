<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/2
 * Time: 下午2:36
 */


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



$hr = new Department("Human Resources");

$e1 = new Employee('Jane Doe');
$e2 = new Employee('John Doe');

$hr->addEmployee($e1);
$hr->addEmployee($e2);

unset($hr,$e1,$e2);