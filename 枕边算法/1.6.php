<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2018/7/16
 * Time: 下午6:34
 */


//回文算法
$str = '12321';
$str = preg_split('/(?<!^)(?!$)/u', $str);
if (count($str) < 2) {
	var_dump(false);
} else {
	$isHui = true;
	for ($i = 0; $i < count($str); $i++) {
		if ($str[$i] != $str[count($str) - $i - 1]) {
			$isHui = false;
		}
	}
	var_dump($isHui);
}

////回文算法
//$str = '';
//$str = preg_split('/(?<!^)(?!$)/u', $str);
//if(mb_strlen($str) < 2){
//	var_dump(false);
//}else{
//	$isHui = true;
//	print_r($str);
//	for ($i=0;$i<count($str);$i++){
//		for($j=count($str)-$i-1;$j>$i;$j--){
//			if($str[$i] != $str[$j]){
//				$isHui = false;
//			}
//			break;
//		}
//		if($i==$j){
//			break;
//		}
//	}
//	var_dump($isHui);
//}
