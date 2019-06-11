<?php
/**
 * Created by PhpStorm.
 * User: 11041
 * Date: 2019/6/11
 * Time: 16:31
 */

/**
 * 支持到9999999999999999999.9999
 * 玖佰玖拾玖京玖仟玖佰玖拾玖兆玖仟玖佰玖拾玖億玖仟玖佰玖拾玖萬玖仟玖佰玖拾玖圆玖角玖分玖厘玖
 * 毫
 * @param $num
 * @return mixed|string
 */
function to_upcase_chinese($num, $charset = 'utf-8')
{
    $digitUnits    = [1 => '', 2 => '拾', 3 => '佰', 4 => '仟'];
    $digitBigUnits = [0 => '', 1 => '萬', 2 => '億', 3 => '兆', 4 => '京'];
    $capitalDigit  = ['零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖'];
    $decimalUnits  = [0 => '角', 1 => '分', 2 => '厘', 3 => '毫'];
    $digit         = null;
    $decimal       = null;
    if (false !== strpos($num, '.')) {
        $spreator = explode('.', $num);
        $digit    = reset($spreator);
        $decimal  = end($spreator);
    } else {
        $digit = (string)$num;
    }
    // 数字大于一位的不能以0开头
    if (strlen($digit) > 1 && substr($digit, 0, 1) == 0) {
        return '';
    }

    // 整数部分，以四个字符为阶段拼接字符串
    $combine = '';
    $residue = floor((strlen($digit) / 4));
    $mol     = strlen($digit) % 4;
    for ($b = $residue + 1; $b >= 1;) {
        $length = $b == ($residue + 1) ? $mol : 4;
        $b--; // 大数单位
        $st = substr($digit, ($b * (-4)) - 4, $length);
        if ($st !== '') {
            for ($a = 0; $a < strlen($st); $a++) {
                if (intval($st[$a]) === 0) {
                    $combine .= '零';
                } else {
                    $combine .= $capitalDigit[intval($st[$a])] . $digitUnits[strlen($st) - $a]; // 拼接普通单位
                }
            }
            $combine .= $digitBigUnits[$b]; // 拼接大数单位
        }
    }

    // 小数部分
    $combineDecimal = '';
    if ($decimal !== null || intval($decimal) !== 0 || strlen($decimal) !== 0) {
        for ($i = 0; $i < (strlen($decimal) < 4 ? strlen($decimal) : 4); $i++) {
            if (intval($decimal[$i]) === 0) {
                $combineDecimal .= '';
            } else {
                $combineDecimal .= $capitalDigit[intval($decimal[$i])] . $decimalUnits[$i];
            }
        }
    } else {
        $combineDecimal .= '整';
    }

    // 拼接整数部分与小数部分
    $combine = $combine . '圆' . $combineDecimal;

    // 过滤零部分
    $j       = 0;
    $strLen    = mb_strlen($combine, $charset);
    $combine = str_replace(['零零零萬', '零零零億', '零零零兆', '零圆'], '', $combine);
    while ($j < $strLen) {
        $m = mb_substr($combine, $j, 2);
        if ($m == '零萬' || $m == '零億' || $m == '零兆' || $m == '零零') {
            $left    = mb_substr($combine, 0, $j, $charset);
            $right   = mb_substr($combine, $j + 1, NULL, $charset);
            $combine = $left . $right;
            $j       = $j - 1;
            $strLen    = $strLen - 1;
        }
        $j++;
    }
    return $combine;
}

echo to_upcase_chinese('199027000991.9009');