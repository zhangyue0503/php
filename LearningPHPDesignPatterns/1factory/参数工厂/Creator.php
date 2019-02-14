<?php

include_once('Product.php');

abstract class Creator {
	protected abstract function factoryMethod(Product $product);

	public function doFactory($productNow){
		return $this->factoryMethod($productNow);
	}

}