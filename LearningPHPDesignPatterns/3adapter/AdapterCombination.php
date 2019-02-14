<?php
interface IFormat
{
    public function formatCSS();
    public function formatGraphics();
    public function horizontalLayout();
}

class Desktop implements IFormat
{
    public function formatCSS()
    {
        echo 'Desktop+formatCSS';
    }
    public function formatGraphics()
    {
        echo 'Desktop+formatGraphics';
    }
    public function horizontalLayout()
    {
        echo 'Desktop+horizontalLayout';
    }
}

interface IMobileFormat
{
    public function formatCSS();
    public function formatGraphics();
    public function verticalLayout();
}

class Mobile implements IMobileFormat
{
    public function formatCSS()
    {
        echo 'Mobile+formatCSS';
    }
    public function formatGraphics()
    {
        echo 'Mobile+formatGraphics';
    }
    public function verticalLayout()
    {
        echo 'Mobile+verticalLayout';
    }
}

class MobileAdapter implements IFormat
{
    private $mobile;
    public function __construct(IMobileFormat $mobileNow)
    {
        $this->mobile = $mobileNow;
    }
    public function formatCSS()
    {
        $this->mobile->formatCSS();
    }
    public function formatGraphics()
    {
        $this->mobile->formatGraphics();
    }
    public function horizontalLayout()
    {
        $this->mobile->verticalLayout();
    }
}

class Client
{
    private $mobile;
    private $mobileAdapter;

    public function __construct()
    {
        $this->mobile        = new Mobile();
        $this->mobileAdapter = new MobileAdapter($this->mobile);
        $this->mobileAdapter->formatCSS();
        $this->mobileAdapter->formatGraphics();
        $this->mobileAdapter->horizontalLayout();
    }
}

$worker = new Client();
