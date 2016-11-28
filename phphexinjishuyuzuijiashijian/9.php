<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/28
 * Time: 上午9:08
 */
//redis
$redis = new Redis();
$redis->connect('127.0.0.1',6379);
$redis->set("key","value");
$value = $redis->get("key");
echo $value;
$redis->close();

//redis实现session
class SessionManager{
    private $redis;
    private $sessionSavePath;
    private $sessionName;
    private $sessionExpireTime = 30;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1',6379);
        $retval = session_set_save_handler(
            array($this,"open"),
            array($this,"close"),
            array($this,"read"),
            array($this,"write"),
            array($this,"destroy"),
            array($this,"gc")
        );
//        session_start();
    }
    public function open($patn,$name){
        return true;
    }
    public function close(){
        return true;
    }
    public function read($id){
        $value = $this->redis->get($id);
        if($value){
            return $value;
        }else{
            return '';
        }
    }
    public function write($id,$data){
        if($this->redis->set($id,$data)){
            $this->redis->expire($id,$this->sessionExpireTime);
            return true;
        }
        return false;
    }
    public function destroy($id){
        if($this->redis->delete($id)){
            return true;
        }
        return false;
    }
    public function gc($maxlifetime){
        return true;
    }
    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        session_write_close();
    }
}

new SessionManager();
$_SESSION['username'] = "Liexusong";

echo $_SESSION['username'];
