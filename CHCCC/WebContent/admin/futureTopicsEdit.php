<?php include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php" ?> 
<html>
	        td.label {
	        td.space {
$topics_id = $_GET['id'];
    $db = new PDO('mysql:host='.$db_host.';dbname='.$database,
    if (empty($topics_id))	{
		echo "创建成功";	
	else {
	exit();
		$result=mysql_query($query);
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<input type="hidden" name="topics_id" value="<?php echo is_null($topics_id) ? '' : $topics_id; ?>" />