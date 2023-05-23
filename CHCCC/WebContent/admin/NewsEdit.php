<?php include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php" ?> 
<html>
	<head>
	<title>News Edit</title>
	  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	   	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
	    <script type="text/javascript">
	        $(function() {
			    $("#newsDate" ).datepicker({ dateFormat: "yy-mm-dd" });
			    $("#newsDate" ).datepicker();

			    $("form :text").width(800);
			    $("#newsDate" ).width(100);
			    //$('input[name^="messageSpeaker"]').width(100);
			    
			  });
	    </script>
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
	<?php include $_SERVER[DOCUMENT_ROOT]. '/admin/header.php'; ?>	
	<div align="center">
<?php
$news_id = $_GET['id'];

$news_date = "";
$news_summary =  "";
$news =  "";
$news_summary_en =  "";
$news_en =  "";
$sort_order =  "";
$published = "";



if (array_key_exists('save', $_POST)) {
	//Post back
	$news_id = $_POST["newsID"];
	
	$news_date = $_POST["newsDate"];
	$news_summary = $_POST["newsSummary"];
	$news = $_POST["news"];
	$news_summary_en = $_POST["newsSummaryEn"];
	$news_en = $_POST["newsEn"];
	
	$sort_order = $_POST["sortOrder"];
	$published = $_POST["published"];
	
	if (empty($sort_order)) {
		$sort_order = 1;
	}
	
	
$db = new PDO('mysql:host='.$db_host.';dbname='.$database,
    $username,
    $password,
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));


	if (empty($news_id))	{
		/*echo "INSERT INTO ch_message " .
				"	(message_date, speaker, message_title, message_audio_File_Name) " .
				"	VALUES " .
				"	('$message_date', '$message_speaker', '$message_title', '$message_audioFileName')";
				
		echo "<br>";
		*/
		
		$db->query("INSERT INTO ch_news " .
				"	(news_date, news_summary, news, news_summary_en, news_en, sort_order, published) " .
				"	VALUES " .
				"	('$news_date', '$news_summary', '$news', '$news_summary_en', '$news_en', '$sort_order', '$published')");
		echo "创建成功";	
	}
	else {
		
		/*echo "UPDATE ch_news SET " .
				"	news_date = '$news_date', " .
				"	news_summary = '$news_summary', " .
				"	news='$news', " .
				"	news_summary_en = '$news_summary_en', " .
				"	news_en = '$news_en', " .
				"	sort_order = '$sort_order', " .
				"	published = '$published' " .
				" WHERE news_id = $news_id";
				
		echo "<br>";
		*/
		$db->query("UPDATE ch_news SET " .
				"	news_date = '$news_date', " .
				"	news_summary = '$news_summary', " .
				"	news='$news', " .
				"	news_summary_en = '$news_summary_en', " .
				"	news_en = '$news_en', " .
				"	sort_order = '$sort_order', " .
				"	published = '$published' " .
				" WHERE news_id = $news_id");
				
		echo "更新成功";
	}
	
	
	//echo "Click <a href='NewsList.php'>here</a> to go back";
	//header("Location: NewsList.php");
	exit();
	
}

else {


	if (!is_null($news_id)) {
		
		mysql_connect($db_host,$username,$password);
		@mysql_select_db($database) or die( "Unable to select database");
		mysql_query ('SET NAMES utf8');
		
		$query="SELECT * FROM ch_news WHERE news_id = $news_id";
		$result=mysql_query($query);
		
		$num=mysql_numrows($result);
		
		mysql_close();
		$news_date = mysql_result($result, 0, "news_date"); 
		$news_summary = mysql_result($result, 0, "news_summary"); 
		$news = mysql_result($result, 0, "news"); 
		$news_summary_en = mysql_result($result, 0, "news_summary_en"); 
		$news_en = mysql_result($result, 0, "news_en"); 
		
		$sort_order = mysql_result($result, 0, "sort_order"); 	
		$published = mysql_result($result, 0, "published");
	}
		
	?>
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<table border="0" cellpadding="0" cellspacing="0" width="80%" align="center">
			<tr>
				<td class="label"></td>
				<td class="space"></td>
				<td><div class="header"><?php echo is_null($news_id) ? "创建" : "更新"; ?>新闻</div><br></td>
			</tr>
			<tr>
				<td class="label">新闻日期:</td>
				<td class="space"></td>
				<td><input type="text" name="newsDate" id="newsDate" value="<?php echo $news_date ?>" /></td>
			</tr>
			<tr>
				<td class="label">中文新闻摘要:</td>
				<td class="space"></td>
				<td><input type="text" name="newsSummary" id="newsSummary"value="<?php echo $news_summary ?>" /></td>
			</tr>
			<tr>
				<td class="label">中文新闻:</td>
				<td class="space"></td>
				<td><textarea name="news" id="news" rows="4" cols="100"><?php echo $news ?></textarea></td>
			</tr>
			<tr>
				<td class="label">英文新闻摘要:</td>
				<td class="space"></td>
				<td><input type="text" name="newsSummaryEn" id="newsSummaryEn" value="<?php echo $news_summary_en ?>" /></td>
			</tr>
			<tr>
				<td class="label">英文新闻:</td>
				<td class="space"></td>
				<td><textarea name="newsEn" id="newsEn" rows="4" cols="100"><?php echo $news_en ?></textarea></td>
			</tr>
			<tr>
				<td class="label">排序</td>
				<td class="space"></td>
				<td><input type="text" name="sortOrder" id="sortOrder" value="<?php echo $sort_order ?>" /></td>
			</tr>
			<tr>
				<td class="label">发布</td>
				<td class="space"></td>
				<td><input type="text" name="published" id="published" value="<?php echo $published ?>" /></td>
			</tr>
			<tr>
				<td class="label"></td>
				<td class="space"></td>
				<td>
					<input type="submit" name="save" value="<?php echo is_null($news_id) ? '创建' : '更新'; ?>" />&nbsp;
					<input type="button" name="cancel" value="取消" onclick="javascript:history.back(1);" />
				</td>
			</tr>
		</table>
		<input type="hidden" name="newsID" value="<?php echo is_null($news_id) ? '' : $news_id; ?>" />
		
	</form>
	
<?php } ?>
</div>
</body>
</html>