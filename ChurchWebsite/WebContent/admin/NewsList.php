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
<div class="header">新闻管理</div><br>
<a href="NewsEdit.php">创建新闻</a><p/>
<?php

mysql_connect($db_host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
mysql_query ('SET NAMES utf8');

$query="SELECT * FROM ch_news";
$result=mysql_query($query);

$num=mysql_numrows($result);

mysql_close();

echo "<table width='60%' border='1'>";
$i=0;
while ($i < $num) {
	$news_id = mysql_result($result,$i,"news_id");
	$news_date = mysql_result($result,$i,"news_date");
	$news_summary = mysql_result($result,$i,"news_summary");
	$news = mysql_result($result,$i,"news");
	$news_summary_en = mysql_result($result,$i,"news_summary_en");
	$news_en = mysql_result($result,$i,"news_en");
	$sort_order = mysql_result($result,$i,"sort_order");
		
	
	
	?>
	<tr>
		<td><?php echo $news_summary ?></td>
		<td><a href='NewsEdit.php?id=<?php echo $news_id ?>'>Edit</a></td>
	</tr>
<?php	
	$i++;
}
echo "</table>";
?>

	

<p>
<a href="NewsEdit.php">创建新闻</a>
</div>
</body>
</html>
