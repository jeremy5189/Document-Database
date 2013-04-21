<?php
include('config.php');

$opr = $_POST['opr'];

if( $opr == "delete" && isset($_POST['id']) && is_numeric($_POST['id']) )
{
    $id = $_POST['id'];
    
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
    mysql_select_db(DB_NAME); 
    mysql_query("SET NAMES UTF8;");
    
    $sql = "DELETE FROM $TABLE_USER_LIST WHERE `uid` = $id;";
    $result = mysql_query($sql,$link);
    mysql_close($link);
    if($result)
        echo "ok";
    else
        echo "fail";
    exit();
}
else if( $opr == "reset" && isset($_POST['id']) && is_numeric($_POST['id']) )
{
    $id = $_POST['id'];
    
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
    mysql_select_db(DB_NAME); 
    mysql_query("SET NAMES UTF8;");
    
    $sql = "UPDATE $TABLE_USER_LIST SET `password` = '%s' WHERE `uid`= $id;";
    $sql = sprintf($sql,escape_str($_POST['newpw']));
    $result = mysql_query($sql,$link);
    mysql_close($link);
    if($result)
        echo "ok";
    else
        echo "fail";
    exit();
}
else if( $opr == "add" )
{    
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
    mysql_select_db(DB_NAME); 
    mysql_query("SET NAMES UTF8;");
    
    $sql = "INSERT INTO $TABLE_USER_LIST ( ";
    $col = "";
    $val = "";
    foreach($_POST as $key => $value )
    {
        if($key != "opr")
        {
            $col .= "`$key`,";
            $val .= "'".escape_str($value)."',";
        }
    }
    
    $sql = $sql . removeLastChar($col,',') . ") VALUE (" . removeLastChar($val,',') . ");";
    
    $result = mysql_query($sql,$link);
    mysql_close($link);
    if($result)
        echo "ok";
    else
        echo "fail";
    exit();
}

function removeLastChar( $str, $chr )
{
    return substr_replace( $str, '', strrpos( $str, $chr ) );
}

?>