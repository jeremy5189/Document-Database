<?php 
session_start(); 
include('include/config.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(empty($_SESSION['login_success']))
    $_SESSION['login_success'] = "";
    
/*/ Force HTTPS
if($_SERVER["HTTPS"] != "on" && $_SERVER["HTTP_HOST"] != 'localhost')
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}*/

// 檢查如果已經登入便轉到首頁
if( $_SESSION['login_success'] == "true" )
{
	header("Location: index.php");
	exit();
}

// 檢查有無自動重新導向
$ref_url = $_GET['ref'];
if( $ref_url == "") $ref_url = "none";

?>
<!DOCTYPE html>
<html>
  <head>
    <title>登入 | <?php echo SYSTEM_NAME; ?></title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('include/header.php'); ?>
    <link href="css/login.css" rel="stylesheet" media="screen">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script charset="utf-8">
    $(function() {
        $('.close').click( function() {
            $('.span4').remove();
        });
    });
    </script>
  </head>
  <body>
    <div class="container">
      <div class="content">
        <div class="row">
            <?php if( $_SESSION['login_success'] == "false" ) {      
            $msg = ' : '. $_SESSION['login_error_msg'];
            echo '<div class="span4">
        	   <div class="alert alert-block">
        	       <a class="close">×</a>
        	       <strong>Error</strong>'.$msg.'
        	   </div>
           </div>';
            } ?>
                
           <div class="login-form">
            <h2><?php echo SYSTEM_NAME; ?></h2>
            <form action="include/login_proc.php" method="post">
                <fieldset>
                    <div class="clearfix">
                        <input type="text" name="username" placeholder="Username" required>
                    </div>
                    <div class="clearfix">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <button class="btn btn-primary" type="submit">Login</button>
                    <input type="hidden" name="ref_url" value="<?php echo $ref_url; ?>" />	
                </fieldset>
            </form>
        </div>
    </div>
    </div>            
    </div><!-- .container -->
  </body>
</html>
