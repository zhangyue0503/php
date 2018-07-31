<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2018/7/31
 * Time: 下午6:32
 */

// 欧几里得算法，求最大公约数

function gcd($m,$n){
	if($n> $m){
		//当m小于n时，交换
		$t = $m;
		$m = $n;
		$n = $t;
	}

	while($n > 0)
	{
		$r = $m%$n;
		$m = $n;
		$n = $r;
	}
	return $m;
}

echo gcd(129,582);

