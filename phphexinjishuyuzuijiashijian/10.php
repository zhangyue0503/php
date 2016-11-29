<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/29
 * Time: 上午11:50
 */
//测试gearman
$client = new GearmanClient();
$client->addServer('127.0.0.1',4730);
$info = array(
    "to"=>"to@gamil.com",
    "subject"=>"Test send email",
    "message"=>"Hello!This is a simple email message",
    "handers"=>"From:from@yahoo.com.cn"
);
echo $client->do("sendmail",serialize($info));

