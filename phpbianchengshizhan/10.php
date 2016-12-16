<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/12/16
 * Time: 上午10:47
 */
//SimplePie，没按书上的，用composer了
//composer require simplepie/simplepie
error_reporting(EALL ^ E_NOTICE ^ E_DEPRECATED);
//require_once "simplepie-1.4.3/library/SimplePie.php";
require_once "vendor/autoload.php";
$feed_url = "http://feeds.wired.com/wired/index?format=xml";

$simplePie = new SimplePie();
$simplePie->set_feed_url($feed_url);
$simplePie->init();

echo count($simplePie->get_items());

foreach($simplePie->get_items() as $item){
    echo "<p><strong><a href='".$item->get_link()."'>";
    echo $item->get_title()."</a></strong><br/>";
    echo '<em>'.$item->get_date().'</em><br/>';
    echo $item->get_content().'</p>';
}

//TCPDF
//$pdf = new TCPDF();
//$pdf->AddPage();
//$txt = "Pro PHP Programming - Chapter 10:TCPDF Minimal Example";
//$pdf->Write(20,$txt);
//$pdf->Output();

$url = "http://www.nhl.com";
$data = fetchRawData($url);
function fetchRawData($url){
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_FAILONERROR,true);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($ch,CURLOPT_TIMEOUT,10);

    $data = curl_exec($ch);
    if(!$data){
        echo "<br/>cURL error:<br/>\n";
        echo "#".curl_errno($ch)."<br/>\n";
        echo curl_close($ch)."<br/>\n";
        echo "Detailed information:";
        var_dump(curl_getinfo($ch));
        die();
    }
    curl_close($ch);
    return $data;
}

function parseSpecificData($data){
    $parsedData = array();
    $dom = new DOMDocument();
    $dom->loadHTML($data);
    $xpath = new DOMXPath($dom);
    $links = $xpath->query("/html/body//a");
    if($links){
        foreach($links as $element){
            $nodes = $element->childNodes;
            $link = $element->attributes->getNamedItem('href')->value;
            foreach($nodes as $node){
                if($node instanceof DOMText){
                    $parsedData[] = array("title"=>$node->nodeValue,"href"=>$link);
                }
            }
        }
    }
    return $parsedData;
}

function dispalyData(Array $data){
    foreach($data as $link){
        $cleaned_title = htmlentities($link['title'],ENT_QUOTES,"UTF-8");
        $cleaned_href = htmlentities($link['href'],ENT_QUOTES,"UTF-8");
        echo "<p><strong>".$cleaned_title."</strong>\n";
        echo $cleaned_href."</p>\n";
    }
}

$parsedData = parseSpecificData($data);
print_r(dispalyData($parsedData));






