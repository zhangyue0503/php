<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/29
 * Time: 上午11:57
 */
$worker = new GearmanWorker();
$worker->addServer("127.0.0.1",4730);
$worker->addFunction("sendmail","doSendMail");

while($worker->work());

function doSendMail($job){
    $email = unserialize($job->workload());
    print_r($email);
    return mail($email['to'],$email['subject'],$email['message'],$email['headers']);
}