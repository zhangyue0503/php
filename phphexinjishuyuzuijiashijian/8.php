<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/25
 * Time: 下午2:44
 */

$mc = new emcached();
$mc->addServer('127.0.0.1',11211);
$mc->set('key','value',0,10);
$val = $mc->get('key');
$mc->delete('key');
$mc->flush();
$mc->close();