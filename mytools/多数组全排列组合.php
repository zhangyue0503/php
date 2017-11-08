<?php
/**
 * 模拟三个数组：
 * $list ['a'] = array (1,2,3);
 * $list ['b'] = array (1,2);
 * $list ['c'] = array (1,2,3,4);
 * 要求组合成这样：111，112，113，114，121，122，123.....
 *
 * @author zhangyue
 * @blog www.zyblog.net
 *
 */

class sufa{
    public function main(){
        $list ['a'] = array (1,2,3);
        $list ['b'] = array (1,2);
        $list ['c'] = array (1,2,3,4);
// 		$list ['f'] = array (1,2,3,4,5);
// 		$list ['d'] = array ("+","-","*","/","%");

        foreach($list['a'] as $v){
            $this->getsulie($list,$v,1);
        }

    }
    function getsulie($list,$content,$deep){
        $i=0;
        if($deep>count($list)){
            return;
        }
        foreach($list as $k=>$v){
            if($i==$deep){
                foreach($list[$k] as $vv){
                    $vv = $content.$vv;
                    if($deep==count($list)-1){
                        echo $vv."<br/>";
                    }else {
                        $this->getsulie($list,$vv,$deep+1);
                    }
                }
                break;
            }
            $i++;
        }
        return;
    }
}
$s = new sufa();
$s->main();