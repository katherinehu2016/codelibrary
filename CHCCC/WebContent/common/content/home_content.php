<?php require_once "$_SERVER[DOCUMENT_ROOT]/common/LanguageUtil.php" ?>
<?php
	$language = LanguageUtil::getCurrentLanguage();
	$title_news="教會消息 <a style='font-size:90%'  href='sunday_stream.php'> → (崇拜网络直播 📺)</a>";
	$title_message="崇拜  <a style='font-size:80%'  href='sunday_stream.php'>(网络直播 📺)</a> ";
	$title_songs="主日詩班獻詩";
	if("en"== $language){
		$title_news="News";
		$title_message="Sunday Message   <a style='font-size:80%'  href='sunday_stream.php'>(网络直播 📺)</a> ";
		$title_songs="Songs";
	}
?>
<div class="content">
       <?php include "$_SERVER[DOCUMENT_ROOT]/common/content/future_topics.php"; ?>    
       <div class="home_news_summary">
          <h3><?php echo($title_news); ?></h3>
		  <?php include "$_SERVER[DOCUMENT_ROOT]/common/content/news_summary.php"; ?>
        </div>
        <div class="latest_message">
          <h3><?php echo ($title_message);?></h3>
		  <?php include "$_SERVER[DOCUMENT_ROOT]/common/content/latest_message.php"; ?>		  
        </div>
     
</div>
