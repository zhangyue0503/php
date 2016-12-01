<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/12/1
 * Time: 上午9:09
 */

class HashTable{
    private $buckets;
    private $size = 10;
    public function __construct()
    {
        $this->buckets = new SplFixedArray($this->size);
    }
    private function hashfunc($key){
        $strlen = strlen($key);
        $hashval = 0;
        for($i=0;$i<$strlen;$i++){
            $hashval += ord($key[$i]);
        }
        return $hashval % $this->size;
    }
    public function insert($key,$val){
        $index = $this->hashfunc($key);
        //新创建一个节点
        if(isset($this->buckets[$index])){
            $newNode = new HashNode($key,$val,$this->buckets[$index]);
        }else{
            $newNode = new HashNode($key,$val,NULL);
        }
        $this->buckets[$index] = $newNode;
    }
    public function find($key){
        $index = $this->hashfunc($key);
        $current = $this->buckets[$index];
        while(isset($current)){
            if($current->key == $key){
                return $current->value;
            }
            $current = $current->nextNode;
        }
//        return $this->buckets[$index];
        return NULL;
    }
}

class HashNode{
    public $key;
    public $value;
    public $nextNode;
    public function __construct($key,$value,$nextNode = NULL)
    {
        $this->key = $key;
        $this->value = $value;
        $this->nextNode = $nextNode;
    }
}


$ht = new HashTable();
$ht->insert("key1",'value1');
$ht->insert("key2",'value2');
echo $ht->find('key1');
echo $ht->find('key2');

$ht->insert("key12","value12");
echo $ht->find("key12");

//数据库
define("DB_INSERT",1);
define("DB_REPLACE",2);
define("DB_STORE",3);

define("DB_BUCKET_SIZE",262144);
define("DB_KEY_SIZE",128);
define("DB_INDEX_SIZE",DB_KEY_SIZE+12);

define("DB_KEY_EXISTS",1);
define("DB_FAILURE",-1);
define("DB_SUCCESS",0);

class DB{
    private $idx_fp;
    private $dat_fp;
    private $closed;
    public function open($pathname){
        $idx_path = $pathname.".idx";
        $dat_path = $pathname.'.dat';

        if(!file_exists($idx_path)){
            $init = true;
            $mode = "w+b";
        }else{
            $init = false;
            $mode = "r+b";
        }
        $this->idx_fp = fopen($idx_path,$mode);
        if(!$this->idx_fp){
            return DB_FAILURE;
        }
        if($init){
            $elem = pack('L',0x00000000);
            for($i=0;$i<DB_BUCKET_SIZE;$i++){
                fwrite($this->idx_fp,$elem,4);
            }
        }
        $this->dat_fp = fopen($dat_path,$mode);
        if(!$this->dat_fp){
            return DB_FAILURE;
        }
        return DB_SUCCESS;

    }

