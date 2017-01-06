<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/6
 * Time: 上午11:17
 */

$url = "http://localhost/shenrulijiephp/10/service.php";
$curl = curl_init($url);
curl_setopt($curl,CURLOPT_FAILONERROR,1);
curl_setopt($curl,CURLOPT_FOLLOWLOCATION,1);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
curl_setopt($curl,CURLOPT_TIMEOUT,5);
curl_setopt($curl,CURLOPT_POST,1);

curl_setopt($curl,CURLOPT_POSTFIELDS,'name=foo&pass=bar&format=json');

$r = curl_exec($curl);

curl_close($curl);
print_r($r);
