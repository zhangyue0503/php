<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/3
 * Time: 下午4:24
 */
require 'iSort.php';

class StudentsList{
    private $_students = array();

    function __construct($list)
    {
        $this->_students = $list;
    }

    function sort(iSort $type){
        $this->_students = $type->sort($this->_students);
    }

    function display(){
        echo '<ol>';
        foreach($this->_students as $student){
            echo "<li>{$student['name']}{$student['grade']}</li>";
        }
        echo "</ol>";
    }

}

$students = array(
    256=>array('name'=>'Jon','grade'=>98.5),
    2=>array('name'=>'Vance','grade'=>85.1),
    9=>array('name'=>'Stephen','grade'=>94.0),
    364=>array('name'=>'Steve','grade'=>85.1),
    68=>array('name'=>'Rob','grade'=>74.6),
);

$list = new StudentsList($students);

echo '<h2>Original Array</h2>';
$list->display();

$list->sort(new MultiAlphaSort('name'));
echo '<h2>Sorted by Name</h2>';
$list->display();

$list->sort(new MultiNumberSort('grade','descending'));
echo '<h2>Sorted by Grade</h2>';
$list->display();

unset($list);