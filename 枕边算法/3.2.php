<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2018/7/31
 * Time: 下午6:32
 */

// 欧几里得算法，求最大公约数
// 尾递归方式

function gcd($m,$n){
	if($n==0){
		return $m;
	}else{
		return gcd($n,$m%$n);
	}
}

echo gcd(582,129);

