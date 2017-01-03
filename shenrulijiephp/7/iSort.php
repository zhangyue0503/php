<?php

/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/3
 * Time: 下午4:06
 */
interface iSort
{
    function sort(array $list);
}

class MultiAlphaSort implements iSort {
    private $_order;
    private $_index;
    function __construct($index,$order='ascending')
    {
        $this->_index = $index;
        $this->_order = $order;
    }

    function sort(array $list){
        if($this->_order == 'ascending'){
            uasort($list,array($this,'ascSort'));
        }else{
            uasort($list,array($this,'descSort'));
        }
        return $list;
    }

    function ascSort($x,$y){
        return strcasecmp($x[$this->_index],$y[$this->_index]);
    }
    function descSort($x,$y){
        return strcasecmp($y[$this->_index],$x[$this->_index]);
    }
}

class MultiNumberSort implements iSort {
    private $_order;
    private $_index;

    function sort(array $list){
        if($this->_order == 'ascending'){
            uasort($list,array($this,'ascSort'));
        }else{
            uasort($list,array($this,'descSort'));
        }
        return $list;
    }
    function ascSort($x,$y){
        return ($x[$this->_index]>$y[$this->_index]);
    }
    function descSort($x,$y){
        return ($x[$this->_index]<$y[$this->_index]);
    }
}