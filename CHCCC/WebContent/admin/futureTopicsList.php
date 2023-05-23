<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
<style type="text/css">
    div.header {
        font-weight: bolder;
        font-size: 20pt;
    }
    td.label {
        font-size: 13pt;
        text-align:right;
        width: 20%;
    }
    td.space {
    	width:5%;
    }
</style>

</head>
<body>
<?php include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php" ?>
<?php include $_SERVER[DOCUMENT_ROOT]. '/admin/header.php'; ?>	

<div align="center">	
<div class="header">下周預告管理</div><br>

<?php

mysql_connect($db_host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
mysql_query ('SET NAMES utf8');

$query="SELECT * FROM ch_Sermon_News";
$result=mysql_query($query);

$num=mysql_numrows($result);

mysql_close();

echo "<table width='60%' border='1'>";
$i=0;
while ($i < $num) {
	$topics_id = mysql_result($result,$i,"news_id");
	$topics_speaker = mysql_result($result,$i,"speaker");
	$topics_title = mysql_result($result,$i,"title");
	$topics_verse = mysql_result($result,$i,"verse");
	$topics_room = mysql_result($result,$i,"room");
	$sort_order = mysql_result($result,$i,"sort_order");
		
	
	
	?>
	<tr>
		<td><?php echo $topics_speaker ?></td>
		<td><?php echo $topics_title ?></td>
		<td><a href='futureTopicsEdit.php?id=<?php echo $topics_id ?>'>Edit</a></td>
	</tr>
<?php	
	$i++;
}
echo "</table>";
?>

<p>
 
<!-- 
<a href="futureTopicsEdit.php">创建講道預告</a>
 --> 
</div>



<div align="center">	
<div class="header">下周主日學管理</div><br>

<?php

mysql_connect($db_host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
mysql_query ('SET NAMES utf8');

$query="SELECT * FROM ch_SundaySchool_News";
$result=mysql_query($query);

$num=mysql_numrows($result);

mysql_close();

echo "<table width='60%' border='1'>";
$i=0;
while ($i < $num) {
	$topics_id = mysql_result($result,$i,"news_id");
	$topics_speaker = mysql_result($result,$i,"speaker");
	$topics_title = mysql_result($result,$i,"title");
	$topics_verse = mysql_result($result,$i,"verse");
	$topics_room = mysql_result($result,$i,"room");
	$sort_order = mysql_result($result,$i,"sort_order");
		
	
	
	?>
	<tr>
		<td><?php echo $topics_speaker ?></td>
		<td><?php echo $topics_title ?></td>
		<td><a href='futureSundaySchoolEdit.php?id=<?php echo $topics_id ?>'>Edit</a></td>
	</tr>
<?php	
	$i++;
}
echo "</table>";
?>

<p>
<!-- 
<a href="'futureSundaySchoolEdit.php">创建主日學預告</a>
 -->
</div>

</body>
</html>
