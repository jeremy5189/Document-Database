<div class="navbar navbar-fixed-top">
   <div class="navbar-inner">
     <div class="container">
       <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
       </a>
       <a class="brand" href="index.php"><?php echo SYSTEM_NAME; ?></a>
       <div class="nav-collapse collapse" id="main-menu">
        <ul class="nav" id="main-menu-left">
          <li <?php echo echoActiveClass("index"); ?>><a href="index.php">查詢資料</a></li>
          <?php if($_SESSION['authLevel'] >= EDITOR_AUTH_LEVEL ) { ?>
          <li <?php echo echoActiveClass("add"); ?>><a href="add.php">新增資料</a></li>
          <?php } if($_SESSION['authLevel'] >= MANAGER_AUTH_LEVEL ) { ?>
          <li <?php echo echoActiveClass("manage"); ?>><a href="manage.php">管理資料</a></li>
          <?php } if($_SESSION['authLevel'] >= MANAGER_AUTH_LEVEL ) { ?>
          <li <?php echo echoActiveClass("user"); ?>><a href="user.php">管理用戶</a></li>
          <?php } ?>
          <li <?php echo echoActiveClass("analysis"); ?>><a href="analysis.php">統計分析</a></li>
        </ul>
        <ul class="nav pull-right" id="main-menu-right">
          <li><a href="#"><?php echo $_SESSION['displayName']; ?></a></li>
          <li><a href="logout.php">登出</a></li>
        </ul>
       </div>
     </div>
   </div>
 </div>
