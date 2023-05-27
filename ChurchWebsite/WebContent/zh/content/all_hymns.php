<?php include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php" ?>
<div class="subcontent">
<li>詩班獻詩</li>
<?php
mysql_connect($db_host, $username, $password);
@ mysql_select_db($database) or die("Unable to select database");
mysql_query('SET NAMES utf8');
$query = "SELECT DISTINCT YEAR(MUSIC_DATE) AS music_year FROM ch_music where music_date >= '2016-12-31' ORDER BY YEAR(MUSIC_DATE) DESC";
$result = mysql_query($query);

//we are using isset() to avoid the "Notice: Undefined Index" from php 

$num = mysql_numrows($result);
$selected_year=null;
if(isset($_GET['music_year']))$selected_year=$_GET['music_year']; 

$i = 0;
echo "<table><tr>";
while ($i < $num) {

	$year = mysql_result($result, $i, "music_year");
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
	echo "<td><a href='$current_url?music_year=$year'>$year</a></td>";

	$i++;
}
echo "</tr></table>";

//MESSAGES
$query = "SELECT * FROM ch_music WHERE YEAR(music_date)=$selected_year and music_date >= '2016-12-31' ORDER BY music_date DESC";
$result = mysql_query($query);

$num = mysql_numrows($result);

$i = 0;

echo "<table style='border-bottom:1px solid #888'><tr><th>日期</th><th>歌名</th></tr>";
while ($i < $num) {
	$background=null;
	if($i%2==0)$background="rgb(245, 245, 250)";
	$music_name = mysql_result($result, $i, "music_name");
	$music_date = mysql_result($result, $i, "music_date");
	$music_file = mysql_result($result, $i, "music_audio_file_name");

	echo "<tr";
	if(isset($background))echo " style='background-color:$background'";
	echo "><td>$music_date</td>" .
			"<td><a href='$audio_library$music_file'>$music_name</a></td>";

	$i++;
}

mysql_close();
echo "</table>";
?>
</div>


