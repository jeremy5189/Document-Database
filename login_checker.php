<?php 
session_start();
if( $_SESSION['login_success'] != "true" || empty($_SESSION['login_success']) )
{	
	// 取得當前頁面URL
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$nowURL = urldecode($protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	// 傳給login.php
	header("Location: login.php?ref=$nowURL");
	exit();
}
?>
