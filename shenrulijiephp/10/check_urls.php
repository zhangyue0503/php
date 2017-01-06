<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/6
 * Time: 上午10:42
 */

function check_url($url){
    $url_pieces = parse_url($url);
    $path = (isset($url_pieces['path'])?$url_pieces['path']:'/');
    $port = (isset($url_pieces['port'])?$url_pieces['port']:80);

    if($fp = fsockopen($url_pieces['host'],$port,$errno,$errstr,30)){
        $send = "HEAD $path HTTP/1.1\r\n";
        $send .= "HOST: {$url_pieces['host']}\r\n";
        $send .= "CONNECTION: Close\r\n\r\n";
        fwrite($fp,$send);

        $data = fgets($fp,128);
        fclose($fp);

        list($response,$code) = explode(' ',$data);
        if($code == 200){
            return array($code,'good');
        }else{
            return array($code,'bad');
        }

    }else{
        return array($errstr,'bad');
    }
}

$urls = array(
    'http://www.larryullman.com',
    'http://www.larryullman.com/wp-admin/',
    'http://www.yiiframework.com/tutorials/',
//    'http://vedio.google.com/videoplay?docid='
);
echo '<h2>Validating URLs</h2>';
set_time_limit(0);

foreach($urls as $url){
    list($code,$class) = check_url($url);
    echo "<p><a href='$url' target='hew'>$url</a> (<span class='$class'>$code</span>)</p>\n";
}


?>

