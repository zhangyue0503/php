<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/2/16
 * Time: 下午10:37
 */

//组合模式
abstract class Unit{
    function addUnit(Unit $unit){
        throw new UnitException(get_class($this)." is a leaf");
    }
    function removeUnit(Unit $unit){
        throw new UnitException(get_class($this)." is a leaf");
    }
    abstract function bombardStrength();
}

class Army extends Unit{
    private $units = array();
    function addUnit(Unit $unit)
    {
        // TODO: Implement addUnit() method.
        if(in_array($unit,$this->units,true)){
            return;
        }
        $this->units[] = $unit;
    }
    function removeUnit(Unit $unit)
    {
        // TODO: Implement removeUnit() method.
        $this->units = array_udiff($this->units,array($unit),function($a,$b){ return ($a===$b)?0:1;});
    }
    function bombardStrength()
    {
        // TODO: Implement bombardStrength() method.
        $ret = 0;
        foreach($this->units as $unit){
            $ret += $unit->bombardStrength();
        }
        return $ret;
    }
}
class UnitException extends Exception {}

class Archer extends Unit{
    function bombardStrength()
    {
        // TODO: Implement bombardStrength() method.
        return 4;
    }
}

$main_army = new Army();
$main_army->addUnit(new Archer());

$sub_army = new Army();
$sub_army->addUnit(new Archer());
$sub_army->addUnit(new Archer());
$sub_army->addUnit(new Archer());

$main_army->addUnit($sub_army);

print "attacking with strength: {$main_army->bombardStrength()}\n";

//装饰模式
class RequestHelper{}

abstract class ProcessRequest{
    abstract function process(RequestHelper $req);
}
class MainProcess extends ProcessRequest {
    function process(RequestHelper $req)
    {
        // TODO: Implement process() method.
        print __CLASS__ . ": doing something useful with request\n";
    }
}
abstract class DecorateProcess extends ProcessRequest {
    protected $processrequest;
    function __construct(ProcessRequest $pr)
    {
        $this->processrequest = $pr;
    }
}
class LogRequest extends DecorateProcess {
    function process(RequestHelper $req)
    {
        // TODO: Implement process() method.
        print __CLASS__.": logging request\n";
        $this->processrequest->process($req);
    }
}
class AuthenticateRequest extends DecorateProcess {
    function process(RequestHelper $req)
    {
        // TODO: Implement process() method.
        print __CLASS__.": authenticating request\n";
        $this->processrequest->process($req);
    }
}
class StructureRequest extends DecorateProcess {
    function process(RequestHelper $req)
    {
        // TODO: Implement process() method.
        print __CLASS__.": structuring request data\n";
        $this->processrequest->process($req);
    }
}

$process = new AuthenticateRequest(new StructureRequest(new LogRequest(new MainProcess())));
$process->process(new RequestHelper());

//外观模式


