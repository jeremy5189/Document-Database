<?php 
include('login_checker.php');
include('include/config.php'); 

if($_SESSION['authLevel'] < MANAGER_AUTH_LEVEL )
{
    echo NotFoundPage();
    exit();
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>帳號管理 - <?php echo SYSTEM_NAME; ?></title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <?php include('include/header.php'); ?>
    <style type="text/css" media="screen">
    	.pw {
        	width: 150px;
    	}
    	
    	#uid {
        	width: 20px;
    	}
    	
    	#username {
        	width: 150px;
    	}
    	#password {
        	width: 150px;
    	}
    </style>
    </head>
  <body>
    <div class="container">
      <?php include('include/navbar.php'); ?>
                        
      <div class="row-fluid">
        <div class="span12">
            <div class="navbar">
                <div class="navbar-inner">
                  <a class="brand" href="#">使用者管理</a> 
                </div>
            </div>
              
            <?php
                        
            $link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
            mysql_select_db(DB_NAME); 
            mysql_query("SET NAMES UTF8;");
                        
            $sql = "SELECT * FROM $TABLE_USER_LIST ORDER BY `uid`;";
                        
            $result = mysql_query($sql,$link);
            
            echo "<table class=\"table table-striped\">";  
            echo "<thead>
                <tr>
                  <th>編號</th>
                  <th>名稱</th>
                  <th>權限</th>
                  <th>帳號</th>
                  <th>管理</th>
                </tr>
              </thead><tbody>";
            $n = 1;
            while($data = mysql_fetch_object($result))
            {
                echo "<tr>";
                echo "<th>$n</th>";
                echo "<th>$data->displayName</th>";
                echo "<th>$data->authLevel(".$auth_level_help[$data->authLevel].")</th>";
                echo "<th>$data->username</th>";
                $info = base64_encode("$data->displayName($data->username)");    

                echo "<th>
                <form class=\"form-inline\">
                  <input type=\"password\" class=\"pw\" id=\"pw$n\" class=\"input-small\" placeholder=\"New Password\">
                  <a onclick=\"resetPassword($data->uid,'pw$n')\" class=\"btn btn-small btn-primary\">Reset</a>
                  <a class=\"btn btn-small\" href=\"#\" onclick=\"comfirmDelete('$data->uid','$info')\">Delete</a>
                </form>";               
                echo "</th>";
                echo "</tr>";   
                $n++;   
            }
            
            // Add New User
            echo "</tbody></table>";
            
            echo printNavbar('新增使用者');
            
            echo "<form id=\"adduser\" class=\"form-inline\">";
            echo "<i class=\"icon-plus-sign\"></i> ";
            echo printInput('text','displayName','','名稱');
            echo printInput('text','authLevel','','權限等級');
            echo printInput('text','username','','使用者名稱');
            echo printInput('password','password','','密碼');
            echo "<a onclick=\"addUser()\" id=\"addbtn\" class=\"btn btn-small btn-success\">Add</a>";
            echo "</form>";
            mysql_close($link);
            
            function printInput($type, $id, $val = "", $ph = "")
            {
                return "<input type=\"$type\" id=\"$id\" name=\"$id\" value=\"$val\" class=\"input-small\" placeholder=\"$ph\"> ";
            }
            
            ?>
        </div>   
      </div>
        
      <?php include('include/footer.php'); ?>
      <script type="text/javascript" src="js/php.js"></script>
      <script charset="utf-8">
      
      	var comfirmDelete = function(id,title) {
          	bootbox.confirm("確認要刪除使用者："+base64_decode(title), function(result) {
                if(result)
                {
                    $.post('include/user_ajax.php',{'opr':'delete','id':id} ,function(ret) {
                        if(ret == "ok") {
                                window.location = "user.php";
                        }
                        else
                            bootbox.alert("使用者刪除失敗！");
                    });
                }
            }); 
      	}
      	
      	var resetPassword = function(id,textboxID) {
      	    var npw = sha1($('#'+textboxID).val());
            $.post('include/user_ajax.php',{'opr':'reset','id':id,'newpw':npw}, function(ret) {
                if(ret == "ok") {
                    bootbox.alert("密碼重設成功！",function() {
                        $('#'+textboxID).val('');
                    }); 
                }
                else {
                    bootbox.alert("密碼重設失敗！");
                }
            }); 
      	}
      	
      	var addUser = function() {
      	
      	    var dn = $('#displayName').val();
      	    var al = $('#authLevel').val();
      	    var un = $('#username').val();
      	    var pw = sha1($('#password').val());
      	    
            $.post('include/user_ajax.php',{'opr':'add','displayName':dn,'authLevel':al,'username':un,'password':pw}, function(ret) {
                console.log(ret);
                if(ret == "ok") {
                    bootbox.alert("使用者新增成功！",function() {
                            window.location = "user.php";
                        }); 
                }
                else {
                    bootbox.alert("使用者新增失敗！");
                }
            });
      	}

      	
      	$(function() {
          	 $('.close').click( function() {
                    $('.alert').remove();
             });
             $('#adduser').keypress( function(e) {
                if( e.keycode == 13 )
                {
                   $('#addbtn').click(); 
                }
             });
      	});
      </script>
      </div><!-- .container -->
  </body>
</html>