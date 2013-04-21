<?php 
include('login_checker.php');
include('include/config.php'); 
?>
<!DOCTYPE html>
<html>
  <head>
    <title>查詢 - <?php echo SYSTEM_NAME; ?></title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <?php include('include/header.php'); ?>
    <style type="text/css" media="screen">
    	#multiSelect {
        	height: 150px;
    	}
    	
    	#multiSelect2 {
        	height: 250px;
    	}
    </style>
    </head>
  <body>
    <div class="container">
      <?php include('include/navbar.php'); ?>
                        
      <div class="row-fluid">
        <div class="span12">
            <?php echo printNavbar("以學校查詢"); ?>
                <form class="form-horizontal well" method="get" action="search.php">
                <fieldset>
                  <div class="control-group">
                    <label class="control-label" for="input02">搜尋</label>
                    <div class="controls">
                      <input type="text" class="input-xlarge" id="input02">
                      <p class="help-block">輸入關鍵字可快速找到項目</p>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="multiSelect2">列表</label>
                    <div class="controls">
                      <select multiple="multiple" name="schoolSelect[]" id="multiSelect2">
                          <?php include('include/school_list.php'); ?>
                      </select>
                      <p class="help-block" id="selectCount">共選中：0項</p>
                    </div>
                  </div>
                  <div class="form-actions">
                    <button type="submit" class="btn btn-primary">查詢</button>
                    <button type="reset" id="reset" class="btn">取消選取</button>
                    <input type="hidden" name="type" value="school">
                  </div>
                </fieldset>
            </form>
             <?php echo printNavbar("以學群查詢"); ?>
            <form class="form-horizontal well" method="get" action="search.php">
                <fieldset>
                  <div class="control-group">
                    <label class="control-label" for="multiSelect">列表</label>
                    <div class="controls">
                      <select multiple="multiple" name="schoolSelect[]" id="multiSelect">
                        <?php include('include/class_list.php'); ?>              
                     </select>
                    </div>
                  </div>
                   <div class="form-actions">
                    <button type="submit" class="btn btn-primary">查詢</button>
                    <button type="reset" id="reset" class="btn">取消選取</button>
                    <input type="hidden" name="type" value="class">
                  </div>
                </fieldset>
            </form>
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