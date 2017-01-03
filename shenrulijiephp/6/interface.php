<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/2
 * Time: 下午12:12
 */
interface iCrud{
    public function create($data);
    public function read();
    public function update($data);
    public function delete();
}

class User implements iCrud{
    private $_userId = NULL;
    private $_username = NULL;

    function __construct($data)
    {
        $this->_userId = uniqid();
        $this->_username = $data['username'];
    }

    function create($data)
    {
        // TODO: Implement create() method.
        self::__construct($data);
    }

    function read(){
        return array('userId'=>$this->_userId,'username'=>$this->_username);
    }

    function update($data){
        $this->_username = $data['username'];
    }

    public function delete(){
        $this->_username = NULL;
        $this->_userId = NULL;
    }

}
$user = array('username'=>'trout');

echo "<h2>Creating a New User</h2>";
$me = new User($user);
$info = $me->read();
echo "<p>The user ID is {$info['userId']}.</p>";

$me->update(array('username'=>'troutster'));

$info = $me->read();
echo "<p>The user name is now {$info['username']}.</p>";

$me->delete();

unset($me);