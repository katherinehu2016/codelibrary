<?php require_once "$_SERVER[DOCUMENT_ROOT]/common/LanguageUtil.php" ?>
<?php
	$language = LanguageUtil::getCurrentLanguage();
	$title_news="教會消息";
	$title_message="信息";
	$title_songs="主日詩班獻詩";
	if("en"== $language){
		$title_news="News";
		$title_message="Sunday Message";
		$title_songs="Songs";
	}
?>
<div class="content">
       <div class="home_news_summary">
          <h3><?php echo($title_news); ?></h3>
		  <?php include "$_SERVER[DOCUMENT_ROOT]/common/content/news_summary_en.php"; ?>
        </div>
        <div class="latest_message">
          <h3><?php echo ($title_message);?></h3>
		  <?php include "$_SERVER[DOCUMENT_ROOT]/common/content/latest_message_en.php"; ?>		  
        </div>
     <div class="latest_message">
          <h3><?php echo ($title_songs);?></h3>
		  <?php include "$_SERVER[DOCUMENT_ROOT]/common/content/latest_hymn.php"; ?>
        </div>
</div>