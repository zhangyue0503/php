<?php 

include_once('CountryFactory.php');
include_once('TextProduct.php');
include_once('GraphicProduct.php');

class Client {
	private $someCountryObject;

	public function __construct(){
		$this->someCountryObject = new CountryFactory();
		echo $this->someCountryObject->doFactory(new GraphicProduct()) . "<br/>";
		echo $this->someCountryObject->doFactory(new TextProduct()) . "<br/>";
	}
}

$worker = new Client();