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
<?php include "$_SERVER[DOCUMENT_ROOT]/admin/header_en.php" ?>	

<div align="center">	
<div class="header">Message Editor</div><br>
<a href="MessageEdit_en.php">Add Message</a><p/>
<?php

mysql_connect($db_host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
mysql_query ('SET NAMES utf8');

$query="SELECT * FROM ch_message_en order by message_date desc";
$result=mysql_query($query);

$num=mysql_numrows($result);

mysql_close();

echo "<table width='60%' border='1'>";
$i=0;
while ($i < $num) {

	$speaker=mysql_result($result,$i,"speaker");
	$speaker_title =mysql_result($result,$i,"speaker_title");
	$message_title = mysql_result($result,$i,"message_title");
	$message_date = mysql_result($result,$i,"message_date");
	$message_audio_file_name = mysql_result($result,$i,"message_audio_file_name");
	$message_id = mysql_result($result,$i,"message_id");
?>
	<tr>
		<td><?php echo $speaker ?>&nbsp;&nbsp;&nbsp;<?php echo $speaker_title ?></td>
		<td><?php echo $message_title ?></td>
		<td><?php echo $message_date ?></td>
		<td><a href='MessageEdit_en.php?id=<?php echo $message_id ?>'>Edit</a></td>
	</tr>
<?php	
	$i++;
}

echo "</table>";
?>
<p>
<a href="MessageEdit_en.php">Add Message</a>
</div>
</body>
</html>
