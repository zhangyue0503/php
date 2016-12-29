<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/12/29
 * Time: 上午11:08
 */

require 'config.inc.php';

if(isset($_GET['p'])){
    $p = $_GET['p'];
}elseif(isset($_POST['p'])){
    $p = $_POST['p'];
}else{
    $p = NULL;
}
echo $p;
switch($p){
    case 'about':
        $page = 'about.inc.php';
        $page_title = 'About This Site';
        break;
    case 'contact':
        $page = 'contact.inc.php';
        $page_title = 'Contact Us';
        break;
    case 'search':
        $page = 'search.inc.php';
        $page_title = 'Search Results';
        break;
    default:
        $page = 'main.inc.php';
        $page_title = 'Site Home Page';
        break;
}

if(!file_exists($page)){
    $page = 'main.inc.php';
    $page_title = 'Site Home Page';
}

include "header.html";
include $page;
include "footer.html";
