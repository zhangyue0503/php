<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/3
 * Time: 下午12:11
 */
require "Config.php";
$CONFIG = Config::getInstance();

$CONFIG->set('live','true');
echo '<p>$CONFIG["live"]:'.$CONFIG->get('live')."</p>";

$TEST = $CONFIG::getInstance();
echo '<p>$TEST["live"]:'.$TEST->get('live')."</p>";

unset($CONFIG,$TEST);