<?php

/**
 * Gif图转雪碧图
 * 需要安装：
 * 1、ImageMagicK工具（yum install -y ImageMagick ImageMagick-devel）
 * 2、php的imagick扩展（http://pecl.php.net/package/imagick）
 *
 * @param $img 原图
 * @param int $column 雪碧图列数
 * @return array ['width'=>宽，'height'=>高，'frame_count'=>帧数，'path' => 保存的图片地址]
 * @throws ImagickException
 */
function ConvertGifToSprite($imgPath, $column = 5){

    $reImg = getimagesize($imgPath);
    $imgAttrs = [
        'width' => $reImg[0],
        'height' => $reImg[1],
        'frame_count' => 1,
    ];

    if(extension_loaded('imagick')){
        $imagick = new \Imagick($imgPath);

        $format = $imagick->getImageFormat();
        if ($format == 'GIF') {
            $imagick = $imagick->coalesceImages();

            $imageCount = $imagick->count();
            if($imageCount <= 1){
                return $imgAttrs;
            }
            $imgAttrs = [
                'width' => $imagick->getImageWidth(),
                'height' => $imagick->getImageHeight(),
                'frame_count' => $imageCount,
            ];

            if($column > 0){
                if($imageCount< $column){
                    $column = $imageCount;
                }
            }else{
                $column = 5;
            }

            $row = ceil($imageCount / $column);

            $spImgWidth = $imgAttrs['width'] * $column;
            $spImgHeight = $imgAttrs['height'] * $row;

            // 创建图片
            $spImg = new \Imagick();
            $spImg->setSize($spImgWidth, $spImgHeight);
            $spImg->newImage($spImgWidth, $spImgHeight, new \ImagickPixel('#ffffff00'));
            $spImg->setImageFormat('png');

            $i = 0;
            $h = 0;
            do {
                if ($i == $column) {
                    $i = 0;
                    $h++;
                }
                $spImg->compositeImage($imagick, \Imagick::COMPOSITE_DEFAULT, $i * $imgAttrs['width'], $h * $imgAttrs['height']);
                $i++;
            } while ($imagick->nextImage());
            $spImg->writeImage($imgPath . '.sprite.png');
            $imgAttrs['path'] = $imgPath . '.sprite.png';
        }

        $imagick->clear();
        $imagick->destroy();

    }
    return $imgAttrs;
}

ConvertGifToSprite('1.gif');