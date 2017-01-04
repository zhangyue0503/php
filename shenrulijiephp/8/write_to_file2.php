<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/4
 * Time: 上午10:19
 */
require 'WriteToFile2.php';

try {
    $fp = new WriteToFile('data.txt');
    $fp->write('This is a line of data');
    $fp->close();
    unset($fp);

    echo '<p>The data has been written.</p>';
} catch (FileException $e) {
    echo '<p>The process could not be completed because the script:'.$e->getMessage().'<br/>'.$e->getDetails().'</p>';
}

echo '<p>This is the end of the script.</p>';

print_r(PDO::getAvailableDrivers());
