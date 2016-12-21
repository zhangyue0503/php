<?php

/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/12/21
 * Time: 上午11:46
 */
require_once 'walk.php';
require 'vendor/autoload.php';
class WalkTest extends PHPUnit_Framework_TestCase
{
    protected $object;
    public function setUp(){
        $this->object = new Walk();
    }
    protected function tearDown(){

    }

    public function testTimeToWalkTheDog_default(){
        print "testTimeToWalkTheDog_default";
        $this->assertTrue(!$this->object->timeToWalkTheDog());
    }
    public function testTimeToWalkTheDog_default_shouldReturnTrue(){
        print "testTimeToWalkTheDog_default";
        $this->assertTrue($this->object->timeToWalkTheDog());
    }
    public function testTimeToWalkTheDog_haveNoDog_shouldReturnFalse(){
        print "testTimeToWalkTheDog_default";
        $this->object->ownADog = false;
        $this->assertTrue(!$this->object->timeToWalkTheDog());
    }
}

$wt = new WalkTest();
$wt->setUp();
//$wt->testTimeToWalkTheDog_default();
$wt->testTimeToWalkTheDog_default_shouldReturnTrue();
$wt->testTimeToWalkTheDog_haveNoDog_shouldReturnFalse();