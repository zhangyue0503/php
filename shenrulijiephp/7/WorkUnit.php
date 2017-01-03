<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/3
 * Time: 下午3:24
 */

abstract class WorkUnit{
    protected $tasks = array();
    protected $name = NULL;

    public function __construct($name)
    {
        $this->name = $name;
    }

    function getName(){
        return $this->name;
    }

    abstract function add(Employee $e);
    abstract function remove(Employee $e);
    abstract function assignTask($task);
    abstract function completeTask($task);
}

class Team extends WorkUnit
{
    private $_employees = array();

    function add(Employee $e)
    {
        $this->_employees[] = $e;
        echo "<p>{$e->getName()} has been added to team {$this->getName()}.</p>";
    }

    function remove(Employee $e)
    {
        $index = array_search($e, $this->_employees);
        unset($this->_employees[$index]);
        echo "<p>{$e->getName()} ahs been removed from team {$this->getName()}.</p>";
    }

    function assignTask($task)
    {
        // TODO: Implement assignTask() method.
        $this->tasks[] = $task;
        echo "<p>A new task has been assigned to team {$this->getName()}.It should be easy to do with {$this->getCount()} team member(s).</p>";
    }

    function getCount()
    {
        return count($this->_employees);
    }

    function completeTask($task)
    {
        // TODO: Implement completeTask() method.
        $index = array_search($e, $this->_employees);
        unset($this->_employees[$index]);
        echo "<p>The '$task' task has been completed by team {$this->getName()}.</p>";
    }
}

class Employee extends WorkUnit {
    function add(Employee $e){
        return false;
    }

    function remove(Employee $e)
    {
        // TODO: Implement remove() method.
        return false;
    }

    function assignTask($task)
    {
        // TODO: Implement assignTask() method.
        $this->tasks[] = $task;
        echo "<p>A new task has been assigned to team {$this->getName()}.It should be easy to do with {$this->getName()} alone.</p>";
    }
    function completeTask($task)
    {
        // TODO: Implement completeTask() method.
        $index = array_search($task,$this->tasks);
        unset($this->tasks[$index]);
        echo "<p>The '$task' task has been completed by comployee {$this->getName()}.</p>";
    }
}