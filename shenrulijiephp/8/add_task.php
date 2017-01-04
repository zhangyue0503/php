<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/4
 * Time: 上午10:55
 */

try {
    $pdo = new PDO('mysql:dbname=books;host=localhost', 'root', 'root');


    if(($_SERVER['REQUEST_METHOD']=='POST')&&!empty($_POST['task'])){
        if(isset($_POST['parent_id'])&&filter_var($_POST['parent_id'],FILTER_VALIDATE_INT,array('min_range'=>1))){
            $parent_id = $_POST['parent_id'];
        }else{
            $parent_id = 0;
        }

        $q = "INSERT INTO tasks(parent_id,task) VALUES (:parent_id,:task)";
        $stmt = $pdo->prepare($q);

        if($stmt->execute(array(':parent_id'=>$parent_id,':task'=>$_POST['task']))){
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
    $r = $pdo->query($q);

    $r->setFetchMode(PDO::FETCH_NUM);

    while($row=$r->fetch()){
        echo "<option value='{$row[0]}'>{$row[2]}</option>\n";
    }
    echo '</select></p>
<input name="submit" type="submit" value="Add This Task">
</fieldset></form>
';

    unset($pdo);
} catch (PDOException $e) {
    echo '<p class="error">An error occurred: '.$e->getMessage().'</p>';
}

