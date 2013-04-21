<?php
$link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
mysql_select_db(DB_NAME); 
mysql_query("SET NAMES UTF8;");

$sql = "SELECT `schoolName`, COUNT(*) AS amount FROM $TABLE_INTERVIEW GROUP BY `schoolName` ORDER BY `schoolName`;";
$result = mysql_query($sql,$link);

$i = 1;
while( $data = mysql_fetch_object($result) )
{
    echo "<option value=\"".fill_zero($i)."-$data->schoolName\">"."$data->schoolName</option>\n";
    $i++;
}
mysql_close($link);

?>