<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/3/1
 * Time: 下午9:46
 */

//$image = imagecreate(200,200);
//$white = imagecolorallocate($image,0xFF,0xFF,0xFF);
//$blcak = imagecolorallocate($image,0x00,0x00,0x00);
//imagefilledrectangle($image,50,50,150,150,$blcak);
//
//header("Content-Type:image/png");
//imagepng($image);

//$image = imagecreate(200,200);
//$white = imagecolorallocate($image,0xFF,0xFF,0xFF);
//$blcak = imagecolorallocate($image,0x00,0x00,0x00);
//imagefilledrectangle($image,50,50,150,150,$blcak);
//
//$rotated = imagerotate($image,45,1);
//
//header("Content-Type:image/png");
//imagepng($rotated);


$image = imagecreatetruecolor(150,150);
$white = imagecolorallocate($image,255,255,255);

imagealphablending($image,false);

imagefilledrectangle($image,0,0,150,150,$white);

$red = imagecolorallocatealpha($image,255,50,0,50);
imagefilledellipse($image,75,75,80,63,$red);

$gray = imagecolorallocatealpha($image,70,70,70,63);
imagefilledrectangle($image,60,60,120,120,$gray);

header("Content-Type:image/png");
imagepng($image);


