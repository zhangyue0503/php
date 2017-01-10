<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/10
 * Time: 下午12:03
 */

function handle_open_element($p,$element,$attributes){
    switch ($element){
        case 'BOOK':
            echo '<div>';
            break;
        case 'CHAPTER':
            echo "<p>Chapter {$attributes['NUMBER']}：";
            break;
        case 'COVER':
            $image = @getimagesize($attributes['FILENAME']);
            echo "<img src=\"{$attributes['FILENAME']}\" $image[3] border=\"0\"><br>";
            break;
        case 'TITLE':
            echo '<h2>';
            break;
        case 'YEAR':
        case 'AUTHOR':
        case 'PAGES':
            echo '<span class="label">'.$element.'</span>';
            break;
    }
}
function handle_close_element($p,$element){
    switch ($element){
        case 'BOOK':
            echo '</div>';
            break;
        case 'CHAPTER':
            echo "</p>";
            break;
        case 'TITLE':
            echo '</h2>';
            break;
        case 'YEAR':
        case 'AUTHOR':
        case 'PAGES':
            echo '<br>';
            break;
    }
}
function handle_character_data($p,$cdata){
    echo $cdata;
}

$p = xml_parser_create();

xml_set_element_handler($p,'handle_open_element','handle_close_element');
xml_set_character_data_handler($p,'handle_character_data');

$file = 'books4.xml';
$fp = @fopen($file,'r') or die("<p>Could not open a file called '$file'.</p>");
while($data = fread($fp,4096)){
    xml_parse($p,$data,feof($fp));
}
xml_parser_free($p);