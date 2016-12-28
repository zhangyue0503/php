<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sorting Multidimensional Arrays</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php #Script 1.1 - sort.php
$students = array(
    256=>array('name'=>'Jon','grade'=>98.5),
    2=>array('name'=>'Vance','grade'=>85.1),
    9=>array('name'=>'Stephen','grade'=>94.0),
    364=>array('name'=>'Steve','grade'=>85.1),
    68=>array('name'=>'Rob','grade'=>74.6)
);

function name_sort($x,$y){
    static $count = 1;
    echo "<p>Iteration $count:{$x['name']} vs. {$y['name']}</p>\n";
    $count++;
    return strcasecmp($x['name'],$y['name']);
}

function grade_sort($x,$y){
    static $count = 1;
    echo "<p>Iteration $count:{$x['grade']} vs. {$y['grade']}</p>\n";
    $count++;
    return ($x['grade']<$y['grade']);
}

echo '<h2>Array As Is</h2><pre>'.print_r($students,1).'</pre>';
uasort($students,'name_sort');
echo '<h2>Array Sorted By Name</h2><pre>'.print_r($students,1).'</pre>';
uasort($students,'grade_sort');
echo '<h2>Array Sorted By Grade</h2><pre>'.print_r($students,1).'</pre>';
//
//--
//-- 表的结构 `tasks`
//--
//
//CREATE TABLE `tasks` (
//`task_id` int(10) UNSIGNED NOT NULL,
//  `parent_id` int(10) UNSIGNED NOT NULL,
//  `task` varchar(100) NOT NULL,
//  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
//  `date_completed` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
//) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//
//--
//-- Indexes for dumped tables
//--
//
//--
//-- Indexes for table `tasks`
//--
//ALTER TABLE `tasks`
//  ADD PRIMARY KEY (`task_id`),
//  ADD KEY `date_added` (`date_added`),
//  ADD KEY `date_completed` (`date_completed`),
//  ADD KEY `parent_id` (`parent_id`);
//
//--
//-- 在导出的表使用AUTO_INCREMENT
//--
//
//--
//-- 使用表AUTO_INCREMENT `tasks`
//--
//ALTER TABLE `tasks`
//  MODIFY `task_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

$dbc = mysqli_connect('localhost','root','root','books');
print_r($_REQUEST);echo $_SERVER['REQUEST_METHOD'];
if(($_SERVER['REQUEST_METHOD']=='POST')&&!empty($_POST['task'])){
    if(isset($_POST['parent_id'])&&filter_var($_POST['parent_id'],FILTER_VALIDATE_INT,array('min_range'=>1))){
        $parent_id = $_POST['parent_id'];
    }else{
        $parent_id = 0;
    }
    $task = mysqli_real_escape_string($dbc,strip_tags($_POST['task']));

    $q = "INSERT INTO tasks(parent_id,task) VALUES ($parent_id,'$task')";
    $r = mysqli_query($dbc,$q);

    if(mysqli_affected_rows($dbc)==1){
        echo '<p>The task has been added!</p>';
    }else{
        echo '<p>The task could not be added!</p>';
    }
}

echo '<form action="" method="post">
<fieldset>
    <legend>Add a Task</legend>
    <p>Task: <input name="task" type="text" size="60" maxlength="100" required> </p>
    <p>Parent Task: <select name="parent_id"><option value="0">None</option>
';
$q = 'SELECT task_id,parent_id,task FROM tasks WHERE date_completed="0000-00-00 00:00:00" ORDER BY date_added ASC';
$r = mysqli_query($dbc,$q);

$tasks = array();

while(list($task_id,$parent_id,$task)=mysqli_fetch_array($r,MYSQLI_NUM)){
    echo "<option value='$task_id}'>$task</option>\n";
    $tasks[] = array('task_id'=>$task_id,"parent_id"=>$parent_id,"task"=>$task);
}

echo '</select></p>
<input name="submit" type="submit" value="Add This Task">
</fieldset></form>
';

function parent_sort($x,$y){
    return ($x['parent_id']>$y['parent_id']);
}
usort($tasks,'parent_sort');

echo '<h2>Current To-Do list</h2><ul>';
foreach($tasks as $task){
    echo "<li>(".$task['task'].")</li>\n";
}
echo "</ul>";






?>
</body>
</html>
