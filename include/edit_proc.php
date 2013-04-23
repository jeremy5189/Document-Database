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

// 計算該年該學群共幾項，以分配ID
$sql = "SELECT `schoolClass`, COUNT(*) as `total` 
        FROM $TABLE_INTERVIEW WHERE `schoolClass` = '%s' AND `year` = '%s';";
        
$sql = sprintf($sql , escape_str($_POST['schoolClass']),escape_str($_POST['year']));

$result = mysql_query($sql, $link);
$data = mysql_fetch_object($result);

// 建構 UPDATE 字串
$sql = "UPDATE $TABLE_INTERVIEW SET ";

foreach( $_POST as $key => $value )
{
    if( $key == 'id' )
    {
        $id = $_POST['year'].fill_zero_2($_POST['schoolClass']).fill_zero($data->total + 1);
        $sql .= sprintf("`$key` = '%s', ",$id);
    }    
    else
        $sql .= sprintf("`$key` = '%s', ",escape_str($value));
}

$lastEditUser = $_SESSION['username']."(".$_SESSION['displayName'].")";
$time = date("Y-m-d H:i:s");
$sql .= "`lastEditUser` = '$lastEditUser', `lastEditTime` = '$time' WHERE `id` = ".$_POST['id'].";";

$result = mysql_query($sql,$link);

//echo $sql;
if($result)
    header("Location: ../manage.php?result=success");
else
    header("Location: ../manage.php?result=error");
mysql_close($link);


function fill_zero_2( $num )
{
    $num = intval($num);
    if( $num < 10 )
        return "0".$num;
    else
        return $num;
}
?>