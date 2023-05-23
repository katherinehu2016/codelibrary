<table>
<?php include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php" ?>
<?php require_once "$_SERVER[DOCUMENT_ROOT]/common/LanguageUtil.php" ?>
<?php
	$language = LanguageUtil::getCurrentLanguage();

	mysql_connect($db_host,$username,$password);
	@mysql_select_db($database) or die( "Unable to select database");
	mysql_query ('SET NAMES utf8');
	$query="SELECT * FROM ch_music where published=1 order by music_date desc";
	$result=mysql_query($query);
	
	$num=mysql_numrows($result);
	
	mysql_close();
	
	$i=0;
	          
	$name_field="music_name";
	if("en"==$language){
		$name_field=$name_field."_".$language;
	}
	while ($i < min(1,$num)) {
	
		$music_name=mysql_result($result,$i,$name_field);
		$music_date=mysql_result($result,$i,"music_date");
		$music_file=mysql_result($result,$i,"music_audio_file_name");
		
		echo "<tr><td>$music_date</td>" .
				"<td><a href='$audio_library$music_file'>$music_name</a></td>" ;
		
		$i++;
	}
		
?>
</table>


