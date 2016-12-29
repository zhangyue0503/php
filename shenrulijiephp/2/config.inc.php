<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/12/29
 * Time: 上午10:07
 */
$contact_email = 'address@example.com';

$host = substr($_SERVER['HTTP_HOST'],0,5);
if(in_array($host,array('local','127.0','192.1'))){
    $local = TRUE;
}else{
    $local = FALSE;
}

if($local){
    $debug = TRUE;
    define('BASE_URI','/Users/zhangyue/MyProject/phpproject/php/shenrulijiephp/2/');
    define('BASE_URL','http://localhost/shenrulijiephp/2/');
    define('DB','/Users/zhangyue/MyProject/phpproject/php/shenrulijiephp/2/mysql.inc.php');
}else{
    define('BASE_URI','/Users/zhangyue/MyProject/phpproject/php/shenrulijiephp/2/');
    define('BASE_URL','http://localhost/shenrulijiephp/2/');
    define('DB','/Users/zhangyue/MyProject/phpproject/php/shenrulijiephp/2/mysql.inc.php');
}

if($p == 'thismodule') $debug = TRUE;
//require './config.inc.php';

$debug = TRUE;

if(!isset($debug)){
    $debug = FALSE;
}

//function my_error_handler($e_number,$e_message,$e_file,$e_line,$e_vars){
//    global $debug,$contact_email;
//    $message = "An error occurred in script '$e_file' on line $e_line: $e_message";
//
//    $message .= print_r($e_vars,1);
//
//    if($debug){
//        echo '<div class="error">'.$message.'</div>';
//        debug_print_backtrace();
//    }else{
//        error_log($message,1,$contact_email);
//
//        if(($e_number != E_NOTICE)&&($e_number<2048)){
//            echo '<div class="error">A system error occurred.We apologize for the inconvenience.</div>';
//        }
//    }
//}
//set_error_handler('my_error_handler');

