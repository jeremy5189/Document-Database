<?php include('include/config.php'); ?>
<!DOCTYPE html>
<html>
  <head>
    <title>查詢 | <?php echo SYSTEM_NAME; ?></title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <?php include('include/header.php'); ?>
    <style type="text/css" media="screen">
      .container-narrow {
        margin: 0 auto;
        max-width: 700px;
      }
      
      dt {
          font-size: 16px;
          padding-top: 6px;
      }
      
      dd{
          padding-top: 6px;
          font-size: 16px;
      }
      
           
      b {
          font-size: 16px;
      }
      
    </style>
    </head>
  <body>
    <div class="container-narrow">
      <?php include('include/navbar.php'); ?>
                        
      <div class="row-fluid">
        <div class="span12">
            <?php 
            
            if(isset($_GET['id']) && is_numeric($_GET['id']) ) 
            {
                $link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
                mysql_select_db(DB_NAME); 
                mysql_query("SET NAMES UTF8;");
                
                $id = $_GET['id'];
                $ret = "";
                $sql = "SELECT * FROM $TABLE_INTERVIEW WHERE `id` = $id;";
                $result = mysql_query($sql,$link);
                $data = mysql_fetch_object($result);
                mysql_close($link);

                if($data != "" ) 
                {
                
                echo printNavbar("松山高中 $data->year 年度大學個人申請「指定項目甄試」記錄"); 
                 
                echo "<form class=\"form-horizontal well\"><fieldset>"; 
                
                echo '<dl class="dl-horizontal">';
                
                echo "<dt>編號：</dt><dd><a href=\"display.php?id=$data->id\">$data->id</a></dd>";
                
                echo "<dt>班級姓名：</dt><dd>$data->studentClass  $data->studentName</dd>";
                
                if($data->schoolResult != null ) $ret = "($data->schoolResult)"; 
        
                echo "<dt>報考科系：</dt><dd>".schoolLink($data->schoolName)." $data->schoolDepart $ret</dd>";
                
                
                echo "<dt>學群分類：</dt><dd>".classlink($data->schoolClass,$map[$data->schoolClass])."</a></dd>";
                
                echo "<dt>學測分數：</dt><dd> 國文 $data->studentGradeChinese 
                                            英文 $data->studentGradeEnglish 
                                            數學 $data->studentGradeMath 
                                            社會 $data->studentGradeSocial 
                                            自然 $data->studentGradeScience 
                                            總級分：$data->studentGradeTotal </dd>";
                                            
                if($data->studentPhone != null)
                    echo "<dt>手機：</dt><dd>$data->studentPhone</dd>";
                
                if(filter_var($data->studentEmail, FILTER_VALIDATE_EMAIL))
                    echo "<dt>信箱：</dt><dd><a href=\"mailto:$data->studentEmail\">$data->studentEmail</a></dd>";
                else if(filter_var($data->studentEmail, FILTER_VALIDATE_URL))
                    echo "<dt>網址：</dt><dd><a href=\"$data->studentEmail\">$data->studentEmail</a></dd>";
                else if($data->studentEmail != null )
                    echo "<dt>信箱：</dt><dd>$data->studentEmail</dd>";
                
                echo "<dt>指定甄試項目：</dt><dd>";
                
                if(strpos($data->interviewMethod,',')===false && $data->interviewMethod != null)
                    echo "$data->interviewMethod</dd>";
                else if( $data->interviewMethod != null )
                {
                    echo "<ol>";
                    $lines = explode(',',$data->interviewMethod);
                    foreach( $lines as $ln )
                    {
                        echo "<li>$ln</li>";
                    }
                    echo "</ol></dd>";
                }    
                else
                    echo "(無)</dd>";
                
                echo "<dt class=\"apl\">備審資料項目：</dt><dd class=\"apl\">";
                
                if(strpos($data->interviewApplying,',')===false && $data->interviewApplying != null )
                    echo "$data->interviewApplying</dd>";
                else if( $data->interviewApplying != "" )
                {
                    echo "<ol>";
                    $lines = explode(',',$data->interviewApplying);
                    foreach( $lines as $ln )
                    {
                        echo "<li>$ln</li>";
                    }
                    echo "</ol></dd>";
                }    
                else
                    echo "(無)</dd>";
                
                echo '</dl>';
                echo "</fieldset></form>";

                echo "<pre><b>一、甄試過程及內容：</b><br/>".checkNull($data->interviewDetail)."</pre></dd>";
                echo "<pre><b>二、筆試題目及答案：</b><br/>".checkNull($data->interviewPaperTest)."</pre></dd>";
                echo "<pre><b>三、個人心得及建議：</b><br/>".checkNull($data->interviewOpinion)."</pre></dd>";
                }
                else
                {
                    echo ErrorAlert('不好意思，您要求的頁面並不存在！請檢查後重試．'); 
                }
            }
            else
            {
                echo ErrorAlert('不好意思，您要求的頁面並不存在！請檢查後重試．'); 
            }
            
            function checkNull( $str )
            {
                if( $str != null )
                    return $str;
                else
                    return "(無)";
            }
            
                
            ?>
            
            
            
            </div>   
      </div>
        
      <?php include('include/footer.php'); ?>
      <script charset="utf-8">
      	$(function() {
            $('#input02').keydown( function(e) {  
                if( e.keyCode == 13 ) {
                    var inp = $('#input02').val();
                    var walking = true;
                    var selected = $('#multiSelect2').val(); 
                    $("#multiSelect2 option").each(function() {
                        if( !walking ) return false; 
                        var current = $(this).val();
                        if( current.indexOf(inp) !== -1 ) {
                            if( selected != null ) selected.push(current);
                            else selected = current;
                            $("#multiSelect2").val(selected);
                            scrollTo( $("#multiSelect2"), current);
                            walking = false;
                        }
                     
                    });
                    $('#selectCount').html("共選中："+$("#multiSelect2 :selected").length+"項");
                    return false;
                }
            });
            $('#multiSelect2').click( function() {
                $('#selectCount').html("共選中："+$("#multiSelect2 :selected").length+"項");
            });
      	});
      	
      	var scrollTo = function( $obj, value ) {
            var arr = value.split('-');
            var num = parseInt(arr[0],10);
            if( num < 10 ) 
                 $obj.scrollTop( 0 );
            else
                $obj.scrollTop( 17 * (num - 1) - 17 * 8);
               	
        }
      </script>
   </div><!-- .container -->
  </body>
</html>