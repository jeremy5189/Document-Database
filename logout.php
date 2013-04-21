<?php
session_start();
$_SESSION['UID'] = '';
$_SESSION['displayName'] = '';
$_SESSION['username'] = '';
$_SESSION['authLevel'] = '';
$_SESSION['login_success'] = null;
header("Location: login.php");
?>