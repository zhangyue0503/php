<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/12/30
 * Time: 下午2:36
 */
require ('db_sessions.inc.php');
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>DB Session Test</title>
    </head>
    <body>
    <?php
        //效果图
        if(empty($_SESSION)){
            $_SESSION['blah'] = 'umlaut';
            $_SESSION['this'] = 3615684.45;
            $_SESSION['that'] = 'blue';
            echo '<p>Session data stored.</p>';
        }else{
            echo '<p>Session Data Exists:<pre>'.print_r($_SESSION,1).'</pre></p>';
        }
        if(isset($_GET['logout'])){
            session_destroy();
            echo '<p>Session destroyed.</p>';
        }else{
            echo '<a href="sessions.php?logout=true">Log Out</a>';
        }
        echo '<p>Session Data:<pre>'.print_r($_SESSION,1).'</pre></p>';
        echo '</body></html>';
        session_write_close();
    ?>