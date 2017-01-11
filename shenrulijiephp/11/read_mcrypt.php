<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/9
 * Time: 上午11:25
 */
session_start();
if(isset($_SESSION['thing1'],$_SESSION['thing2'])){
    $key = md5('77 public drop-shadow Java');
    $m = mcrypt_module_open('rijndael-256','','cbc','');
    $iv = base64_decode($_SESSION['thing2']);
    mcrypt_generic_init($m,$key,$iv);

    $data = mdecrypt_generic($m,base64_decode($_SESSION['thing1']));
    mcrypt_generic_deinit($m);

    mcrypt_module_close($m);

    echo '<p>The session has been read.Its value is "'.trim($data).'".</p>';
}else{
    echo '<p>There\'s nothing to see here.</p>';
}