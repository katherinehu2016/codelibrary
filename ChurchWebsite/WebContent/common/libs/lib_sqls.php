<?php

Class Sql {

  function set_db ($db, $host, $usr, $pwd) {
    $db   = (is_null($db))   ? $database : $db;
    $host = (is_null($host)) ? $db_host  : $host;
    $usr  = (is_null($usr))  ? $username : $usr;
    $pwd  = (is_null($usr))  ? $password : $pwd;
    $r    = new PDO('mysql:host='.$host.';dbname='.$db,$usr,$pwd,
          array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));    
    $r->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);           
    if (!$r) { die('Could not connect: '.$db.' for '.$usr. ' due to ' . mysql_error()); }
    return $r;
  }

  function sel ($tab, $whr, $sort_by, $db, $host, $usr, $pwd) {
	$link = mysql_connect($host,$usr,$pwd);
    if (!$link) { die('Could not connect: ' . mysql_error()); }
	@mysql_select_db($db) or die( "Unable to select database $db" . mysql_error());

	mysql_query ('SET NAMES utf8');
	// "SELECT * FROM cc_music where published=1 order by music_date desc";
	$qry="SELECT * FROM $tab where $whr order by $sort_by";
	$result=mysql_query($qry);
    if (!$result) {  die('Could not query:' . mysql_error()); }

	$num=mysql_numrows($result);
    $r = array();
    $i = 0; 	
	while ($i < $num) {
      $row = mysql_fetch_array($result, MYSQL_ASSOC);
      array_push($r, $row);    
	  if ($i >= 500) { $i = $num + 1; }
	  $i++;
	}
	
    mysql_close($link);
    return $r;   
  }

  function upd ($tab, $cns,$whr, $db, $host, $usr, $pwd) {
    $sql = new Sql();
    $dbh = $sql->set_db($db, $host, $usr, $pwd);		
	// "UPDATE ch_music SET  k1=v1, k2=v2 WHERE muisc_id=1 ";
    $txt = ''; 
    foreach ($cns as $k=>$v) { $txt .= ($txt == '') ? " $k='$v' " : ", $k='$v'"; }
    $qry = "UPDATE $tab SET $txt WHERE $whr";
    $sth = $dbh->prepare($qry);
    if (!$sth) { 
        echo "\nPDO::errorInfo():\n";
        print_r($dbh->errorInfo());
        mysql_close($dbh);
        return; 
    }
    $cnt = 0; 
    try {  $cnt = $sth->exec($qry); 
    } catch (PDOException $e) { 
      if ($e->getCode() == '2A000') {  
        echo "Syntax Error: ".$e->getMessage();  return; } 
    } 
    $dbh->commit();
    mysql_close($dbh);
    return "$cnt record(s) updated.";
  }
  
  function add ($tab, $cns,$whr, $db, $host, $usr, $pwd) {
    $sql = new Sql();
    $dbh = $sql->set_db($db, $host, $usr, $pwd);		
	// "INSERT ch_music (k1,k2,k3) VALUES (v1,v2,v3) ";
    $kn=''; $vn=''; 
    foreach ($cns as $k=>$v) { 
      $kn .= ($kn=='') ? " ($k"   : ", $k";
      $vn .= ($vn=='') ? " ('$v'" : ", '$v'"; 
    }
    $kn .= ") "; $vn .= ") "; 
    $qry = "INSERT $tab $kn VALUES $vn";
    $sth = $dbh->prepare($qry);
    if (!$sth) { 
        echo "\nPDO::errorInfo():\n";
        print_r($dbh->errorInfo());
    }
    try {  $cnt = $sth->exec($qry); 
    } catch (PDOException $e) { 
      if ($e->getCode() == '2A000') 
        echo "Syntax Error: ".$e->getMessage(); 
    } 
    $dbh->commit();
    mysql_close($dbh);
  }
  
  function get_music ($tab, $whr, $sort_by, $db, $host, $usr, $pwd) {
    $sql = new Sql();
    $ar = $sql->sel($tab, $whr, $sort_by, $db, $host, $usr, $pwd);
   
    $r = array();
	foreach ($ar as $hr) {
		$cn_name=$hr["music_name"];
		$en_name=$hr["music_name_en"];
		$m_dt   =$hr["music_date"];
		$m_file =$hr["music_audio_file_name"];
		// date format: 2013-09-29
        $y4 = substr($m_dt, 0, 4);
        $ymd=$y4 . substr($m_dt, 5,2) . substr($m_dt,8,2);
        if (!array_key_exists($y4, $r))      { $r[$y4] = array(); }
        if (!array_key_exists($ymd,$r[$y4])) { $r[$y4][$ymd]=array(); }
        $r[$y4][$ymd]['title_cn'] = $cn_name;
        $r[$y4][$ymd]['title_en'] = $en_name;
	}
    return $r;
  } 
  
  function set_music ($tab, $whr, $key, $db, $host, $usr, $pwd) {
    $sql = new Sql();
    $ar  = $sql->sel($tab, $whr, '1', $db, $host, $usr, $pwd);
    print_r($ar); 
    $n   = count($ar);
    if ($n == 0) {				// Add
    
    } elseif ($n == 1) { 		// Update
    
    } else {					// more than one record
    }

  }
  
}
?>