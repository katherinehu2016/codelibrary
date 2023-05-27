<?php include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php" ?> 
<html>
	<head>
	<title>music Edit</title>
	  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	   	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
	    <script type="text/javascript">
	        $(function() {
			    $("#musicDate" ).datepicker({ dateFormat: "yy-mm-dd" });
			    $("#musicDate" ).datepicker();

			    $("form :text").width(800);
			    $("#musicDate" ).width(100);
			    $('input[name^="musicTitle"]').width(100);
			    
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
	<?php include $_SERVER['DOCUMENT_ROOT']. '/admin/header.php'; ?>	
	<div align="center">
<?php
$music_id = $_GET['id'];

$music_date = "";
$music_title = "";
$music_audioFileName = "";

if (array_key_exists('save', $_POST)) {
	//Post back
	$music_date = $_POST["musicDate"];
	$music_title = $_POST["musicTitle"];
	$music_audioFileName = $_POST["musicAudioFileName"];
	$music_id = $_POST["musicID"];
	$music_published=$_POST["musicPublished"];
	

	
	$db = new PDO('mysql:host='.$db_host.';dbname='.$database,
    $username,
    $password,
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));


	if (empty($music_id))	{
		
		$db->query("INSERT INTO ch_music " .
				"	(music_date, music_name, music_audio_file_name, published) " .
				"	VALUES " .
				"	('$music_date', '$music_title', '$music_audioFileName', $music_published)");	
				
		echo "创建成功";
	}
	else {
		$db->query("UPDATE ch_music SET " .
				"	music_date = '$music_date', " .
				"	music_name ='$music_title', " .
				"	music_audio_file_name = '$music_audioFileName', " .
				"   published = $music_published" . 
				" 	WHERE music_id = $music_id");
		echo "更新成功";
	}
	
	
	//echo "Click <a href='musicList.php'>here</a> to go back";
	//header("Location: musicList.php");
	exit();
	
}

else {


	if (!is_null($music_id)) {
		
		mysql_connect($db_host,$username,$password);
		@mysql_select_db($database) or die( "Unable to select database");
		mysql_query ('SET NAMES utf8');
		
		$query="SELECT * FROM ch_music WHERE music_id = $music_id";
		$result=mysql_query($query);
		
		$num=mysql_numrows($result);
		
		mysql_close();
		$music_date = mysql_result($result, 0, "music_date");
		$music_title = mysql_result($result, 0, "music_name");
		$music_audioFileName = mysql_result($result, 0, "music_audio_file_name");
		$music_published=mysql_result($result, 0, "published");
		
	}
		
	?>
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<table border="0" cellpadding="0" cellspacing="0" width="80%" align="center">
			<tr>
				<td class="label"></td>
				<td class="space"></td>
				<td><div class="header"><?php echo is_null($music_id) ? "创建" : "更新"; ?>信息</div><br></td>
			</tr>
			<tr>
				<td class="label">日期:</td>
				<td class="space"></td>
				<td><input type="text" name="musicDate" id="musicDate" value="<?php echo $music_date ?>" /></td>
			</tr>
			<tr>
				<td class="label">诗歌名:</td>
				<td class="space"></td>
				<td><input type="text" name="musicTitle" id="musicTitle"value="<?php echo $music_title ?>" /></td>
			</tr>
			<tr>
				<td class="label">诗歌音频文件:</td>
				<td class="space"></td>
				<td><input type="text" name="musicAudioFileName" id="musicAudioFileName" value="<?php echo $music_audioFileName ?>" /></td>
			</tr>
			<tr>
				<td class="label">诗歌发布:</td>
				<td class="space"></td>
				<td><input type="text" name="musicPublished" id="musicPublished" value="<?php echo $music_published ?>" /></td>
			</tr>
			<tr>
				<td class="label"></td>
				<td class="space"></td>
				<td>
					<input type="submit" name="save" value="<?php echo is_null($music_id) ? '创建' : '更新'; ?>" />&nbsp;
					<input type="button" name="cancel" value="取消" onclick="javascript:history.back(1);" />
				</td>
			</tr>
		</table>
		<input type="hidden" name="musicID" value="<?php echo is_null($music_id) ? '' : $music_id; ?>" />
		
	</form>
	
<?php } ?>
</div>
</body>
</html>