<?php 
include('login_checker.php');
include('include/config.php'); 

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
mysql_select_db(DB_NAME); 
mysql_query("SET NAMES UTF8;");

$per = 10;
$result = mysql_query("SELECT count(*) as total FROM $TABLE_INTERVIEW;",$link); 
$data = mysql_fetch_object($result); 
        
$pages = ceil( $data->total / $per );
$page = 0;

if(!isset($_GET["page"]))
{ 
    $page=1; //設定起始頁 
} 
else 
{ 
    $page = intval($_GET["page"]); //確認頁數只能夠是數值資料 
    $page = ($page > 0) ? $page : 1; //確認頁數大於零 
    $page = ($pages > $page) ? $page : $pages; //確認使用者沒有輸入太神奇的數字 
}


if($_SESSION['authLevel'] < MANAGER_AUTH_LEVEL )
{
    echo NotFoundPage();
    exit();
}

$sortMethod = array();

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
    $sortMethod['lastEditTime'] = 'active';
    $selected = 'lastEditTime';
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>管理 - <?php echo SYSTEM_NAME; ?></title>
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
                  <a class="brand" href="#">檢視資料庫</a>
                   <ul class="nav">
                      <li class="<?php echo $sortMethod['id']; ?>"><a href="?sort=id&page=<?php echo $page ?>">編號排序</a></li>
                      <li class="<?php echo $sortMethod['schoolName']; ?>"><a href="?sort=schoolName&page=<?php echo $page ?>">校系排序</a></li>
                      <li class="<?php echo $sortMethod['schoolClass']; ?>"><a href="?sort=schoolClass&page=<?php echo $page ?>">學群排序</a></li>
                      <li class="<?php echo $sortMethod['lastEditTime']; ?>"><a href="?sort=lastEditTime&page=<?php echo $page ?>">時間排序</a></li>
                   </ul>
                </div>
            </div>
              
            <?php
            
            if( isset($_GET['result']) && $_GET['result'] == 'success' )
              echo SuccessAlert('資料修改成功！');
            else if( isset($_GET['result']) && $_GET['result'] == 'error' ) 
              echo ErrorAlert('資料庫發生一些問題，請檢查設定或稍後重試！');
                
            
            $start = ($page-1)*$per; //每頁起始資料序號
            
            $result = mysql_query("SELECT * FROM $TABLE_INTERVIEW ORDER BY $selected LIMIT " . $start . ", " . $per, $link); 
                        
            
            echo "<table class=\"table table-striped\">";  
            echo "<thead>
                <tr>
                  <th>編號</th>
                  <th>學群</th>
                  <th>校系</th>
                  <th>作者</th>
                  <th>上次編輯</th>
                  <th></th>
                </tr>
              </thead><tbody>";

            while($data = mysql_fetch_object($result))
            {
                echo "<tr>";
                echo "<th>$data->id</th>";
                echo "<th>".classlink($data->schoolClass,$map[$data->schoolClass])."</th>";                
                
                $ret = "";
                if($data->schoolResult != null ) $ret = "($data->schoolResult)";
                echo "<th>".schoolLink($data->schoolName)." $data->schoolDepart $ret</th>";
                echo "<th>$data->studentClass $data->studentName</th>";
                if($data->lastEditTime == '0000-00-00 00:00:00')
                    echo "<th>從未</th>";
                else
                    echo "<th><a href=\"#\" title=\"$data->lastEditTime By $data->lastEditUser\">".time2str(strtotime($data->lastEditTime))."</a></th>";
                
                $info = base64_encode("$data->id $data->schoolName $data->schoolDepart");    
                echo "<th><div class=\"btn-group\">
                <a class=\"btn btn-primary btn-small\" href=\"display.php?id=$data->id\">View</a>
                <a class=\"btn btn-success btn-small\" href=\"edit.php?id=$data->id\">Edit</a>
                <a class=\"btn btn-small\" href=\"#\" onclick=\"comfirmDelete('$data->id','$info')\">Delete</a>              
                </div></th>";
                echo "</tr>";      
            }
            
            echo "</tbody></table>";
            
            
                
            echo "<center><div class=\"pagination\">
                    <ul>";
            echo '<li><a href="?page='.(1).'">&lt;&lt;</a></li>';        
            echo '<li><a href="?page='.($page-1).'">&lt;</a></li>';
            for( $i = 1; $i <= $pages; $i++ )
            {
                if( abs($page - $i) <= 3 )
                {
                    if( $page == $i ) 
                        echo '<li class="active"><a href="?page='.$i.'">'.$i.'</a></li>';
                    else
                        echo '<li><a href="?page='.$i.'">'.$i.'</a></li>';        
                }
            }
            echo '<li><a href="?page='.($page+1).'">&gt;</a></li>';
            echo '<li><a href="?page='.($pages).'" title="到第'.$pages.'頁">&gt;&gt;</a></li>';
            echo '</ul></div></center>';
            
        
            mysql_close($link);
            
            
            
            ?>
        </div>   
      </div>
        
      <?php include('include/footer.php'); ?>
      <script type="text/javascript" src="js/php.js"></script>
      <script charset="utf-8">
      	var comfirmDelete = function(id,title) {
          	bootbox.confirm("確認要刪除資料："+base64_decode(title), function(result) {
                if(result)
                {
                    $.get('edit.php?opr=delete&id='+id, function(ret) {
                        if(ret == "ok") {
                                window.location = "manage.php";
                        }
                        else
                            bootbox.alert("資料刪除失敗！");
                    });
                }
            }); 
      	}
      	$(function() {
            
            $('.close').click( function() {
                    $('.alert').remove();
            });
            
      	});
      </script>
      </div><!-- .container -->
  </body>
</html>
