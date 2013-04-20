<?php include('include/config.php'); 
    
function printTextbox( $title, $name, $type = "input-xlarge", $ph = "" )
{
    echo "<div class=\"control-group\">          
            <label class=\"control-label\" for=\"$name\">$title</label>
            <div class=\"controls\">
              <input type=\"text\" placeholder=\"$ph\" class=\"$type\" name=\"$name\" id=\"$name\">
            </div>
          </div>";
}

function printTextArea( $title, $name, $type = "input-xlarge" )
{
    echo '<div class="control-group">
            <label class="control-label" for="'.$name.'">'.$title.'</label>
            <div class="controls">
              <textarea class="'.$type.' textarea" name="'.$name.'" id="'.$name.'" rows="3"></textarea>
            </div>
          </div>';
}
    
?>
<!DOCTYPE html>
<html>
  <head>
    <title>新增資料 | <?php echo SYSTEM_NAME; ?></title>
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
        <?php echo printNavbar('新增資料'); ?>
            <form class="form-horizontal well" method="post" action="include/add_proc.php">
        <fieldset>
          <?php
            
          if( isset($_GET['result']) && $_GET['result'] == 'success' )
            echo SuccessAlert('資料加入成功！資料編號：'.$_GET['lastid']);
          else if( isset($_GET['result']) && $_GET['result'] == 'error' ) 
            echo ErrorAlert('資料庫發生一些問題，請檢查設定或稍後重試！');
            
          printTextbox( '年度', 'year', 'input-xlarge', '102');
          ?>
          
           <div class="control-group">
            <label class="control-label" >學群</label>
            <div class="controls">
              <select name="schoolClass">
                <option value="null">------請選擇------</option>
                <?php include('class_list.php'); ?> 
              </select>
            </div>         
            </div>
          
          <?php
          
          printTextbox( '校名', 'schoolName', 'input-xlarge', '國立臺灣科技大學');
          printTextbox( '校系', 'schoolDepart', 'input-xlarge', '資訊管理系');
          printTextbox( '面試結果', 'schoolResult','input-xlarge', '正取1');
          printTextbox( '學生班級', 'studentClass');
          printTextbox( '學生姓名', 'studentName');
          printTextbox( '學生手機', 'studentPhone');
          printTextbox( '學生信箱', 'studentEmail');   
          
         
          
          ?>          
          <div class="control-group">
            <label class="control-label" >學測成績</label>
            <div class="controls">
              <input type="text" id="g1" name="studentGradeChinese" class="input-small" placeholder="國文">
              <input type="text" id="g2" name="studentGradeEnglish" class="input-small" placeholder="英文">
              <input type="text" id="g3" name="studentGradeMath" class="input-small" placeholder="數學">
              <input type="text" id="g4" name="studentGradeSocial" class="input-small" placeholder="社會">
              <input type="text" id="g5" name="studentGradeScience" class="input-small" placeholder="自然">
              <input type="text" id="gt" name="studentGradeTotal" class="input-small" placeholder="總分">
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
      <script charset="utf-8">
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
      	});
      </script>
      </div><!-- .container -->
  </body>
</html>