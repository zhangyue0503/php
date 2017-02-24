<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/2/17
 * Time: 上午11:18
 */

//解释器模式
abstract class Expression{
    private static $keycount = 0;
    private $key;
    abstract function interpret(InterpreterContext $context);
    function getKey(){
        if(!isset($this->key)){
            self::$keycount++;
            $this->key=self::$keycount;
        }
        return $this->key;
    }
}
class LiteralExpression extends Expression {
    private $value;
    function __construct($value)
    {
        $this->value = $value;
    }
    function interpret(InterpreterContext $context){
        $context->replace($this,$this->value);
    }
}

class InterpreterContext{
    private $expressionstore = array();
    function replace(Expression $exp,$value){
        $this->expressionstore[$exp->getKey()] = $value;
    }
    function lookup(Expression $exp){
        return $this->expressionstore[$exp->getKey()];
    }
}
$context = new InterpreterContext();
$literal = new LiteralExpression('four');
$literal->interpret($context);
print $context->lookup($literal)."\n";

class VariableExpression extends Expression {
    private $name;
    private $val;

    function __construct($name,$val=null)
    {
        $this->name = $name;
        $this->val = $val;
    }
    function interpret(InterpreterContext $context)
    {
        // TODO: Implement interpret() method.
        if(!is_null($this->val)){
            $context->replace($this,$this->val);
            $this->val = null;
        }
    }
    function setValue($value){
        $this->val = $value;
    }
    function getKey()
    {
        return $this->name;
    }
}
$context1 = new InterpreterContext();
$myvar = new VariableExpression('input','four');
$myvar->interpret($context1);
print $context1->lookup($myvar)."\n";

$newvar = new VariableExpression('input');
$newvar->interpret($context1);
print $context1->lookup($newvar)."\n";

$myvar->setValue("five");
$myvar->interpret($context1);
print $context1->lookup($myvar)."\n";

print $context1->lookup($newvar)."\n";

abstract class OperatorExpression extends Expression {
    protected $l_op;
    protected $r_op;
    function __construct(Expression $l_op,Expression $r_op){
        $this->l_op = $l_op;
        $this->r_op = $r_op;
    }
    function interpret(InterpreterContext $context){
        $this->l_op->interpret($context);
        $this->r_op->interpret($context);
        $result_l = $context->lookup($this->l_op);
        $result_r = $context->lookup($this->r_op);
        $this->doInterpret($context,$result_l,$result_r);
    }
    protected abstract function doInterpret(InterpreterContext $context,$result_l,$result_r);
}
class EqualsExpression extends OperatorExpression {
    protected function doInterpret(InterpreterContext $context, $result_l, $result_r)
    {
        // TODO: Implement doInterpret() method.
        $context->replace($this,$result_l==$result_r);
    }
}
class BooleanOrExpression extends OperatorExpression {
    protected function doInterpret(InterpreterContext $context, $result_l, $result_r)
    {
        // TODO: Implement doInterpret() method.
        $context->replace($this,$result_l||$result_r);
    }
}
class BooleanAndExpression extends OperatorExpression {
    protected function doInterpret(InterpreterContext $context, $result_l, $result_r)
    {
        // TODO: Implement doInterpret() method.
        $context->replace($this,$result_l&&$result_r);
    }
}
$context = new InterpreterContext();
$input = new VariableExpression('input');
$statement = new BooleanOrExpression(
    new EqualsExpression($input,new LiteralExpression('four')),
    new EqualsExpression($input,new LiteralExpression('4'))
);
foreach(array("four","4","52") as $val){
    $input->setValue($val);
    print "$val:\n";
    $statement->interpret($context);
    if($context->lookup($statement)){
        print "top marks\n\n";
    }else{
        print "dunce hat on\n\n";
    }
}

//策略模式
abstract class Question{
    protected $prompt;
    protected $marker;

    function __construct($prompt,Marker $marker)
    {
        $this->marker = $marker;
        $this->prompt = $prompt;
    }
    function mark($response){
        return $this->marker->mark($response);
    }
}
class TextQuestion extends Question {

}
class AVQuestion extends Question{

}
abstract class Marker{
    protected $test;

