<?php

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
mysql_select_db(DB_NAME); 
mysql_query("SET NAMES UTF8;");

$sql = "SELECT `uid`,`name` FROM `twUniversity` ORDER BY `uid`;";
$result = mysql_query($sql,$link);

$i = 1;
while( $data = mysql_fetch_object($result) )
{
    echo "<option value=\"".fill_zero($i)."-$data->name\">".fill_zero($i)."-$data->name</option>\n";
    $i++;
}
mysql_close($link);

?>