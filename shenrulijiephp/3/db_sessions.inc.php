<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/12/30
 * Time: 上午9:46
 */

//session 入库
$sdbc = NULL;

function open_session(){
    global $sdbc;

    $sdbc = mysqli_connect('localhost','root','root','books');
    return true;
}

function close_session(){
    global $sdbc;
    return mysqli_close($sdbc);
}

function read_session($sid){
    global $sdbc;

    $q = sprintf('SELECT data FROM sessions WHERE id="%s"',mysqli_real_escape_string($sdbc,$sid));
    $r = mysqli_query($sdbc,$q);

    if(mysqli_num_rows($r)==1){
        list($data) = mysqli_fetch_array($r,MYSQLI_NUM);
        return $data;
    }else{
        return '';
    }
}

function write_session($sid,$data){
    global $sdbc;

    $q = sprintf('REPLACE INTO sessions(id,data) VALUES("%s","%s")',mysqli_real_escape_string($sdbc,$sid),mysqli_real_escape_string($sdbc,$data));
    $r = mysqli_query($sdbc,$q);
    return true;
}

function destroy_session($sid){
    global $sdbc;

    $q = sprintf('DELETE FROM sessions WHERE id="%s"',mysqli_real_escape_string($sdbc,$sid));
    $r = mysqli_query($sdbc,$q);
    $_SESSION = array();
    return true;
}

function clean_session($expire){
    global $sdbc;

    $q = sprintf('DELETE FROM sessions WHERE DATE_ADD(last_accessed,INTERVAL %d SECOND)<NOW()',(int)$expire);
    $r = mysqli_query($sdbc,$q);
    return true;
}

session_set_save_handler('open_session','close_session','read_session','write_session','destroy_session','clean_session');
session_start();