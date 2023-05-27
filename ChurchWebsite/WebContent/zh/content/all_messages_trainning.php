<?php include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php" ?>
<div class="subcontent">
<?php
$audio_lib_path="/ChineseSundayMessage/";
mysql_connect($db_host, $username, $password);
@ mysql_select_db($database) or die("Unable to select database");
mysql_query('SET NAMES utf8');
$query = "SELECT DISTINCT YEAR(MESSAGE_DATE) AS message_year FROM ch_message WHERE is_training = 1 AND published = 1 ORDER BY YEAR(MESSAGE_DATE) DESC";
$result = mysql_query($query);


if (!$result) {
	echo "<font color='red'>稍後添加</font>";
	exit();	
}



//we are using isset() to avoid the "Notice: Undefined Index" from php 

$num = mysql_numrows($result);

if ($num == 0) {
	echo "<font color='red'>稍後添加</font>";
	exit();	
}

$selected_year=null;
if(isset($_GET['message_year']))$selected_year=$_GET['message_year']; 

$i = 0;


//echo "<table><tr>";
while ($i < $num) {

	$year = mysql_result($result, $i, "message_year");
	if(!isset($selected_year))$selected_year=$year;
	if(isset($_SERVER['REQUEST_URL'])){
		$current_url=$_SERVER['REQUEST_URL'];
	}
	else{
		$current_uri=$_SERVER['REQUEST_URI'];
		$pos=strpos($current_uri,"?");
		$current_url=$_SERVER['REQUEST_URI'];
		if($pos!=false){
			$current_url=substr($current_uri,0,$pos);
		}		
	}
	//echo "<td><a href='$current_url?message_year=$year'>$year</a></td>";

	$i++;
}
//echo "</tr></table>";


//MESSAGES
$query = "SELECT * FROM ch_message WHERE YEAR(message_date)=$selected_year AND is_training = 1 AND published = 1 ORDER BY message_date DESC";

//echo $query;
//exit();

$result = mysql_query($query);


$num = mysql_numrows($result);

$i = 0;

echo "<table style='border-bottom:1px solid #888'><tr><th>日期</th><th>講員</th><th>主題</th><th>大綱</th></tr>";
while ($i < $num) {
	$background=null;
	if($i%2==0)$background="rgb(245, 245, 250)";
	$speaker = mysql_result($result, $i, "speaker");
	$speaker_title = mysql_result($result, $i, "speaker_title");
	$message_title = mysql_result($result, $i, "message_title");
	$message_date = mysql_result($result, $i, "message_date");
	$message_audio_file =mysql_result($result, $i, "message_audio_file_name");
	$message_pdf_file =mysql_result($result, $i, "message_pdf_file_name");
	
	$date_msg=new DateTime($message_date);	
	if(empty($message_audio_file)){			
		$message_audio_file=date_format($date_msg, 'mdY').".mp3";
	}
	if(empty($message_pdf_file)){
		$message_pdf_file="P".date_format($date_msg, 'mdY').".pdf";
	}
	
	$pdf_exists=false;
	$mp3_exists=false;
	if(file_exists("$_SERVER[DOCUMENT_ROOT]$pdf_library$message_pdf_file")){
		$pdf_exists=true;
		//echo("<!-- file is $_SERVER[DOCUMENT_ROOT]$pdf_library$message_pdf_file -->");
	}

	if(file_exists("$_SERVER[DOCUMENT_ROOT]$audio_lib_path$message_audio_file")){
		$mp3_exists=true;
		//echo("<!-- file is $_SERVER[DOCUMENT_ROOT]$audio_lib_path$message_audio_file -->");
	}

	echo "<tr";
	if(isset($background))echo " style='background-color:$background'";
	
	echo "><td>$message_date</td><td>$speaker</td><td>";
			if($mp3_exists){
				echo "<a href='$audio_library$message_audio_file'>$message_title</a>";
				}else {
				echo "$message_title";
				}
		echo	"</td><td>";
	if($pdf_exists){
			echo "<a href='$pdf_library$message_pdf_file'><img src='/images/pdf.gif'></a>";
	}
	echo "</td></tr>";

	$i++;
}

mysql_close();
echo "</table>";
?>
</div>


