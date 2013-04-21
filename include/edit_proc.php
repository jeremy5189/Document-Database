<?php
session_start();
include('config.php');

if( !(isset($_POST['id']) && is_numeric($_POST['id'])) )
{
     header("Location: ../edit.php?result=error");
     exit();    
}

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
mysql_select_db(DB_NAME); 
mysql_query("SET NAMES UTF8;");

// 建構 UPDATE 字串
$sql = "UPDATE $TABLE_INTERVIEW SET ";

foreach( $_POST as $key => $value )
{
    $sql .= sprintf("`$key` = '%s', ",escape_str($value));
}

$lastEditUser = $_SESSION['username']."(".$_SESSION['displayName'].")";
$time = date("Y-m-d H:i:s");
$sql .= "`lastEditUser` = '$lastEditUser', `lastEditTime` = '$time' WHERE `id` = %s;";
$sql = sprintf($sql, escape_str($_POST['id']));

$result = mysql_query($sql,$link);

echo $sql;

if($result)
    header("Location: ../manage.php?result=success");
else
    header("Location: ../manage.php?result=error");
mysql_close($link);

?>