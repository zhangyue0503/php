<?php
/**
 * 字符中间加*星号代码，支持中英文
 *
 * "cardid":"6222***********3655","certifId":"4304**********1011","mobile":"138****6306","name":"张*",
 *
 * @author zhangyue
 * @blog www.zyblog.net
 *
 */

/**
 * @param $str 字符串
 * @param $start 开始位置
 * @param int $end 结束位置
 * @param string $dot 符号
 * @param string $charset 编码
 * @return string 加星文字
 */
function PassStart($str, $start, $end = 0, $dot = "*", $charset = "UTF-8")
{
    $len = mb_strlen($str, $charset);
    if ($start == 0 || $start > $len) {
        $start = 1;
    }
    if ($end != 0 && $end > $len) {
        $end = $len - 2;
    }
    $endStart = $len - $end;
    $top = mb_substr($str, 0, $start, $charset);
    $bottom = "";
    if ($endStart > 0) {
        $bottom = mb_substr($str, $endStart, $end, $charset);
    }
    $len = $len - mb_strlen($top, $charset);
    $len = $len - mb_strlen($bottom, $charset);
    $newStr = $top;
    for ($i = 0; $i < $len; $i++) {
        $newStr .= $dot;
    }
    $newStr .= $bottom;
    return $newStr;
}