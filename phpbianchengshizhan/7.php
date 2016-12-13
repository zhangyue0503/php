<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/12/13
 * Time: 上午9:33
 */



//$host = "mongodb://172.16.202.136:27017";
$host="mongodb://localhost:27017";
$dbname = "scott";
$colname = "emp";

$EMP = array(
    array("empno"=>7369,"ename"=>"SMITH","job"=>"CLERK","mgr"=>7902,"hiredate"=>"17-DEC-80","sal"=>800,"deptno"=>20),
    array("empno"=>7499,"ename"=>"ALEEN","job"=>"SALESMAN","mgr"=>7798,"hiredate"=>"20-FEB-81","sal"=>1600,"comm"=>300,"deptno"=>30),
    array("empno"=>7521,"ename"=>"WARD","job"=>"SALESMAN","mgr"=>7698,"hiredate"=>"22-FEB-81","sal"=>1250,"comm"=>500,"deptno"=>30),
    array("empno"=>7566,"ename"=>"JONES","job"=>"MANAGER","mgr"=>7839,"hiredate"=>"02-APR-31","sal"=>2975,"deptno"=>20)
);

try {
    $conn = new MongoClient($host);
    $db = $conn->selectDB($dbname);
    $coll = $conn->selectCollection($dbname, $colname);

//    foreach ($EMP as $emp) {
//        $coll->insert($emp, array('w' => true));
//    }

    $cursor = $coll->find(array("deptno"=>20));
    $cursor->sort(array("sal"=>1));
    foreach($cursor as $c){
        foreach($c as $key=>$val){
            if($key!="_id"){print "$val\t";}
        }
        print "\n";
    }

    $cursor = $coll->find()->skip(2)->limit(1);
    $cursor->sort(array("sal"=>1));
    foreach($cursor as $c){
        foreach($c as $key=>$val){
            if($key!="_id"){print "$val\t";}
        }
        print "\n";
    }

    $cursor = $coll->find(array('sal'=>array('$gt'=>2900)));
    $cursor->sort(array("sal"=>1));
    foreach($cursor as $c){
        foreach($c as $key=>$val){
            if($key!="_id"){print "$val\t";}
        }
        print "\n";
    }

    $cursor = $coll->find(array('hiredate'=>new MongoRegex("/\d{2}-dec-\d{2}/i")));
    $cursor->sort(array("sal"=>1));
    foreach($cursor as $c){
        foreach($c as $key=>$val){
            if($key!="_id"){print "$val\t";}
        }
        print "\n";
    }

    $cursor = $coll->find();
    foreach($cursor as $c){
        switch ($c['deptno']){
            case 10:
                $c['dname'] = "ACCOUNTING";
                $c['locl'] = "NEW YORK";
                break;
            case 20:
                $c['dname'] = "RESEARCH";
                $c['locl'] = "DALLAS";
                break;
            case 30:
                $c['dname'] = "SALES";
                $c['locl'] = "CHICAGO";
                break;
            case 40:
                $c['dname'] = "OPERATIONS";
                $c['locl'] = "BOSTON";
                break;
        }
        $c['hiredate'] = new MongoDate(strtotime($c["hiredate"]));
        $coll->update(array("_id"=>$c['_id']),$c);
    }

    $keys = array("deptno"=>1);
    $initial = array('sum'=>0,'cnt'=>0);
    $reduce = new MongoCode('function(obj,prev){prev.sum += obj.sal;prev.cnt++;}');
    $finalize = new MongoCode('function(obj){obj.avg=obj.sum/obj.cnt;}');
    $group_by = $coll->group($keys,$initial,$reduce,array('finalize'=>$finalize));
    foreach($group_by['retval'] as $grp){
        foreach($grp as $key=>$val){
            printf("%s => $s\t",$key,$val);
        }
        print "\n";
    }

} catch (Exception $e) {
    print "Exception:\n";
    die($e->getMessage()."\n");
}

$DDL = <<<EOT
CREATE TABLE dept
(
    deptno integer NOT NULL,
    dname text,
    loc text
);
CREATE TABLE emp
(
empno int PRIMARY KEY NOT NULL,
ename text,
job text,
mgr integer,
hiredate text,
sal real,
comm real,
deptno integer
);
CREATE UNIQUE INDEX pk_emp on emp(empno);
CREATE INDEX emp_deptno on emp(deptno);
CREATE UNIQUE INDEX pk_dept on dept(deptno);
EOT;
$db = new SQLite3("scott.sqlite");
//@$db->exec($DDL);
//if($db->lastErrorCode()!=0){
//    throw new Exception($db->lastErrorMsg()."\n");
//}
//print "Database structure created successfully.\n";





