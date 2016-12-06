<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/12/6
 * Time: 上午9:38
 */

function dflt_handler(Exception $exc){
    print "Exception:\n";
    $code = $exc->getCode();
    if(!empty($code)){
        printf("Error code:%d\n",$code);
    }
    print $exc->getMessage()."\n";
    exit(-1);
}
set_exception_handler('dflt_handler');

class NonNumericException extends Exception{
    private $value;
    private $msg = "Error:the value %s is not numeric!\n";
    function __construct($value)
    {
        $this->value = $value;
    }
    public function info(){
        printf($this->msg,$this->value);
    }
}

try {
    $a = "my string";
    if (!is_numeric($argv[1])) {
        throw new NonNumericException($argv[1]);
    }
    if (!is_numeric($argv[2])) {
        throw new NonNumericException($argv[2]);
    }
    if ($argv[2] == 0) {
        throw new Exception("Illegal division by zero.\n");
    }
    printf("Result:%f\n",$argv[1]/$argv[2]);
}
catch (NonNumericException $exc){
    $exc->info();
//    exit(-1);
}
//catch (Exception $e) {
//    print "Exception:\n";
//    $code = $exc->getCode();
//    if(!empty($code)){
//        printf("Error code:%d\n",$code);
//    }
//    print $exc->getMessage()."\n";
//    exit(-1);
//}
print "Variable a=$a\n";

//引用
class test5{
    private $prop;
    function __construct($prop)
    {
        $this->prop = $prop;
    }
    function get_prop(){
        return $this->prop;
    }
    function set_prot($prop){
        $this->prop = $prop;
    }
}
function funct(test5 $x){
    $x->set_prot(5);
}
$x = new test5(10);
printf("Element X has property %s \n",$x->get_prop());
funct($x);
printf("Element X has property %s \n",$x->get_prop());

$arr = range(1,5);
foreach($arr as $a){
    $a*=2;
}
foreach($arr as $a){
    print "$a\n";
}

print "Normal assignment.\n";
$x = 1;
$y = 2;
$x = $y;
$y++;
print "x=$x\n";
print "Assignment by reference.\n";
$x =1 ;
$y = 2;
$x = &$y;
$y++;
print "x=$x\n";




