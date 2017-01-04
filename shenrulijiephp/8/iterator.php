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

class Department implements Iterator {
    private $_name;
    private $_employees;
    function __construct($name)
    {
        $this->_name = $name;
        $this->_employees = array();
        $this->_position = 0;
    }
    function addEmployee(Employee $e){
        $this->_employees[] = $e;
        echo "<p>{$e->getName()} has been added to the {$this->_name} department.</p>";
    }

    private $_position = 0;
    function current()
    {
        // TODO: Implement current() method.
        return $this->_employees[$this->_position];
    }
    function key(){
        return $this->_position;
    }
    function next()
    {
        // TODO: Implement next() method.
        $this->_position++;
    }
    function rewind()
    {
        // TODO: Implement rewind() method.
        $this->_position = 0;
    }
    function valid()
    {
        // TODO: Implement valid() method.
        return (isset($this->_employees[$this->_position]));
    }

}



$hr = new Department("Human Resources");

$e1 = new Employee('Jane Doe');
$e2 = new Employee('John Doe');

$hr->addEmployee($e1);
$hr->addEmployee($e2);

echo '<h2>Department Employees</h2>';
foreach($hr as $e){
    echo "<p>{$e->getName()}</p>";
}

unset($hr,$e1,$e2);