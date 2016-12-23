<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/12/22
 * Time: 上午9:19
 */

$xml = <<<THE_XML
<animal>
    <type>dog</type>
    <name>snoopy</name>
</animal>
THE_XML;
$xml_object = simplexml_load_string($xml);
foreach($xml_object as $element=>$value){
    print $element.":".$value."\n";
}

$xml = simplexml_load_file("http://feeds.wired.com/wired/index?format=xml");
foreach($xml->channel->item as $item){
    print $item->title;
    print "\n";
}

$animals = new SimpleXMLElement('</animals>');
$animals->{0} = 'Hello World';

$animals->asXML('animals.xml');
var_dump(simplexml_load_file('animals.xml'));

