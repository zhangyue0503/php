<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/17
 * Time: 下午12:14
 */
//PDO
try {
    $dsn = "mysql:host=localhost;dbname=books;";
    $db = new PDO($dsn, 'root', 'root');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("SET NAMES 'UTF8'");
    $sql = "INSERT INTO userinfo(`name`) VALUES ('aaaa')";
    $db->exec($sql);

//预处理
    $insert = $db->prepare("INSERT INTO userinfo(`name`) VALUES (?)");
    $insert->execute(['bbbb']);

    //参数绑定
    $sth = $db->prepare("INSERT INTO userinfo(`name`) VALUES (:username)");
    $username = 'ccccccccc';
    $sth->bindParam(':username',$username,PDO::PARAM_STR,12);
    $sth->execute();

//异常
    $sql = "select * from userinfo";
    $query = $db->prepare($sql);
    $query->execute();
    var_dump($query->fetchAll(PDO::FETCH_ASSOC));




} catch (PDOException $e) {
    echo $e->getMessage();
}

