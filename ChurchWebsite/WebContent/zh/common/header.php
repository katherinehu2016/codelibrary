<?php require_once "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php" ?>
<?php require_once "$_SERVER[DOCUMENT_ROOT]/common/chccc_prop.php" ?>
<?php
function switchLanguage($target){	
	$uri=$_SERVER["REQUEST_URI"];
	$language="zh";
	if(preg_match("/\/en\//",$uri)){
		$language="en";
	}
	if($target!=$language){
		$pattern="/\/".$language."\//";
		$replacement="/".$target."/";
		$mypos=strpos($uri,"?");
		$path=$uri;
		$queryStr="";
		if($mypos!=false){
			$path=substr($uri,0,$mypos);
			$queryStr=substr($uri,$mypos);
		}

		//echo("path is".$path);
		$targetUri=preg_replace("/\/".$language."\//","/".$target."/",$path);

		if(file_exists("$_SERVER[DOCUMENT_ROOT]$targetUri"))
			print $targetUri.$queryStr;
		else print "/$target/index.php";
	}else print $uri;
}

mysql_connect($db_host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
mysql_query ('SET NAMES utf8');

$query="this is a selet statement ................";

$result=mysql_query($query);

$num=mysql_numrows($result);

mysql_close();

?>
   <header style="padding-top:15px">
  	 <div id="logo">
        <div id="logo_text">
         <a href="/index.php"><img src="../../images/logos/Logo0.png" width="932" height="160"></a>
        </div>
      </div>        
       <nav>
        <div id="menu_container">
		<ul class="sf-menu" id="nav-left">
          	    <li style="padding: 8px 0px 6px 6px;"></li>
          	</ul>
          <ul class="sf-menu" id="nav">
            <li><a href="/zh/index.php">主頁</a></li>
            <li><a href="/zh/aboutus/statement.php">簡介</a>
               <ul>
                <li><a href="/zh/aboutus/statement.php">教會信仰</a></li>
                <li><a href="/zh/aboutus/vision.php">教會異象</a></li>
                <li><a href="/zh/aboutus/history.php">教會歷史</a></li>
                <li><a href="/zh/aboutus/map.php">地圖</a></li>
                <li><a href="/zh/aboutus/contactus.php">聯絡我們</a></li>
				<li><a href="/zh/aboutus/offering.php">奉献</a></li>
              </ul>		
            </li>
           
			^^^^^^^^^^^^^^^^^^^^^^^^^^

            <li><a href="/zh/events.php">最新活動</a></li>
            <li><a href="<?php switchLanguage('en'); ?>">English</a></li>
          </ul>
        </div>
      </nav>
    </header>











 


