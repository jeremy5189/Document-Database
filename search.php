<?php 
include('login_checker.php');
include('include/config.php'); 

$sortMethod = array();
$abort = false;
$col = null;

foreach( $methods as $mt )
    $sortMethod[$mt] = '';

$selected = "";
if( isset($_GET['sort']) && array_key_exists($_GET['sort'], $sortMethod) )
{
    $selected = $_GET['sort'];
    $sortMethod[$selected] = 'active';
}
else
{
    $sortMethod['id'] = 'active';
    $selected = 'id';
}
?><!DOCTYPE html>
<html>
  <head>
    <title>查詢結果 - <?php echo SYSTEM_NAME; ?></title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <?php include('include/header.php'); ?>
    </head>
  <body>
    <div class="container">
      <?php include('include/navbar.php'); ?>
                        
      <div class="row-fluid">
        <div class="span12">
             <div class="navbar">
                <div class="navbar-inner">
                  <a class="brand" href="#">查詢結果</a>
                   <ul class="nav">
                      <li class="<?php echo $sortMethod['id']; ?>"><a href="?<?php echo $_SERVER['QUERY_STRING']; ?>&sort=id">編號排序</a></li>
                      <li class="<?php echo $sortMethod['schoolName']; ?>"><a href="?<?php echo $_SERVER['QUERY_STRING']; ?>&sort=schoolName">校系排序</a></li>
                      <li class="<?php echo $sortMethod['schoolClass']; ?>"><a href="?<?php echo $_SERVER['QUERY_STRING']; ?>&sort=schoolClass">學群排序</a></li>
                   </ul>
                </div>
            </div>

        
            <?php
            
            if(!isset($_GET['type']) || !isset($_GET['schoolSelect']) )
            {
                echo ErrorAlert('未指定查詢資料，請返回<a href="index.php">首頁</a>查詢！');
               
            }
            else 
            {
            
            $link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
            mysql_select_db(DB_NAME); 
            mysql_query("SET NAMES UTF8;");
            
            if( isset($_GET['type']) && $_GET['type'] == 'school')
                $col = 'schoolName';
            else if( isset($_GET['type']) && $_GET['type'] == 'class')
                $col = 'schoolClass';
            else    
                $abort = true;
            
            $sql = "SELECT * FROM $TABLE_INTERVIEW WHERE ";
            
            foreach( $_GET['schoolSelect'] as $select )
            {
                if( $col == 'schoolName') 
                {
                    $sname = explode('-',$select);
                    $sql .= "`$col` = '".$sname[1]."' OR ";
                }
                else
                {
                    $sql .= "`$col` = '".$select."' OR ";
                }
            }
            
            $sql .= "0 ORDER BY `$selected`;";
            
            if(!$abort)
                $result = mysql_query($sql,$link);
            
            echo "<table class=\"table table-striped\">";  
            echo "<thead>
                <tr>
                  <th>編號</th>
                  <th>學群</th>
                  <th>校系</th>
                  <th>作者</th>
                  <th>檢視</th>
                </tr>
              </thead><tbody>";
            
            $hasOutput = false;
            
            if(!$abort) {
            while($data = mysql_fetch_object($result))
            {
                echo "<tr>";
                echo "<th>$data->id</th>";
                echo "<th>".classlink($data->schoolClass,$map[$data->schoolClass])."</th>";
                echo "<th>".schoolLink($data->schoolName)." $data->schoolDepart</th>";
                echo "<th>$data->studentClass $data->studentName</th>";
                echo "<th><a class=\"btn btn-primary btn-small\" href=\"display.php?id=$data->id\">View</a></th>";
                echo "</tr>";   
                $hasOutput = true;   
            }
            }
            
            echo "</tbody></table>";
            if(!$hasOutput)
                echo ErrorAlert('目前尚未收錄此校系資料，請洽輔導室或稍後重試！<a href="javascript:history.back()">回上一頁</a>');
            mysql_close($link);
            }
            ?>
        </div>   
      </div>
        
      <?php include('include/footer.php'); ?>
      <script charset="utf-8">
      	$(function() {
            <?php
            if(!$hasOutput)
                echo "$('.table').hide();";
            ?>             
      	});
      </script>
      </div><!-- .container -->
  </body>
</html>