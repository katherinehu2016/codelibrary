<?php include $_SERVER['DOCUMENT_ROOT']. '/common/db_conn.php'; ?>

<html>
	<head>
	<title>Group Edit</title>
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
<?php include $_SERVER['DOCUMENT_ROOT']. '/admin/header.php'; ?>	

		<div align="center">	
<?php
$group_id = $_GET['id'];


$group_name = "";
$group_name_en = "";
$group_description = "";
$group_description_en = "";
$sort_order = "";

if (array_key_exists('save', $_POST)) {
	//Post back
	$group_id = $_POST["group_id"];
	$group_name = $_POST["group_name"];
	$group_description = $_POST["group_description"];
	$group_name_en = $_POST["group_name_en"];
	$group_description_en = $_POST["group_description_en"];
	$sort_order = $_POST["sort_order"];
	
	if (empty($sort_order)) {
		$sort_order = 1;
	}
	
	$db = new PDO('mysql:host='.$db_host.';dbname='.$database,
   	$username,
    $password,
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));


	if (empty($group_id))	{
		/*echo "INSERT INTO ch_message " .
				"	(message_date, speaker, message_title, message_audio_File_Name) " .
				"	VALUES " .
				"	('$message_date', '$message_speaker', '$message_title', '$message_audioFileName')";
				
		echo "<br>";
		*/
		
		$db->query("INSERT INTO ch_group " .
				"	(group_name, group_name_en, group_description, group_description_en, sort_order) " .
				"	VALUES " .
				"	('$group_name', '$group_name_en', '$group_description', '$group_description_en', '$sort_order')");	
		echo "创建成功";
	}
	else {
		$db->query("UPDATE ch_group SET " .
				"	group_name = '$group_name', " .
				"	group_description = '$group_description', " .
				"	group_name_en = '$group_name_en', " .
				"	group_description_en = '$group_description_en', " .
				"	sort_order='$sort_order'" .
				" WHERE group_id = $group_id");
		echo "更新成功";
	}
	
	
	
	//header("Location: GroupList.php");
	exit();
	
}

else {


	if (!is_null($group_id)) {
		
		mysql_connect($db_host,$username,$password);
		@mysql_select_db($database) or die( "Unable to select database");
		mysql_query ('SET NAMES utf8');
		
		$query="SELECT * FROM ch_group WHERE group_id = $group_id";
		$result=mysql_query($query);
		
		$num=mysql_numrows($result);
		
		mysql_close();
		$group_id  =mysql_result($result,0,"group_id");
		$group_name =mysql_result($result,0,"group_name"); 
		$group_description =mysql_result($result, 0, "group_description");
		$group_name_en =mysql_result($result,0,"group_name_en"); 
		$group_description_en =mysql_result($result, 0, "group_description_en");
		$sort_order  =mysql_result($result, 0, "sort_order");
	}
		
	?>
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<table border="0" cellpadding="0" cellspacing="0" width="80%" align="center">
			<tr>
				<td class="label"></td>
				<td class="space"></td>
				<td><div class="header"><?php echo is_null($group_id) ? "创建" : "更新"; ?>团契</div><br></td>
			</tr>
			<tr>
				<td class="label">团契名字:</td>
				<td class="space"></td>
				<td><input type="text" name="group_name" id="group_name" value="<?php echo $group_name ?>" /></td>
			</tr>
			<tr>
				<td class="label">团契英文名字:</td>
				<td class="space"></td>
				<td><input type="text" name="group_name_en" id="group_name_en" value="<?php echo $group_name_en ?>" /></td>
			</tr>
			<tr>
				<td class="label">团契介绍:</td>
				<td class="space"></td>
				<td>
				<textarea name="group_description" id="group_description" rows="15" cols="100"><?php echo $group_description ?></textarea>
				</td>
			</tr>
			<tr>
				<td class="label">团契英文介绍:</td>
				<td class="space"></td>
				<td>
				<textarea name="group_description_en" id="group_description_en" rows="15" cols="100"><?php echo $group_description_en ?></textarea>
				</td>
			</tr>

			<tr>
				<td class="label">排序:</td>
				<td class="space"></td>
				<td><input type="text" name="sort_order" id="sort_order"value="<?php echo $sort_order ?>" /></td>
			</tr>
			<tr>
				<td class="label"></td>
				<td class="space"></td>
				<td>
					<input type="submit" name="save" value="<?php echo is_null($group_id) ? '创建' : '更新'; ?>" />&nbsp;
					<input type="button" name="cancel" value="取消" onclick="javascript:history.back(1);" />
				</td>
			</tr>
		</table>
		<input type="hidden" name="group_id" value="<?php echo is_null($group_id) ? '' : $group_id; ?>" />
	</form>
	
<?php } ?>

	</div>
</body>
</html>