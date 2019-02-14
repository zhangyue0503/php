<?php

// 继承方式实现适配器

class DollarCalc
{
    private $dollar;
    private $product;
    private $service;
    private $rate = 1;

    public function requestCalc($productNow, $serviceNow)
    {
        $this->product = $productNow;
        $this->service = $serviceNow;
        $this->dollar  = $this->product + $this->service;

        return $this->requestTotal();
    }

    public function requestTotal()
    {
        $this->dollar *= $this->rate;
        return $this->dollar;
    }
}

class EuroCalc
{
    private $euro;
    private $product;
    private $service;
    private $rate = 1;

    public function requestCalc($productNow, $serviceNow)
    {
        $this->product = $productNow;
        $this->service = $serviceNow;
        $this->euro    = $this->product + $this->service;

        return $this->requestTotal();
    }

    public function requestTotal()
    {
        $this->euro *= $this->rate;
        return $this->euro;
    }
}

interface ITarget
{
    public function requester();
}

class EuroAdapter extends EuroCalc implements ITarget
{
    public function __construct()
    {
        $this->requester();
    }
    function requester()
    {
        $this->rate = 0.8111;
        return $this->rate;
    }
}

class Client
{
    private $requestNow;
    private $dollarRequest;

    public function __construct()
    {
        $this->requestNow    = new EuroAdapter();
        $this->dollarRequest = new DollarCalc();

        echo "Euro：" . $this->makeAdapterRequest($this->requestNow);
        echo "Dollars：" . $this->makeDollarRequest($this->dollarRequest);
    }

    private function makeAdapterRequest(ITarget $req)
    {
        return $req->requestCalc(40, 50);
    }
    private function makeDollarRequest(DollarCalc $req)
    {
        return $req->requestCalc(40, 50);
    }

}

$worker = new Client();
