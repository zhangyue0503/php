<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/2/21
 * Time: 下午11:22
 */

require_once("vendor/autoload.php");

class UserStore{
    private $users = array();
    function addUser($name,$mail,$pass){
        if(isset($this->users[$mail])){
            throw new Exception("User {$mail} already in the system");
        }
        if(strlen($pass)<5){
            throw new Exception("Password must have 5 or more letters");
        }
        $this->users[$mail] = array('pass'=>$pass,'mail'=>$mail,'name'=>$name);
        return true;
    }

    function notifyPasswordFailure($mail){
        if(isset($this->users[$mail])){
            $this->users[$mail]['failed'] = time();
        }
    }
    function getUser($mail){
        return ($this->users[$mail]);
    }
}

class UserStoreTest extends PHPUnit_Framework_TestCase {
    private $store;

    public function setUp(){
        $this->store = new UserStore();
    }
    public function tearDown(){

    }
    public function testGetUser(){
        $this->store->addUser("bob williams","a@b.com","123456");
        $user = $this->store->getUser("a@b.com");
        $this->assertEquals($user['mail'],"a@b.com");
        $this->assertEquals($user['name'],"bob williams");
        $this->assertEquals($user['pass'],"12345");
    }
    public function testAddUser_duplicate(){
        try {
            $ret = $this->store->addUser("bob williams", "a@b.com", "123456");
            $ret = $this->store->addUser("bob stevens", "a@b.com", "123456");
            self::fail("Exception should have been thrown");
        } catch (Exception $e) {
            $const = $this->logicalAnd(
                $this->logicalNot($this->contains("bob stevens")),
                $this->isType('array')
            );
            self::AssertThat($this->store->getUser("a@b.com"),$const);
        }

    }
}

