<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/14
 * Time: 上午10:22
 */

/*单一职责*/
//工厂模式
interface Db_Adapter{
    public function connect($config);
    public function query($query,$handle);
}
class Db_Adapter_Mysql implements Db_Adapter {

    public function connect($config)
    {
        // TODO: Implement connect() method.
        echo $config."MYSQLCONNECT";
    }

    public function query($query, $handle)
    {
        // TODO: Implement query() method.
        echo $query.$handle."MYSQLQUERY";
    }
}
class Db_Adapter_Sqlite implements Db_Adapter {

    public function connect($config)
    {
        // TODO: Implement connect() method.
        echo $config."SQLITECONNECT";
    }

    public function query($query, $handle)
    {
        // TODO: Implement query() method.
        echo $query.$handle."SQLITEQUERY";
    }
}
class sqlFactory{
    public static function factory($type){
        $classname = "Db_Adapter_".$type;
        return new $classname;
    }
}

$db = sqlFactory::factory('Mysql');
print_r($db->connect('aaa'));
$db = sqlFactory::factory('Sqlite');
print_r($db->connect('bbb'));

//命令模式
//厨师类
class cook{
    public function meal(){
        echo '番茄炒鸡蛋',PHP_EOL;
    }
    public function drink(){
        echo '紫菜蛋花汤',PHP_EOL;
    }
    public function ok(){
        echo '完毕',PHP_EOL;
    }
}
interface Command{
    public function excute();
}
class MealCommand implements Command{
    private $cook;
    public function __construct(cook $cook)
    {
        $this->cook = $cook;
    }
    public function excute()
    {
        // TODO: Implement excute() method.
        $this->cook->meal();
    }
}
class DrinkCommand implements Command {
    private $cook;
    public function __construct(cook $cook)
    {
        $this->cook = $cook;
    }
    public function excute()
    {
        // TODO: Implement excute() method.
        $this->cook->drink();
    }
}
class cookControl{
    private $mealcommand;
    private $drinkcommand;
    public function addCommand(Command $mealcommand,Command $drinkcommand){
        $this->mealcommand = $mealcommand;
        $this->drinkcommand = $drinkcommand;
    }
    public function callmeal(){
        $this->mealcommand->excute();
    }
    public function calldrink(){
        $this->drinkcommand->excute();
    }
}

$control = new cookControl();
$cook = new cook();
$mealcommand = new MealCommand($cook);
$drinkcommand = new DrinkCommand($cook);
$control->addCommand($mealcommand,$drinkcommand);
$control->callmeal();
$control->calldrink();

/*开放封闭原则*/
//播放器例子
interface process{
    public function process();
}
class playerencode implements process{

    public function process()
    {
        echo 'encode',PHP_EOL;
    }
}
class playeroutput implements process {
    public function process()
    {
        echo "output",PHP_EOL;
    }
}
class playProcess{
    private $message=null;
    public function __construct()
    {
    }
    public function callback(event $event){
        $this->message = $event->click();
        if($this->message instanceof process){
            $this->message->process();
        }
    }
}
class mp4{
    public function work(){
        $playProcess = new playProcess();
        $playProcess->callback(new event('encode'));
        $playProcess->callback(new event('output'));
    }
}
class event{
    private $m;
    public function __construct($me)
    {
        $this->m = $me;
    }
    public function click(){
        switch ($this->m){
            case 'encode':
                return new playerencode();
            break;
            case 'output':
                return new playeroutput();
            break;
        }
    }
}
$mp4 = new mp4();
$mp4->work();

/*依赖倒置*/
interface employee{public function working();}
class teacher implements employee {
    public function working()
    {
        // TODO: Implement working() method.
        echo 'teaching...';
    }
}
class coder implements employee {

    public function working()
    {
        // TODO: Implement working() method.
        echo 'coding...';
    }
}
class workA{
    public function work(){
        $teacher = new teacher();
        $teacher->working();
    }
}
class workB{
    private $e;
    public function set(employee $e){
        $this->e = $e;
    }
    public function work(){
        $this->e->working();
    }
}
$worka = new workA();
$worka->work();
$workb = new workB();
$workb->set(new teacher());
$workb->work();

/*面向对象留言本实例*/
class message{
    public $name;
    public $email;
    public $content;
    public function __set($name,$value){
        $this->$name = $value;
    }
    public function __get($name){
        if(!isset($this->$name)){
            $this->$name = NULL;
        }
    }
}
class gbookModel{
    private $bookPath;
    private $data;
    public function setBookPath($bookPath){
        $this->bookPath = $bookPath;
    }
    public function getBookPath(){
        return $this->bookPath;
    }
    public function open(){

    }
    public function close(){

    }
    public function read(){
        return file_get_contents($this->bookPath);
    }
    public function write($data){
        $this->data = self::safe($data)->name."&".self::safe($data)->email."\r\nsaid:\r\n"
            .self::safe($data)->content;
        file_put_contents($this->bookPath,$this->data,FILE_APPEND);
    }
    public static function safe($data){
        $reflect = new ReflectionObject($data);
        $props = $reflect->getProperties();
        $messagebox = new stdClass();
        foreach($props as $prop){
            $ivar = $prop->getName();
            $messagebox->$ivar = trim($prop->getValue($data));
        }
        return $messagebox;
    }
    public function delete(){
        file_put_contents($this->bookPath,"it's empty now");
    }

}
class leaveModel{
    public function write(gbookModel $gb,$data){
        $book=$gb->getBookPath();
        $gb->write($data);
    }
}
class authorControl{
    public function message(leaveModel $l,gbookModel $g,message $data){
        $l->write($g,$data);
    }
    public function view(gbookModel $g){
        return $g->read();9
    }
    public function delete(gbookModel $g){
        $g->delete();
        echo self::view($g);
    }
}
$message = new message();
$message->name='phper';
$message->email='aaa@aa.com';
$message->content='a crazy phper love php so much.';
$gb = new authorControl();
$pen = new leaveModel();
$book = new gbookModel();
$book->setBookPath('./a.txt');
$gb->message($pen,$book,$message);
echo $gb->view($book);
$gb->delete($book);




