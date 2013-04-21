<?php
session_start();
include("config.php");

$ref_url = $_POST['ref_url'];

// 取得POST資料
$UserName = $_POST['username'];
$PassWord = $_POST['password'];

if( $UserName == "" || $PassWord == "" )
{
	loginFailed("帳號或密碼錯誤！");
}

// 連接資料庫
$DB_link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
mysql_select_db(DB_NAME); 
mysql_query("SET NAMES UTF8;");

$str = "SELECT * FROM `%s` WHERE `userName` = '%s';";
$str = sprintf( $str, $TABLE_USER_LIST, escape_str($UserName) );

$result = mysql_query($str , $DB_link);

// 空白表示沒找到結果
if( $result != "" )
{
	$data = mysql_fetch_object($result);
	
	// 確認密碼
	if( sha1($PassWord) != $data->password )
		loginFailed("帳號或密碼錯誤！");
	
	// 登入成功，記錄資料
	$_SESSION['UID'] = $data->uid;
	$_SESSION['displayName'] = $data->displayName;
	$_SESSION['username'] = $data->username;
	$_SESSION['authLevel'] = $data->authLevel;
	$_SESSION['login_success'] = "true";
	
	/*	
	$UserIP = getIP();
	$logInTime = date("Y-m-d H:i:s");
	
	//登入成功 寫入登入紀錄
	$sql = "INSERT INTO `LoginRecord` ( `UID`,`UnitName`,`LoginTime`,`LoginIP` ) VALUE( '%s','%s','%s','%s' )  ;";
	$sql = sprintf( $sql , $_SESSION['UID'] , $_SESSION['unitName'] , $logInTime , $UserIP );
	mysql_query($sql , $DB_link);
	mysql_close($DB_link);*/

	// auth < 0 無法登入
    if( $data->authLevel < 0 ) 
	{
		loginFailed("Access Denied!");
	}
	else
	{
		if( $ref_url == "none" || empty($ref_url) ){
			header("Location:../index.php");
            exit();
        }
		else{
			header("Location: $ref_url");
            exit();
		}
	}
}
else
{
    loginFailed("帳號或密碼錯誤！");
}

// 登入失敗請呼叫此函數
function loginFailed($emsg)
{

	$_SESSION['login_success'] = "false";
	$_SESSION['login_timestamp'] = time();
	$_SESSION['login_error_msg'] = $emsg;
	header("Location: ../login.php");
	exit();
}

function getIP()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP']))
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else
		$ip = $_SERVER['REMOTE_ADDR'];
	return $ip;
}

?>
