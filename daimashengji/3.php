<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/9
 * Time: 下午9:21
 */

//$$变量覆盖
$a = 1;
foreach(array('_COOKIE','_POST','_GET') as $_request){
    foreach($$_request as $_key=>$_value){
        echo $_ken.'<br/>';
        $$_key = addslashes($_value);
    }
}
echo $a;