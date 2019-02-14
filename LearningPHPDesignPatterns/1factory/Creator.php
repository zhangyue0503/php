<?php

abstract class Creator {
	protected abstract function factoryMethod();

	public function startFactory(){
		return $this->factoryMethod();
	}
}