<?php

// include "./vendor/autoload.php";

// $params = ['192.168.56.102:6391','192.168.56.102:6392','192.168.56.102:6393','192.168.56.102:6397'];

// $options = ['cluster' => 'redis'];

// $client = new Predis\Client($params, $options);

// var_dump($client->getConnection());

// $client->set('aaa', 11);

// echo $client->get('aaa');

$obj_cluster = new RedisCluster(NULL, ['192.168.56.102:6392', '192.168.56.102:6393']);
var_dump($obj_cluster);

$obj_cluster->set('name1', '1111');
