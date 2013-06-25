<?php
date_default_timezone_set("Asia/Taipei");

/* Basic Information */
define( "SYSTEM_NAME", "輔導室面試資料庫");
define( "SYSTEM_URL", "");
define( "SYSTEM_VERSION", "1.0");

/* User Level Administration */
define( "MANAGER_AUTH_LEVEL", 30 );
define( "EDITOR_AUTH_LEVEL", 20 );
define( "STUDENT_AUTH_LEVEL", 10 );
define( "GUEST_AUTH_LEVEL", 0 );

$auth_level_help = array( 30 => '全權',
                          20 => '限新增',
                          10 => '限查詢',
                          0 => '限列表');

/* MySQL Database Information */
define( "DB_HOST", "localhost" );
define( "DB_USER", "user" );
define( "DB_PASS", "pass" );
define( "DB_NAME", "db" );

$TABLE_INTERVIEW = 'interview';
$TABLE_USER_LIST = 'interviewUser';

$methods = array('id','schoolName','schoolClass','lastEditTime');

include_once('custom_functions.php');

?>
