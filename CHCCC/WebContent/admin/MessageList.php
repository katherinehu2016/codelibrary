<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
</head>
<body>
<?php include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php" ?>	
<?php

mysql_connect($db_host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
mysql_query ('SET NAMES utf8');

$query="SELECT * FROM ch_message";
$result=mysql_query($query);

$num=mysql_numrows($result);

mysql_close();

echo "<b><center>Database Output</center></b><br><br>";
$i=0;
while ($i < $num) {

	$speaker=mysql_result($result,$i,"speaker");
	$message_title = mysql_result($result,$i,"message_title");
	$message_id = mysql_result($result,$i,"message_id");
	echo "<b>$speaker</b><br>Message: $message_title<br>";
	echo "<a href='MessageEdit.php?id=$message_id'>Edit</a><p>";
	$i++;
}
?>
<p>
<a href="MessageEdit.php">Create New Message</a>
</body>
</html>