    private function _hash($string){
        $string = substr(md5($string),0,8);
        $hash = 0;
        for($i=0;$i<8;$i++){
            $hash += 33*$hash+ord($string[$i]);
        }
        return $hash & 0x7FFFFFFF;
    }
    public function fetch($key){
        $offset = ($this->_hash($key)%DB_BUCKET_SIZE)*4;
        fseek($this->idx_fp,$offset,SEEK_SET);
        $pos = unpack('L',fread($this->idx_fp,4));
        $pos = $pos[1];
        $found = false;
        while($pos){
            fseek($this->idx_fp,$pos,SEEK_SET);
            $block = fread($this->idx_fp,DB_INDEX_SIZE);
            $cpkey = substr($block,4,DB_KEY_SIZE);

            if(!strncmp($key,$cpkey,strlen($key))){
                $dataoff = unpack('L',substr($block,DB_KEY_SIZE+4,4));
                $dataoff = $dataoff[1];

                $datalen = unpack('L',substr($block,DB_KEY_SIZE+8,4));
                $datalen = $datalen[1];

                $found = true;
                break;
            }
            $pos = unpack('L',substr($block,0,4));
            $pos = $pos[1];
            if(!$found){
                return NULL;
            }
            fseek($this->dat_fp,$dataoff,SEEK_SET);
            $data = fread($this->dat_fp,$datalen);
            return $data;
        }
    }
    public function insert($key,$data){
        $offset = ($this->_hash($key)%DB_BUCKET_SIZE)*4;
        $idxoff = fstat($this->idx_fp);
        $idxoff = intval($idxoff['size']);

        $datoff = fstat($this->dat_fp);
        $datoff = intval($datoff['size']);
        $keylen = strlen($key);
        if($keylen > DB_KEY_SIZE){
            return DB_FAILURE;
        }
        $block = pack('L',0x00000000);
        $block .= $key;
        $space = DB_KEY_SIZE - $keylen;
        for($i=0;$i<$space;$i++){
            $block .= pack('C',0x00);
        }
        $block .= pack('L',$datoff);
        $block .= pack('L',strlen($data));

        fseek($this->idx_fp,$offset,SEEK_SET);
        $pos = unpack('L',fread($this->idx_fp,4));
        $pos = $pos[1];

        if($pos==0){
            fseek($this->idx_fp,$offset,SEEK_SET);
            fwrite($this->idx_fp,pack('L',$idxoff));

            fseek($this->idx_fp,0,SEEK_END);
            fwrite($this->idx_fp,$block,DB_INDEX_SIZE);

            fseek($this->dat_fp,0,SEEK_END);
            fwrite($this->dat_fp,$data,strlen($data));
            return DB_SUCCESS;
        }
        $found = false;
        while($pos){
            fseek($this->idx_fp,$pos,SEEK_SET);
            $tmp_block = fread($this->idx_fp,DB_INDEX_SIZE);
            $cpkey = substr($tmp_block,4,DB_KEY_SIZE);
            if(!strncmp($key,$cpkey,strlen($key))){
                $dataoff = unpack('L',substr($tmp_block,DB_KEY_SIZE+4,4));
                $dataoff = $dataoff[1];
                $datalen = unpack('L',substr($tmp_block,DB_KEY_SIZE+8,4));
                $datalen = $datalen[1];
                $found = true;
                break;
            }
            $prev = $pos;
            $pos = unpack('L',substr($tmp_block,0,4));
            $pos = $pos[1];
        }
        if($found)
            return DB_KEY_EXISTS;

        fseek($this->idx_fp,$prev,SEEK_SET);
        fwrite($this->idx_fp,pack('L',$idxoff),4);
        fseek($this->idx_fp,0,SEEK_END);
        fwrite($this->idx_fp,$block,DB_INDEX_SIZE);
        fseek($this->dat_fp,0,SEEK_END);
        fwrite($this->dat_fp,$data,strlen($data));
        return DB_SUCCESS;

    }

    public function delete($key){
        $offset = ($this->_hash($key)%DB_BUCKET_SIZE)*4;
        fseek($this->idx_fp,$offset,SEEK_SET);

        $head = unpack('L',fread($this->idx_fp,4));
        $head = $head[1];
        $curr = $head;
        $prev = 0;

        while($curr){
            fseek($this->idx_fp,$curr,SEEK_SET);
            $block = fread($this->idx_fp,DB_INDEX_SIZE);

            $next = unpack('L',substr($block,0,4));
            $next = $next[1];

            $cpkey = substr($block,4,DB_KEY_SIZE);
            if(!strncmp($key,$cpkey,strlen($key))){
                $found = true;
                break;
            }
            $prev = $curr;
            $curr = $next;
        }
        if(!$found)
            return DB_FAILURE;
        if($prev==0){
            fseek($this->idx_fp,$offset,SEEK_SET);
            fwirite($this->idx_fp,pack('L',$next),4);
        }else{
            fseek($this->idx_fp,$prev,SEEK_SET);
            fwirite($this->idx_fp,pack('L',$next),4);
        }
        return DB_SUCCESS;
    }
    public function close(){
        if(!$this->closed){
            fclose($this->idx_fp);
            fclose($this->dat_fp);
            $this->closed = true;
        }
    }
}

//插入测试
$db = new DB();
$db->open('dbtest');

$start_time = explode(' ',microtime());
$start_time = $start_time[0]+$start_time[1];

for($i=0;$i<10000;$i++){
    $db->insert("key".$i,"value".$i);
}

$end_time = explode(' ',microtime());
$end_time = $end_time[0]+$end_time[1];

$db->close();
echo 'proccess time in ',($end_time-$start_time),' seconds';

//查询测试
$db = new DB();
$db->open('dbtest');

$start_time = explode(' ',microtime());
$start_time = $start_time[0]+$start_time[1];

for($i=0;$i<10000;$i++){
    $db->fetch("key".$i);
}

$end_time = explode(' ',microtime());
$end_time = $end_time[0]+$end_time[1];

$db->close();
echo 'proccess time in ',($end_time-$start_time),' seconds';

