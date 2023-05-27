<?php include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php" ?>
<?php
$group_id = $_GET['id'];

mysql_connect($db_host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
mysql_query ('SET NAMES utf8');

$query="SELECT * FROM ch_group where group_id = $group_id";
$result=mysql_query($query);

$num=mysql_numrows($result);

mysql_close();
$group_name =mysql_result($result,0,"group_name"); 
$group_description =mysql_result($result, 0, "group_description");

if (!is_null($group_name) and !empty($group_name)) 
{
?>
<div class="subcontent">

<p>
<li><?php echo $group_name ?></li>
<br />
<?php echo $group_description ?>
</p> 


<?php
	mysql_connect($db_host,$username,$password);
	@mysql_select_db($database) or die( "Unable to select database");
	mysql_query ('SET NAMES utf8');
	
	$query="SELECT gp.photo_id as photo_id, gp.photo_path, gp.photo_description, gp.group_id, g.group_name " .
			"FROM ch_group_photo gp inner join ch_group g on gp.group_id = g.group_id where gp.group_id = $group_id";
	$result=mysql_query($query);
	
	$num=mysql_numrows($result);
	
	mysql_close();
	$i=0;
	while ($i < $num) {
		$photo_path = mysql_result($result,$i,"photo_path");
		$photo_description  = mysql_result($result,$i,"photo_description");
		echo ("<p /><img src='../../images/group/$group_id/$photo_path' />");
		echo ("<br />$photo_description");
		$i++;
	}
}
?>
</div>