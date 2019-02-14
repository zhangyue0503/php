<?php

class Operation
{
    public static function getResult($numA, $numB, $strOperate)
    {
        $strResult  = "";
        switch ($strOperate) {
          case '+':
              $strResult = $numA + $numB;
            break;
          case '-':
              $strResult = $numA - $numB;
              break;
         case '*':
              $strResult = $numA * $numB;
            break;
          case '/':
             $strResult = $numA / $numB;
            break;
        }
        return $strResult;
    }
 }

 class Client
 {
     public function index()
    {
        $numA       = isset( $_POST["numA"] ) ? $_POST["numA"] : 20;    //PHP7  三木运算符缩写
        $numB       = isset( $_POST["numB"] ) ? $_POST["numB"] : 20;
        $strOperate = isset( $_POST["strOperate"] ) ? $_POST["strOperate"] : '*';
        $strResult = Operation::getResult( $numA, $numB, $strOperate );
        //$operation  = new Operation();
        //$strResult  = $operation->getResult($numA, $numB, $strOperate);
        echo "结果是".$strResult;
    }
 }

$client = new Client();
$client->index();