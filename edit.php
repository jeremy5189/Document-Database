<?php 
include('login_checker.php');
include('include/config.php'); 

if($_SESSION['authLevel'] < MANAGER_AUTH_LEVEL )
{
    echo NotFoundPage();
    exit();
}
    
if( isset($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['opr']) && $_GET['opr'] == 'delete' )  
{
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
    mysql_select_db(DB_NAME); 
    mysql_query("SET NAMES UTF8;");
    
    $id = $_GET['id'];
    $sql = "DELETE FROM $TABLE_INTERVIEW WHERE `id` = $id;";
    $result = mysql_query($sql,$link);
    mysql_close($link);
    if($result)
        echo "ok";
    else
        echo "fail";
    exit();
}  
    
?>
<!DOCTYPE html>
<html>
  <head>
    <title>編輯資料 - <?php echo SYSTEM_NAME; ?></title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <?php include('include/header.php'); ?>
    <style type="text/css" media="screen">
    	.textarea {
        	width: 630px;
        	height: 200px;
    	}
    </style>
    </head>
  <body>
    <div class="container">
      <?php include('include/navbar.php'); ?>
                        
      <div class="row-fluid">
        <div class="span12">
        <?php echo printNavbar('修改資料'); ?>
            <form class="form-horizontal well" method="post" action="include/edit_proc.php">
        <fieldset>
          <?php
            
          if( !isset($_GET['id']) || !is_numeric($_GET['id']) )  
          {
              echo ErrorAlert('要求的資料不存在，請重試！');
              exit();
          }
          
          $id = $_GET['id'];
          $link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
          mysql_select_db(DB_NAME); 
          mysql_query("SET NAMES UTF8;");
          
          $sql = "SELECT * FROM $TABLE_INTERVIEW WHERE `id` = $id;";
          $result = mysql_query($sql,$link);
          $data = mysql_fetch_array($result);
          mysql_close($link);
            
          if( isset($_GET['result']) && $_GET['result'] == 'success' )
            echo SuccessAlert('資料修改成功！');
          else if( isset($_GET['result']) && $_GET['result'] == 'error' ) 
            echo ErrorAlert('資料庫發生一些問題，請檢查設定或稍後重試！');
        
          printTextbox( '編號', 'id', 'input-xlarge','', 'required','disabled');
          printTextbox( '年度', 'year', 'input-xlarge', '102');
          ?>
          
           <div class="control-group">
            <label class="control-label" >學群</label>
            <div class="controls">
              <select id="schoolClass" name="schoolClass" required>
                <option value="null">------請選擇------</option>
                <?php include('class_list.php'); ?> 
              </select>
            </div>         
            </div>
          
          <?php
          
         
          printTextbox( '校名', 'schoolName', 'input-xlarge', '', 'required');
          printTextbox( '校系', 'schoolDepart', 'input-xlarge', '', 'required');
          printTextbox( '面試結果', 'schoolResult','input-xlarge', '正取1');
          printTextbox( '學生班級', 'studentClass','input-xlarge', '', 'required');
          printTextbox( '學生姓名', 'studentName','input-xlarge', '', 'required');
          printTextbox( '學生手機', 'studentPhone');
          printTextbox( '學生信箱', 'studentEmail');    
          
         
          
          ?>          
          <div class="control-group">
            <label class="control-label" >學測成績</label>
             <div class="controls">
              <input type="text" id="g1" name="studentGradeChinese" class="input-small" placeholder="國文" required="">
              <input type="text" id="g2" name="studentGradeEnglish" class="input-small" placeholder="英文" required="">
              <input type="text" id="g3" name="studentGradeMath" class="input-small" placeholder="數學" required="">
              <input type="text" id="g4" name="studentGradeSocial" class="input-small" placeholder="社會" required="">
              <input type="text" id="g5" name="studentGradeScience" class="input-small" placeholder="自然" required="">
              <input type="text" id="gt" name="studentGradeTotal" class="input-small" placeholder="總分" required="">
            </div>
          </div>
            
          <?php
          
          printTextbox( '指定甄試項目', 'interviewMethod', 'input-xlarge', '面試,筆試');
          printTextbox( '備審資料項目', 'interviewApplying', 'input-xlarge', '自傳,讀書計劃');
          printTextArea( '甄試過程及內容', 'interviewDetail' );
          printTextArea( '筆試題目及答案', 'interviewPaperTest' );
          printTextArea( '個人心得及建議', 'interviewOpinion' );
          ?>  
            
            
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <button type="reset" class="btn">Cancel</button>
          </div>
        </fieldset>
      </form>    
        </div>   
      </div>
        
      <?php include('include/footer.php'); ?>
      <script type="text/javascript" src="js/php.js"></script>
      <script charset="utf-8">
      
        var displayValue = function( key, val ) {
          	$('#'+key).val(base64_decode(val));
      	}
      	      
      	$(function() {
          	$('#gt').focus( function() {
                var sum = 0;
                for( var i = 1; i <= 5; i++ )
                    sum += parseInt($('#g' + i).val(),10);
                $('#gt').val(sum);
          	});
          	$('.close').click( function() {
                $('.alert').remove();
            });
            <?php
                
            foreach( $data as $key => $val )    
            {
                if(!is_numeric($key))
                    echo "displayValue('$key','".base64_encode($val)."');\n";
            } 
                
            ?>
      	});
      	
      </script>
      </div><!-- .container -->
  </body>
</html>