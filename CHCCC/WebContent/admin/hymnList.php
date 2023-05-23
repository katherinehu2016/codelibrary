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
<div class="header">诗歌管理</div><br>
<a href="hymnEdit.php">创建</a><p/>
<?php

mysql_connect($db_host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
mysql_query ('SET NAMES utf8');

$query="SELECT * FROM ch_music";
$result=mysql_query($query);

$num=mysql_numrows($result);

mysql_close();

echo "<table width='60%' border='1'>";
$i=0;
while ($i < $num) {
	$music_id = mysql_result($result,$i,"music_id");
	$music_date = mysql_result($result,$i,"music_date");
	$music_name = mysql_result($result,$i,"music_name");

		
	$published =  mysql_result($result,$i,"published");
	
	/*if ($published== 1) 
	{
	}
	*/
	
	?>
	<tr>
		<td><?php echo $music_name ?></td>
		<td><a href='hymnEdit.php?id=<?php echo $music_id ?>'>Edit</a></td>
	</tr>
<?php	
	$i++;
}
echo "</table>";
?>

	

<p>
<a href="hymnEdit.php">创建</a>
</div>
</body>
</html>
