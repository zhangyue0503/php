<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/12/9
 * Time: 下午2:10
 */

var_dump(filter_var("www.email@.com",FILTER_VALIDATE_EMAIL));

$str = 'A Ford car was seen at Super Clean car wash.';
preg_match_all('/[A-Z][a-z]+/',$str,$matches);
var_export($matches);

preg_match_all('/[A-Z][a-z]+/',$str,$matches,PREG_PATTERN_ORDER,5);
var_export($matches);

preg_match_all('/[A-Z][a-z]+/',$str,$matches,PREG_SET_ORDER);
var_export($matches);

preg_match_all('/[A-Z][a-z]+/',$str,$matches,PREG_OFFSET_CAPTURE);
var_export($matches);

$imgName = "image.jpg";
$thumbName = "thumb.png";
$metaData = getimagesize($imgName);
$img = '';
$newWidth = 200;
$newHeight = $metaData[1]/($metaData[0]/$newWidth);

switch ($metaData['mime']){
    case 'image/jpeg':
        $img = imagecreatefromjpeg($imgName);
        break;
    case 'image/png':
        $img = imagecreatefrompng($imgName);
        break;
    case 'image/gif':
        $img = imagecreatefromgif($imgName);
        break;
    case 'image/wbmp':
        $img = imagecreatefromwbmp($imgName);
        break;
}
if($img){
    $imgThumb = imagecreatetruecolor($newWidth,$newHeight);
    imagecopyresampled($imgThumb,$img,0,0,0,0,$newWidth,$newHeight,$metaData[0],$metaData[1]);
    imagepng($imgThumb,$thumbName);
    imagedestroy($imgThumb);
}

