<?php
include('config.php');

if( !isset($_POST['id']) && !is_numeric($_POST['id']) )
{
     header("Location: ../add.php?result=error");
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

$lastEditUser = 'admin';
$sql .= "`lastEditUser` = '$lastEditUser' WHERE `id` = %s;";
$sql = sprintf($sql, escape_str($_POST['id']));

echo $sql;

$result = mysql_query($sql,$link);

if($result)
    header("Location: ../manage.php?result=success");
else
    header("Location: ../manage.php?result=error");
mysql_close($link);

?>