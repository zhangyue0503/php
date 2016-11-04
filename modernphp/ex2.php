<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/1
 * Time: 下午4:24
 * 性状
 */

trait Geocodable{
    protected $address;

    protected $geocoder;

    protected $geocoderResult;

    public function setGeocoder($geocoder){
        $this->geocoder = $geocoder;
    }

    public function setAddress($address){
        $this->address = $address;
    }

    public function getLatitude(){
        return $this->geocoder."getLatitude";
    }

    public function getLongitude(){
        return $this->geocoder."getLongitude";
    }

    protected function geocodeAddress(){
        return $this->address."|".$this->geocoder;
    }
}

class RetailStore{
    use Geocodable;
    //会覆盖
//    public function getLongitude(){
//        return "aaa";
//    }
}

$store = new RetailStore();
$store->setAddress("北京市");
$store->setGeocoder("100,200");

print_r($store->getLatitude()."|".$store->getLongitude());



