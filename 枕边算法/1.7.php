<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2018/7/17
 */



$num = 197;
//13=44
//12=33
//14=55
//19=110
//125=646
//87=4884
//196=内存溢出
//197=881188

//找回文数字算法
function huiwenshuzi($num){
	if($num>0){
		//反过来
		$reNum = (int)implode('',array_reverse(str_split($num)));
		$newNum = $num+$reNum;

		if(isHuiWen($newNum)){ //出口
			return $num+$reNum;
		}else{
			return huiwenshuzi($newNum); //递归
		}
	}else{
		return '错误';
	}
}

//判断是否回文
function isHuiWen($str){
	$str = preg_split('/(?<!^)(?!$)/u', $str);
	if (count($str) < 2) {
		return false;
	} else {
		$isHui = true;
		for ($i = 0; $i < count($str); $i++) {
			if ($str[$i] != $str[count($str) - $i - 1]) {
				$isHui = false;
				break;
			}
		}
		return $isHui;
	}
}

echo huiwenshuzi($num);


