<?php
/**
 * Created by PhpStorm.
 * User: Sixstar-Peter
 * Date: 2018/10/27
 * Time: 21:24
 */


require  "vendor/autoload.php";

//从缓存当中读取，可以更新的，根据集群状态更新
$parameters = ['192.168.56.102:6392', '192.168.56.102:6393', '192.168.56.102:6394'];
$options    = ['cluster' => 'redis'];
$client = new Predis\Client($parameters, $options);

// $client->set('name1', 111);exit;

//var_dump($client->getConnection());
//1.数据槽节点跟服务器节点对应
$retryLimit=5;//限制次数
$retry=0; //尝试次数
RETPY: {
    try{
        //随机
        $parameters=$parameters[array_rand($parameters)];
        $connectionInfo=explode(':',$parameters);
        $slotInfo=$client->getClientFor($parameters)->executeRaw(['cluster','slots']);
        $slotNodes=[];
       // var_dump($slotInfo);
        foreach ($slotInfo as $value){
            //匹配端口，内网换成公网
            if($value[2][1]==$connectionInfo[1]){
                $slotNodes[$value[0].','.$value[1]]=$parameters;
                continue;
            }
            //判断当前的ip是内网ip还是外网的ip,可以判断的
            //var_dump(filter_var('172.16.0.3', FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE));
            $slotNodes[$value[0].','.$value[1]]=$value[2][0].':'.$value[2][1];
        }
        $delKey=['name4','name5','name6'];
        //key对应的slot，slot对应的node,发送指令
        $crc=new \Predis\Cluster\Hash\CRC16();

//        array(4) {  $slotNodes
//           ["0,5461"]=>"47.98.147.49:6394"
//           ["6827,12287"]=>"47.98.147.49:6392"

        //批量访问
         /*
          * ['47.98.147.49:6393']=>'name1,name4,name6'
          * ['47.98.147.49:6392']=>'name2'
          * */
         //$client->getClientFor(47.98.147.49:6393)->del(name1);
         //$client->getClientFor(47.98.147.49:6393)->del(name1);
        $slotKey=[];
        foreach ($delKey as $keyName ){
                //1.计算key的哈希值
                $code=$crc->hash($keyName) % 16384;
                //循环匹配范围组合映射关系,(多个key属于一个节点）
                array_walk($slotNodes,function($node,$slotRange) use($code,&$slotKey,$keyName){
                    $range=explode(',',$slotRange);
                    if($code>=$range[0] && $code<=$range[1] ){
                        $slotKey[$node]=$keyName;
                    }
                });
        }
        //（在做命令迁移）、连接失败
        try {
            //执行批量查询
            foreach ($slotKey as $k=>$v){
                $res=$client->getClientFor($k)->pipeline(function ($pipe) use($v){
                    //执行一条
                    $pipe->del($v);
                });
                var_dump($res);
            }
        }catch (Exception  $e){
            //捕获异常做处理

            //接收到是
//           if(strpos($e->getMessage(),'ask')!==false){
//               //根据错误信息,临时访问到哪里
                 //$client->getClientFor($k)->pipeline(function ($pipe)
//           }
//           //重定向错误，更新缓存信息，槽跟节点对应关系已经发生改变了
//            if(strpos($e->getMessage(),'moved')!==false){
//                     更新配置文件的信息
//            }
        }
    }catch(\Exception $e) {
        var_dump($e->getMessage());
        if($retry === $retryLimit){
            throw  new Exception('重试次数过多，连接失败');
        }
        ++$retry;
        sleep(1);
        goto  RETPY;
    }
}
