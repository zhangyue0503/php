<?php
abstract class Operation{
	protected $numA = 0;
	protected $numB = 0;

	public function getNumA(){
		return $this->$numA;
	}
	public function setNumA($numA){
		$this->numA = $numA;
	}
	public function getNumB(){
		return $this->$numB;
	}
	public function setNumB($numB){
		$this->numB = $numB;
	}

	public abstract function getResult();

}

class OperationAdd extends Operation{
	public function getResult(){
		return $this->numA + $this->numB;
	}
}

class OperationFactory {
	public function init($operate){
		switch ($operate) {
			case '+':
				$operate = new OperationAdd();
				break;
		}
		return $operate;
	}
}

class Client
 {
     public function index()
    {
        $numA       = isset( $_POST["numA"] ) ? $_POST["numA"] : 20;    //PHP7  三木运算符缩写
        $numB       = isset( $_POST["numB"] ) ? $_POST["numB"] : 20;
        $strOperate = isset( $_POST["strOperate"] ) ? $_POST["strOperate"] : '+';
        $operationFactory = new OperationFactory();
        $operation = $operationFactory->init($strOperate);
        $operation->setNumA($numA);
        $operation->setNumB($numB);
        $strResult = $operation->getResult();
        echo "结果是".$strResult;
    }
 }

$client = new Client();
$client->index();