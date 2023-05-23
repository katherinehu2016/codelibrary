<!DOCTYPE HTML>
<html>
<head>
  <?php include "$_SERVER[DOCUMENT_ROOT]/common/head.php"; ?>
</head>
<body>
<?php include_once("$_SERVER[DOCUMENT_ROOT]/common/analyticstracking.php") ?>
<?php include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php" ?>
<?php require_once "$_SERVER[DOCUMENT_ROOT]/common/LanguageUtil.php" ?>
<?php include "$_SERVER[DOCUMENT_ROOT]/common/libs/lib_files.php" ?>
  <div id="main">
	<?php include "$_SERVER[DOCUMENT_ROOT]/zh/common/header.php"; ?>		
  <div id="site_content">
<?php
  $language = LanguageUtil::getCurrentLanguage();
  $msg = ($language == 'en') ? 'File Manager' : '文件管理';
  echo "<h1>$msg</h1>\n";
  $msg = file_mgr();
  echo $msg; 
?>
  </div>
	<?php include "$_SERVER[DOCUMENT_ROOT]/zh/common/footer.php"; ?>
  </div>
  <p>&nbsp;</p>
 <?php include "$_SERVER[DOCUMENT_ROOT]/common/bottom.php"; ?>
</body>
</html> 