<?php
include('../include/config.php');

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
mysql_select_db(DB_NAME); 
mysql_query("SET NAMES UTF8;");

// 計算該年該學群共幾項，以分配ID
$sql = "SELECT `schoolClass`, COUNT(*) as `total` 
        FROM $TABLE_INTERVIEW WHERE `schoolClass` = '%s' AND `year` = '%s';";
        
$sql = sprintf($sql , escape_str($_POST['schoolClass']),escape_str($_POST['year']));

$result = mysql_query($sql, $link);
$data = mysql_fetch_object($result);

// ID格式： 年份 ＋ 學群代碼 + 順序號
// EX: 10201001  代表第一學群第一份資料
$id = $_POST['year'].fill_zero_2($_POST['schoolClass']).fill_zero($data->total + 1);

// 建構 INSERT 字串
$sql = "INSERT INTO $TABLE_INTERVIEW ";
$col = "(`id`,";
$val = "($id,";

foreach( $_POST as $key => $value )
{
    $col .= "`$key`,";
    $val .= sprintf("'%s',",escape_str($value));
}

$createTime = date("Y-m-d H:i:s");
//$createUser = $_SESSION['username']."(".$_SESSION['displayName'].")";

//$sql = $sql . $col . '`createTime`,`createUser`) VALUE ' . $val . "'$createTime','$createUser');";
$sql = $sql . $col . '`createTime`) VALUE ' . $val . "'$createTime');";
//echo $sql;
$result = mysql_query($sql,$link);
if($result)
    echo "true"; //header("Location: ../add.php?result=success&lastid=$id");
else
    echo "false"; //header("Location: ../add.php?result=error");
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