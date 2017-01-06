<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/6
 * Time: 上午11:00
 */

function show_ip_info($ip){
    $url = 'http://freegeoip.net/csv/'.$ip;
    $fp = fopen($url,'r');
    $read = fgetcsv($fp);
    fclose($fp);

    echo "<p>IP Address: $ip<br/>
    Country: $read[2]<br/>
    City,State: $read[5],$read[3]<br/>
    Latitude:$read[7]<br/>
    Longitude:$read[8]</p>";
}

echo '<h2>Our spies tell us the following information about you</h2>';
show_ip_info($_SERVER['REMOTE_ADDR']);

$url = 'www.entropy.ch';
echo '<h2>Our spies tell us the following information about the URL '.$url.'</h2>';
show_ip_info(gethostbyname($url));

show_ip_info(gethostbyname('www.baidu.com'));
