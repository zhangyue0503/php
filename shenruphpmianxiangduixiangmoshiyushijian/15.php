<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/2/20
 * Time: 下午10:53
 */
require_once "Config.php";
class MyConfig{
    private $rootObj;
    function __construct($filename=null,$type='xml')
    {
        $this->type = $type;
        $conf = new Config();
        if(!is_null($filename)){
            $this->rootObj = $conf->parseConfig($filename,$type);
        }else{
            $this->rootObj = new Config_Container('section','config');
            $conf->setroot($this->rootObj);
        }
    }
    function set($secname,$key,$val){
        $section = $this->getOrCreate($this->rootObj,$secname);
        $directive = $this->getOrCreate($section,$key,$val);
        $directive->setContent($val);
    }
    private function getOrCreate(Config_Container $cont,$name,$value=null){
        $itemtype = is_null($value)?'section':'directive';
        if($child=$cont->searchPath(array($name))){
            return $child;
        }
        return $cont->createItem($itemtype,$name,null);
    }
    function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->rootObj->toString($this->type);
    }
}

$myconf = new MyConfig();
$myconf->set('directories','prefs','/tmp/myapp/prefs');
$myconf->set("directories","scratch","/tmp/");
$myconf->set("general","version","1.0");
echo $myconf;