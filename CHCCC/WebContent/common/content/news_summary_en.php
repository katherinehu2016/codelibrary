<?php include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php" ?>
<?php require_once "$_SERVER[DOCUMENT_ROOT]/common/LanguageUtil.php" ?>
<?php
$language = LanguageUtil::getCurrentLanguage();


mysql_connect($db_host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
mysql_query ('SET NAMES utf8');
$query="SELECT * FROM ch_news_en where published=1 and news_summary_en<>'' order by news_date desc,sort_order";
$result=mysql_query($query);

$num=mysql_numrows($result);

mysql_close();

$i=0;

$summary_field="news_summary";
if("en"==$language)$summary_field=$summary_field."_".$language;

while ($i < $num) {

	$news_date=mysql_result($result,$i,"news_date");
	$news_summary=mysql_result($result,$i,$summary_field);
	
	
	echo "<li>$news_summary</li>";
	
	$i++;
}

?>