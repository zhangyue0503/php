<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/4
 * Time: 下午12:05
 * composer练习
 *
 * composer require guzzlehttp/guzzle
 * composer require league/csv
 *
 *
 */
require 'vendor/autoload.php';

$client = new \GuzzleHttp\Client();

$csv = \League\Csv\Reader::createFromPath($argv[1]);

foreach($csv as $csvRow){
    try{
        $httpResponse = $client->option($csvRow[0]);
        print_r($httpResponse->getStatusCode());
        if($httpResponse->getStatusCode()>=400){
            throw new \Exception();
        }
    }catch (\Exception $e){
        echo $csvRow[0].PHP_EOL;
        echo $e->getMessage().PHP_EOL;
    }
}