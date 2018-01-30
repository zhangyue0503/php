<?php
require_once 'vendor/autoload.php';
require_once 'Example9_5.php';


use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStreamWrapper;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/30
 * Time: 15:20
 */
class ExampleTest9_5 extends TestCase
{
    public function setUp()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('exampleDir'));
    }

    public function testDirectoryIsCreated()
    {
        $example = new Example9_5('id');
        $this->assertFalse(vfsStreamWrapper::getRoot()->hasChild('id'));

        $example->setDirectory(vfsStream::url('exampleDir'));
        $this->assertTrue(vfsStreamWrapper::getRoot()->hasChild('id'));
    }
}