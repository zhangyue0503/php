<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/12/8
 * Time: 上午9:33
 */
require_once 'domestic.php';
require_once 'wild.php';

$a = new animal();
printf("%s\n",$a->get_type());
$b = new wild\animal();
printf("%s\n",$b->get_type());
use wild\animal as beast;
$c = new beast();
printf("%s\n",$c->get_type());

use \animal\wild\animal as beast2;
$d = new beast2();
printf("%s\n",$d->get_type());
beast2::whereami();

function __autoload($class){
    print "$class\n";
    exit(0);
}

use \animal\wild\animal as beast3;
$e = new beast3();
printf("%s\n",$e->get_type());
beast3::whereami();


//匿名函数（闭包）
$y = 0;
$arr = range(1,100);
$sum = function($x,$y){
    return $x+$y;
};
$sigma = array_reduce($arr,$sum);
print "$sigma\n";

//nowdoc
$pet = new animal2("dog","Fido");
$text = <<<'EOT'
    My favorite animal in the whole world is my {$pet->species}.
    His name is ({$pet->name}.\n
    This is the short name:$pet\n
EOT;
print "NOWDOC:\n$text\n";
$text = <<<EOT
    My favorite animal in the whole world is my {$pet->species}.
    His name is {$pet->name}.\n
    This is the short name:$pet\n
EOT;
print "HEREDOC:\n$text\n";

//goto
$i=10;
LAB:
    echo "i=",$i--,"\n";
    if($i>0) goto LAB;
echo "Loop exited\n";

//SPL
$hp = new SplMaxHeap();
for($i=0;$i<=10;$i++){
    $x = rand(1,1000);
    print "inserting: $x\n";
    $hp->insert($x);
}
$cnt = 1;
print "Retrieving:\n";
foreach($hp as $i){
    print $cnt++." :".$i."\n";
}

class ExtHeap extends SplMaxHeap {
    public function compare($value1, $value2)
    {
        $t1 = strtotime($value1['hiredate']);
        $t2 = strtotime($value2['hiredate']);
        return $t1-$t2;
    }
}

$var1 = array('ename'=>'Smith','hiredate'=>'2009-04-18','sal'=>10000);
$var2 = array('ename'=>'Jones','hiredate'=>'2008-09-20','sal'=>20000);
$var3 = array('ename'=>'Clark','hiredate'=>'2010-01-10','sal'=>30000);
$var4 = array('ename'=>'Clark','hiredate'=>'2007-12-15','sal'=>10000);
$hp = new ExtHeap();
$hp->insert($var1);
$hp->insert($var2);
$hp->insert($var3);
$hp->insert($var4);
foreach($hp as $emp){
    printf("Ename:%s Hiredate:%s\n",$emp['ename'],$emp['hiredate']);
}
clearstatcache();
$finfo = new SplFileInfo("/Users/zhangyue/MyProject/phpproject/php/phpbianchengshizhan/qbf.txt");
print "Basename:".$finfo->getBasename()."\n";
print "Change Time:".strftime("%m/%d/%Y %T",$finfo->getCTime())."\n";
print "Owner UID:".$finfo->getOwner()."\n";
print "Size:".$finfo->getSize()."\n";
print "Directory:".$finfo->isDir()?"No":"Yes";
print "\n";

$flags = FilesystemIterator::CURRENT_AS_FILEINFO|FilesystemIterator::SKIP_DOTS;
$ul = new FilesystemIterator("/usr/local",$flags);
foreach ($ul as $file){
    if($file->isDir()){
        print $file->getFilename()."\n";
    }
}

$flags2 = FilesystemIterator::CURRENT_AS_PATHNAME;
$ul = new GlobIterator("*.php",$flags2);
foreach($ul as $file){
    print "$file\n";
}






