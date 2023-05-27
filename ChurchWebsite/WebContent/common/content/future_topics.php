<?php include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php" ?>
<?php require_once "$_SERVER[DOCUMENT_ROOT]/common/LanguageUtil.php" ?>
<?php
    $language = LanguageUtil::getCurrentLanguage();
?>

<div class="latest_message">
<?php
    $header_future_sermon = "下周預告";
    
    $header_future_sermon_title = ""; 
    $header_future_sundaySchool_title = ""; 
    
    $field_speaker="speaker";
    $field_title="title";
    $field_verse="verse";
    $field_room="room"; 

    //sermon header.
    mysql_connect($db_host,$username,$password);
    @mysql_select_db($database) or die( "Unable to select database");
    mysql_query ('SET NAMES utf8');
    $query="SELECT * FROM chccc.ch_Sermon_News where news_id=1 ";
    
    $result=mysql_query($query);
    $num=mysql_numrows($result);
    mysql_close();
    $i=0;
    while ($i < min(1,$num)) {
        $header_future_sermon_title=mysql_result($result,$i,$field_title);
        $i++;
    }
    
    $header_future_sermon_line1 = "<b>講道</b>, Sunday, " . $header_future_sermon_title ;
    
    
    //sunday school header
    mysql_connect($db_host,$username,$password);
    @mysql_select_db($database) or die( "Unable to select database");
    mysql_query ('SET NAMES utf8');
    $query="SELECT * FROM chccc.ch_SundaySchool_News where news_id=1 ";
    
    $result=mysql_query($query);
    $num=mysql_numrows($result);
    mysql_close();
    $i=0;
    while ($i < min(1,$num)) {
        $header_future_sundaySchool_title = mysql_result($result,$i,$field_title);
        $i++;
    }
    
    $header_future_sundaySchool_line1 = "<b>主日學</b>, Sunday, " . $header_future_sundaySchool_title ;
?>

<!-- 講道預告 -->	
<h3><?php echo($header_future_sermon); ?></h3>
<?php echo($header_future_sermon_line1); ?>
<table>
<?php
    mysql_connect($db_host,$username,$password);
    @mysql_select_db($database) or die( "Unable to select database");
    mysql_query ('SET NAMES utf8');
    $query="SELECT * FROM chccc.ch_Sermon_News where news_id>1 order by sort_order ";

	$result=mysql_query($query);
	$num=mysql_numrows($result);
	mysql_close();
	
	$i=0;
	
	echo "<tr><td><b>講員</b></td><td><b>證道</b></td><td><b>經文</b></td><td><b>地點</b></td></tr>";
	while ($i < min(5,$num)) {
		$speaker=mysql_result($result,$i,$field_speaker);
		$title=mysql_result($result,$i,$field_title);
		$verse=mysql_result($result,$i,$field_verse);
		$room=mysql_result($result,$i,$field_room);
        
		
		echo "<tr>";
	    echo " <td valign='top'><b>$speaker</b></td>";
		echo " <td valign='top'>$title</td>";
		echo " <td valign='top'>$verse</td>";	
		echo " <td valign='top'>$room</td>";	
		echo "</tr>";
	
		$i++;
	}
		
?>
</table>


<!-- 主日學預告 -->
<?php echo($header_future_sundaySchool_line1); ?>
<table>
<?php
    mysql_connect($db_host,$username,$password);
    @mysql_select_db($database) or die( "Unable to select database");
    mysql_query ('SET NAMES utf8');
    
    $query="SELECT * FROM chccc.ch_SundaySchool_News where news_id>1 order by sort_order ";

	$result=mysql_query($query);
	$num=mysql_numrows($result);
	mysql_close();
	
	$i=0;
	          
	while ($i < min(5,$num)) {
		$speaker=mysql_result($result,$i,$field_speaker);
		$title=mysql_result($result,$i,$field_title);
		//$verse=mysql_result($result,$i,$field_verse);
		//$room=mysql_result($result,$i,$field_room);
        
		echo "<tr><td /><td><b>講員</b></td><td><b>講道標題</b></td></tr>";
		echo "<tr>";
		echo " <td valign='top'>中文</td>";
	    echo " <td valign='top'><b>$speaker</b></td>";
		echo " <td valign='top'>$title</td>";
		//echo " <td>$verse</td>";	
		//echo " <td>$room</td>";	
		echo "</tr>";
	
		$i++;
	}
		
?>
</table>

<br/>

</div>  



