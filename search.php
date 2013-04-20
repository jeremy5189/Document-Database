<?php include('include/config.php'); ?>
<!DOCTYPE html>
<html>
  <head>
    <title>查詢資料 | <?php echo SYSTEM_NAME; ?></title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <?php include('include/header.php'); ?>
    </head>
  <body>
    <div class="container">
      <?php include('include/navbar.php'); ?>
                        
      <div class="row-fluid">
        <div class="span12">
            <?php
            
            $link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
            mysql_select_db(DB_NAME); 
            mysql_query("SET NAMES UTF8;");
            
            if( isset($_GET['type']) && $_GET['type'] == 'school')
                $col = 'schoolName';
            else if( isset($_GET['type']) && $_GET['type'] == 'class')
                $col = 'schoolClass';
            
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
            
            $sql .= "0 ORDER BY `id` DESC;";
            
            $result = mysql_query($sql,$link);
            
            echo "<table class=\"table table-striped\">";  
            echo "<thead>
                <tr>
                  <th>編號</th>
                  <th>學群</th>
                  <th>學校</th>
                  <th>系所</th>
                  <th>作者</th>
                  <th>檢視</th>
                </tr>
              </thead><tbody>";

            while($data = mysql_fetch_object($result))
            {
                echo "<tr>";
                echo "<th>$data->id</th>";
                echo "<th>".classlink($data->schoolClass,$map[$data->schoolClass])."</th>";
                echo "<th>".schoolLink($data->schoolName)."</th>";
                echo "<th>$data->schoolDepart</th>";
                echo "<th>$data->studentClass $data->studentName</th>";
                echo "<th><a class=\"btn btn-primary btn-small\" href=\"display.php?id=$data->id\">View</a></th>";
                echo "</tr>";      
            }
            
            echo "</tbody></table>";
            mysql_close($link);
            ?>
        </div>   
      </div>
        
      <?php include('include/footer.php'); ?>
      <script charset="utf-8">
      	$(function() {
                      
      	});
      </script>
      </div><!-- .container -->
  </body>
</html>