    function __construct($test)
    {
        $this->test = $test;
    }
    abstract function mark($response);
}
class MarkLogicMarker extends Marker{
    private $engine;
    function __construct($test)
    {
        parent::__construct($test);

    }
    function mark($response)
    {
        // TODO: Implement mark() method.
        return true;
    }
}
class MatchMarker extends Marker {
    function mark($response)
    {
        // TODO: Implement mark() method.
        return ($this->test == $response);
    }
}
class RegexpMarker extends Marker {
    function mark($response){
        return (preg_match($this->test,$response));
    }
}


$markers = array(
    new RegexpMarker("/f.ve/"),
    new MatchMarker("five"),
    new MarkLogicMarker('$input equals "five"')
);
foreach($markers as $marker){
    print get_class($marker)."\n";
    $question = new TextQuestion("how many beans make five",$marker);
    foreach(array("five","four") as $response){
        print "\tresponse:$response:";
        if($question->mark($response)){
            print "well done\n";
        }else{
            print "never mind\n";
        }
    }
}

//观察者模式
interface Observable{
    function attach(Observer $observer);
    function detach(Observer $observer);
    function notify();
}

class Login implements Observable {
    private $observers;
    function __construct()
    {
        $this->observers = array();
    }

    function attach(Observer $observer)
    {
        // TODO: Implement attach() method.
        $this->observers[] = $observer;
    }
    function detach(Observer $observer)
    {
        // TODO: Implement detach() method.
        $newobservers = array();
        foreach($this->observers as $obs){
            if(($obs!=$observer)){
                $newobservers[] = $obs;
            }
            $this->observers = $newobservers;
        }
    }
    function notify()
    {
        // TODO: Implement notify() method.
        foreach($this->observers as $obs){
            $obs->update($this);
        }
    }

    const LOGIN_USER_UNKNOW = 1;
    const LOGIN_WRONG_PASS = 2;
    const LOGIN_ACCESS = 3;
    private $status = array();
    private function setStatus($status,$user,$ip){
        $this->status = array($status,$user,$ip);
    }
    function getStatus(){
        return $this->status;
    }

    function handleLogin($user,$pass,$ip){
        switch (rand(1,3)){
            case 1:
                $this->setStatus(self::LOGIN_ACCESS,$user,$ip);
                $ret = true;break;
            case 2:
                $this->setStatus(self::LOGIN_WRONG_PASS,$user,$ip);
                $ret = false;break;
            case 3:
                $this->setStatus(self::LOGIN_USER_UNKNOW,$user,$ip);
                $ret = false;break;
        }
        $this->notify();
        return $ret;
    }
}
interface Observer{
    function update(Observable $observable);
}


abstract class LoginObserver implements Observer {
    private $login;
    function __construct(Login $login)
    {
        $this->login = $login;
        $login->attach($this);
    }
    function update(Observable $observable)
    {
        // TODO: Implement update() method.
        if($observable === $this->login){
            $this->doUpdate($observable);
        }
    }
    abstract function doUpdate(Login $login);
}
class SecurityMonitor extends LoginObserver {
    function doUpdate(Login $login){
        $status = $login->getStatus();
        if($status[0]==Login::LOGIN_WRONG_PASS){
            print __CLASS__.":\tsending mail to sysadmin\n";
        }
    }
}

class GeneralLogger extends LoginObserver {
    function doUpdate(Login $login)
    {
        // TODO: Implement doUpdate() method.
        $status = $login->getStatus();
        print __CLASS__.":\tadd login data to log\n";
    }
}
class PartnershipTool extends LoginObserver {
    function doUpdate(Login $login)
    {
        // TODO: Implement doUpdate() method.
        $status = $login->getStatus();
        print __CLASS__.":\tset cookie if IP matches a list\n";
    }
}
$login = new Login();
new SecurityMonitor($login);
new GeneralLogger($login);
new PartnershipTool($login);



//$login = new Login();
//$login->attach(new SecurityMonitor());








