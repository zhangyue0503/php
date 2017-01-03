<?php

/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/3
 * Time: 下午3:08
 */
abstract class ShapFactory
{
    static function Create($type,array $sizes){
        switch($type){
            case 'rectangle':
                return new Rectangle($sizes[0],$sizes[1]);
            break;
            case 'triangle':
                return new Triangle($sizes[0],$sizes[1],$sizes[2]);
            break;
        }
    }

}