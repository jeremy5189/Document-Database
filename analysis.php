<?php 
include('login_checker.php');
include('include/config.php'); 
?><!DOCTYPE html>
<html>
  <head>
    <title>統計分析 - <?php echo SYSTEM_NAME; ?></title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <?php include('include/header.php'); ?>
    </head>
  <body>
    <div class="container">
      <?php include('include/navbar.php'); ?>
                        
      <div class="row-fluid">
        <div class="span6">
          <?php
          
            echo printNavbar('統計：學校');
            
            // Google Chart API
            echo '<div id="chart1_div"></div>';
            
            $link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
            mysql_select_db(DB_NAME); 
            mysql_query("SET NAMES UTF8;");
            
            $sql = "SELECT `schoolName`, COUNT(*) AS amount FROM `$TABLE_INTERVIEW` GROUP BY `schoolName` ORDER BY `schoolName`;";
            
            $result = mysql_query($sql,$link);
            
            echo "<table class=\"table table-striped analysis\">";  
            echo "<thead>
                <tr>
                  <th>學校</th>
                  <th>數量</th>
                </tr>
              </thead><tbody>";

            // Google Chart API Settings
            $chart1_width = 460;
            $chart1_height = 460;
            $chart1_data = array();
            
            $hasOutput = false;
            while($data = mysql_fetch_object($result))
            {
                $hasOutput = true;
                echo "<tr>";
                echo "<th>$data->schoolName</th>";
                echo "<th>$data->amount</th>";
                echo "</tr>";
                // Construct chart data to print to js
                $chart1_data[$data->schoolName] = $data->amount; 
            }
                                    
            echo "</tbody></table>";
            
            if(!$hasOutput)
                echo ErrorAlert('目前資料庫沒有資料或發生錯誤，請檢查資料庫設定');
            
            mysql_close($link);
          ?>
        </div>
        
        <div class="span6">
          <?php
          
            echo printNavbar('統計：學群');
            
            // Google Chart API
            echo '<div id="chart2_div"></div>';
            
            $link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
            mysql_select_db(DB_NAME); 
            mysql_query("SET NAMES UTF8;");
            
            $sql = "SELECT `schoolClass`, COUNT(*) AS amount FROM `$TABLE_INTERVIEW` GROUP BY `schoolClass` ORDER BY `schoolClass`;";
            
            $result = mysql_query($sql,$link);
            
            echo "<table class=\"table table-striped analysis\">";  
            echo "<thead>
                <tr>
                  <th>學群</th>
                  <th>數量</th>
                </tr>
              </thead><tbody>";

            // Google Chart API Settings
            $chart2_width = 460;
            $chart2_height = 460;
            $chart2_data = array();
            
            $hasOutput = false;
            while($data = mysql_fetch_object($result))
            {
                $hasOutput = true;
                echo "<tr>";
                echo "<th>".$map[$data->schoolClass]."</th>";
                echo "<th>$data->amount</th>";
                echo "</tr>";
                $chart2_data[$map[$data->schoolClass]] = $data->amount; 
            }
            
            echo "</tbody></table>";
            
            if(!$hasOutput)
                echo ErrorAlert('目前資料庫沒有資料或發生錯誤，請檢查資料庫設定');
            
            mysql_close($link);
          ?>
        </div>           
      </div>
        
      <?php include('include/footer.php'); ?>
      <script type="text/javascript" src="https://www.google.com/jsapi"></script>
      <script type="text/javascript">
    
          // Load the Visualization API and the piechart package.
          google.load('visualization', '1.0', {'packages':['corechart']});
    
          // Set a callback to run when the Google Visualization API is loaded.
          google.setOnLoadCallback(init);
    
          // Callback that creates and populates a data table,
          // instantiates the pie chart, passes in the data and
          // draws it.
          function init() {
             drawSchoolChart();
             drawClassChart(); 
          }
          
          function drawClassChart() {
            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Slices');
            data.addRows([            
            <?php 
            // Printing Chart data
            foreach( $chart2_data as $key => $val )
                echo "['$key', $val ],\n";
            ?>            
            ]);
    
            // Set chart options
            var options = {'width':<?php echo $chart2_width; ?>,
                           'height':<?php echo $chart2_height; ?>,
                           legend: {position: 'none'},
                           titleTextStyle: {color: 'black', fontSize: 14}};
    
            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart2_div'));
            chart.draw(data, options);
  
          }
          
          function drawSchoolChart() {
    
            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Slices');
            data.addRows([            
            <?php 
            // Printing Chart data
            foreach( $chart1_data as $key => $val )
                echo "['$key', $val ],\n";
            ?>            
            ]);
    
            // Set chart options
            var options = {'width':<?php echo $chart1_width; ?>,
                           'height':<?php echo $chart1_height; ?>,
                           legend: {position: 'none'},
                           titleTextStyle: {color: 'black', fontSize: 14}};
    
            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart1_div'));
            chart.draw(data, options);
          }
      </script>
      </div><!-- .container -->
  </body>
</html>