<?php require_once "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php" ?>
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

		$targetUri=preg_replace("/\/".$language."\//","/".$target."/",$path);
		if(file_exists("$_SERVER[DOCUMENT_ROOT]$targetUri"))
			print $targetUri.$queryStr;
		else print "/$target/index.php";
	}else print $uri; 
}
mysql_connect($db_host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
mysql_query ('SET NAMES utf8');
$query="SELECT * FROM ch_group order by sort_order";
$result=mysql_query($query);
$num=mysql_numrows($result);
mysql_close();
?><header>     
      <div id="logo">
        <div id="logo_text">           	
		<a href="/index.php"><img src="../../images/logos/Logo0.png" width="932" height="160"></a>
        </div>
      </div>

      <nav>
        <div id="menu_container">
          <ul class="sf-menu" id="nav">
            <li><a href="/zh/index.php">主頁</a></li>
            <li><a href="/zh/aboutus/statement.php">簡介</a>
               <ul>
                <li><a href="/zh/aboutus/statement.php">教會信仰</a></li>
                <li><a href="/zh/aboutus/vision.php">教會異象</a></li>
                <li><a href="/zh/aboutus/history.php">教會歷史</a></li>
                <li><a href="/zh/aboutus/map.php">地圖</a></li>
                <li><a href="/zh/aboutus/contactus.php">聯絡我們</a></li>
              </ul>		
            </li>
            <li><a href="/zh/worship/children_worship.php">崇拜</a>
              <ul>
                <li><a href="/zh/worship/children_worship.php">兒童崇拜</a></li>
                <li><a href="/zh/worship/hymns.php">詩歌</a></li>
                <li><a href="/zh/worship/messages.php">網絡信息</a></li>
                <li><a href="/zh/worship/worship_time.php">崇拜時間</a></li>
              </ul>	
            </li>
            <li><a href="#">团契</a>
              <ul>
				<?php
				$i=0;
				while ($i < $num) {
					$group_id  =mysql_result($result,$i,"group_id");
					$group_name =mysql_result($result,$i,"group_name");
					echo ("<li><a href='/zh/group/group.php?id=$group_id'>$group_name</a></li>");
					$i++;
				} 
				?>                
              </ul>	
            </li>
            <li><a href="/zh/events.php">最新活動</a></li>
            <li><a href="<?php switchLanguage('en'); ?>">English</a></li>
          </ul>
        </div>
      </nav>
    </header>