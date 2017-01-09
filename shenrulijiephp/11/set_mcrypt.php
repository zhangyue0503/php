<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/9
 * Time: 上午11:18
 */
session_start();
$key = md5('77 public drop-shadow Java');
$data = 'rosebud';

$m = mcrypt_module_open('rijndael-256','','cbc','');

$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($m),MCRYPT_DEV_RANDOM);

mcrypt_generic_init($m,$key,$iv);

$data = mcrypt_generic($m,$data);

mcrypt_generic_deinit($m);

mcrypt_module_close($m);

$_SESSION['thing1'] = base64_encode($data);
$_SESSION['thing2'] = base64_encode($iv);

echo '<p>The data has been stored.Its value is '.base64_encode($data).'.</p>';