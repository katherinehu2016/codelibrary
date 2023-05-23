<?php include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php" ?> 
<html>
	<head>
	<title>Message Edit</title>
	  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	   	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
	    <script type="text/javascript">
	        $(function() {
			    $("#messageDate" ).datepicker({ dateFormat: "yy-mm-dd" });
			    $("#messageDate" ).datepicker();

			    $("form :text").width(800);
			    $("#messageDate" ).width(100);
			    $('input[name^="messageSpeaker"]').width(100);
			    
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
$message_id = $_GET['id'];

$message_date = "";
$message_speaker = "";
$message_title = "";
$message_audioFileName = "";

$message_speaker_en = "";
$message_title_en = "";
$message_pdfFileName = "";
$message_videoFileName = "";

$bible_verse = "";
$bible_verse_en = "";


if (array_key_exists('save', $_POST)) {
	//Post back
	$message_date = $_POST["messageDate"];
	$message_speaker = $_POST["messageSpeaker"];
	$message_title = $_POST["messageTitle"];
	$message_audioFileName = $_POST["messageAudioFileName"];
	$message_id = $_POST["messageID"];
	
	$message_speaker_en = $_POST["messageSpeakerEn"];
	$message_title_en = $_POST["messageTitleEn"];
	$message_pdfFileName = $_POST["messagePdfFileName"];
	$message_videoFileName = $_POST["messageVideoFileName"];
	
	$bible_verse = $_POST["bibleVerse"];
	$bible_verse_en = $_POST["bibleVerseEn"];
	
	$db = new PDO('mysql:host='.$db_host.';dbname='.$database,
    $username,
    $password,
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));


	if (empty($message_id))	{
		/*echo "INSERT INTO ch_message_en " .
				"	(message_date, speaker, message_title, message_audio_File_Name) " .
				"	VALUES " .
				"	('$message_date', '$message_speaker', '$message_title', '$message_audioFileName')";
				
		echo "<br>";
		*/
		
		$db->query("INSERT INTO ch_message_en " .
				"	(message_date, speaker, message_title, message_audio_File_Name, message_pdf_file_name, message_video_file_name, bible_verses) " .
				"	VALUES " .
				"	('$message_date', '$message_speaker', '$message_title', '$message_audioFileName',  '$message_pdfFileName', '$message_videoFileName', " .
				"	'$bible_verse')");	
				
		echo "创建成功";
	}
	else {
		$db->query("UPDATE ch_message_en SET " .
				"	message_date = '$message_date', " .
				"	speaker = '$message_speaker', " .
				"	message_title='$message_title', " .
				"	message_audio_file_name = '$message_audioFileName', " .
				"	message_pdf_file_name = '$message_pdfFileName', " .
				"	message_video_file_name = '$message_videoFileName', " .
				"	bible_verses = '$bible_verse' " .
				"   WHERE message_id = $message_id");
		echo "更新成功";
	}
	
	
	//echo "Click <a href='MessageList.php'>here</a> to go back";
	//header("Location: MessageList.php");
	exit();
	
}

else {


	if (!is_null($message_id)) {
		
		mysql_connect($db_host,$username,$password);
		@mysql_select_db($database) or die( "Unable to select database");
		mysql_query ('SET NAMES utf8');
		
		$query="SELECT * FROM ch_message_en WHERE message_id = $message_id";
		$result=mysql_query($query);
		
		$num=mysql_numrows($result);
		
		mysql_close();
		$message_date = mysql_result($result, 0, "message_date");
		$message_speaker = mysql_result($result, 0, "speaker");
		$message_title = mysql_result($result, 0, "message_title");
		$message_audioFileName = mysql_result($result, 0, "message_audio_file_name");
		
		$message_speaker_en = mysql_result($result, 0, "speaker_zh");
		$message_title_en = mysql_result($result, 0, "message_title_zh");
		$message_pdfFileName = mysql_result($result, 0, "message_pdf_file_name");
		$message_videoFileName = mysql_result($result, 0, "message_video_file_name");
		
		$bible_verse = mysql_result($result, 0, "bible_verses");
		$bible_verse_en = mysql_result($result, 0, "bible_verses_zh");
		
	}
		
	?>
<h2 class="header"><span style="color:purple">创建并同时上传信息可试用</span>：<a href="SimpleEdit_en.php">SimpleEdit_en.php</a></h2>	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<table border="0" cellpadding="0" cellspacing="0" width="80%" align="center">
			<tr>
				<td class="label"></td>
				<td class="space"></td>
    <td><div class="header"><?php echo is_null($message_id) ? "创建" : "更新"; ?>信息(En)</div><br></td>
			</tr>
   
			<tr>
				<td class="label">信息日期:</td>
				<td class="space"></td>
				<td><input type="text" name="messageDate" id="messageDate" value="<?php echo $message_date ?>" /></td>
			</tr>
			<tr>
				<td class="label">中文讲员:</td>
				<td class="space"></td>
				<td><input type="text" name="messageSpeaker" id="messageSpeaker" value="<?php echo $message_speaker ?>" /></td>
			</tr>
			<tr>
				<td class="label">中文信息标题:</td>
				<td class="space"></td>
				<td><input type="text" name="messageTitle" id="messageTitle"value="<?php echo $message_title ?>" /></td>
			</tr>
			<tr>
				<td class="label">英文讲员:</td>
				<td class="space"></td>
				<td><input type="text" name="messageSpeakerEn" id="messageSpeakerEn" value="<?php echo $message_speaker_en ?>" /></td>
			</tr>
			<tr>
				<td class="label">英文信息标题:</td>
				<td class="space"></td>
				<td><input type="text" name="messageTitleEn" id="messageTitleEn" value="<?php echo $message_title_en ?>" /></td>
			</tr>
			<tr>
				<td class="label">信息音频文件:</td>
				<td class="space"></td>
				<td><input type="text" name="messageAudioFileName" id="messageAudioFileName" value="<?php echo $message_audioFileName ?>" /></td>
			</tr>
			<tr>
				<td class="label">信息PDF文件</td>
				<td class="space"></td>
				<td><input type="text" name="messagePdfFileName" id="messagePdfFileName" value="<?php echo $message_pdfFileName ?>" /></td>
			</tr>
			<tr>
				<td class="label">信息视频文件:</td>
				<td class="space"></td>
				<td><input type="text" name="messageVideoFileName" id="messageVideoFileName" value="<?php echo $message_videoFileName ?>" /></td>
			</tr>
			<tr>
				<td class="label">中文经文:</td>
				<td class="space"></td>
				<td>
				<textarea name="bibleVerse" id="bibleVerse" rows="4" cols="100"><?php echo $bible_verse ?></textarea>
				</td>
			</tr>
			<tr>
				<td class="label">英文经文:</td>
				<td class="space"></td>
				<td><textarea name="bibleVerseEn" id="bibleVerseEn" rows="4" cols="100"><?php echo $bible_verse_en ?></textarea></td>
			</tr>
			<tr>
				<td class="label"></td>
				<td class="space"></td>
				<td>
					<input type="submit" name="save" value="<?php echo is_null($message_id) ? '创建' : '更新'; ?>" />&nbsp;
					<input type="button" name="cancel" value="取消" onclick="javascript:history.back(1);" />
				</td>
			</tr>
		</table>
		<input type="hidden" name="messageID" value="<?php echo is_null($message_id) ? '' : $message_id; ?>" />
		
	</form>
	
<?php } ?>
</div>
</body>
</html>
