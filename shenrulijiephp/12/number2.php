#!/usr/local/bin/mampphp
<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/9
 * Time: 上午11:37
 */
if($_SERVER['argc']==2){
    $file = $_SERVER['argv'][1];
    if(file_exists($file)&&is_file($file)){
        if($data = file($file)){
            echo "\nNumbering the file named '$file'...\n---------------\n\n";

            $n = 1;
            foreach($data as $line){
                echo "$n $line";
                $n++;
            }
            echo "\n---------------\nEnd of file '$file'.\n";
            exit(0);

        }else{
            echo "The file could not be read.\n";
            exit(1);
        }

    }else{
        echo "The file does not exist.\n";
        exit(1);
    }
}else{
    echo "\nUsage: number2.php <filename>\n\n";
    exit (1);
}
