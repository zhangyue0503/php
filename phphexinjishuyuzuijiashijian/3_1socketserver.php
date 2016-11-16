<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/15
 * Time: 上午10:44
 */

$host = '127.0.0.1';
$port = 12345;
set_time_limit(0);
$socket = socket_create(AF_INET,SOCK_STREAM,0) or die("Could not create socket\n");
$result = socket_bind($socket,$host,$port) or die("Could not bind socket\n");
$result = socket_listen($socket,3) or die("Could not set up socket listener\n");
$spawn = socket_accept($socket) or die("Could not read input\n");
$input = socket_read($spawn,1024) or die("Could not read input\n");
$input = trim($input);
$output = strrev($input."aabbcc")."\n";
socket_write($spawn,$output,strlen($output)) or die("Could not write output\n");
socket_close($spawn);
socket_clear_error($socket);
