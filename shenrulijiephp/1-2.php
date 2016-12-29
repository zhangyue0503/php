<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/12/28
 * Time: 上午11:17
 */
?>
<html>
<head>
    <title></title>
</head>
<body>
<?php
function make_list($parent){
    global $tasks;
    echo '<ol>';
    foreach($parent as $task_id =>$todo){
//        echo "<li>$todo";
        echo <<<EOT
<li><input type="checkbox" name="$tasks[$task_id]" value="done"> $todo
EOT;


        if(isset($task[$task_id])){
            make_list($tasks[$task_id]);
        }
        echo "</li>";
    }
    echo '</ol>';
}
$dbc = mysqli_connect('localhost','root','root','books');
$q = "select * from tasks order by parent_id,date_added ASC";
$r = mysqli_query($dbc,$q);

$tasks = array();
while(list($task_id,$parent_id,$task)=mysqli_fetch_array($r,MYSQLI_NUM)){
    $tasks[$parent_id][$task_id] = $task;
}
make_list($tasks[0]);
?>
</body>
</html>
