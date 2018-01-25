<?php

header("content-type:text/html;charset=utf-8");
$pdo = new PDO("mysql:host=127.0.0.1;dbname=yuekao",'root','root');
$openid = $_GET['openid'];
$sql = "delete from month where openid = '$openid'";
$resault =$pdo->exec($sql);
if ($resault == TRUE){
    echo "<script>alert('解绑成功');location.href='del_do.php';</script>";
}