<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/4
 * Time: 上午10:19
 */
require 'WriteToFile2.php';

try {
    $fp = new SplFileObject('data.txt','w');
    $fp->fwrite('This is a line of data.\n');
    unset($fp);

    echo '<p>The data has been written.</p>';
} catch (FileException $e) {
    echo '<p>The process could not be completed because the script:'.$e->getMessage().'<br/>'.$e->getDetails().'</p>';
}

echo '<p>This is the end of the script.</p>';

$dir = new DirectoryIterator('../');
foreach ($dir as $item){
    echo $item,PHP_EOL;
}



