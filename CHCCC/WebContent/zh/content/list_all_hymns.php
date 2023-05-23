<!DOCTYPE HTML>
<html>
<head>
  <?php include "$_SERVER[DOCUMENT_ROOT]/common/head.php"; ?>
</head>
<body>

<?php include_once("$_SERVER[DOCUMENT_ROOT]/common/analyticstracking.php") ?>
  <div id="main">
	<?php include "$_SERVER[DOCUMENT_ROOT]/zh/common/header.php"; ?>		
  <div id="site_content">
<h1> 所有诗歌   </h1>
<table>
<?php include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php" ?>
<?php require_once "$_SERVER[DOCUMENT_ROOT]/common/LanguageUtil.php" ?>
<?php include "$_SERVER[DOCUMENT_ROOT]/common/libs/lib_files.php" ?>
<?php include "$_SERVER[DOCUMENT_ROOT]/common/libs/lib_sqls.php" ?>
<?php
  $choir_dir="$_SERVER[DOCUMENT_ROOT]Choir";
  $choir_url="/Choir";
  $csm_dir = "$_SERVER[DOCUMENT_ROOT]ChineseSundayMessage";
  $csm_url = '/ChineseSundayMessage';

  $today = getdate();
  $h1 = get_choir_files($choir_dir);
  $h2 = get_choir_file2($csm_dir);
  $sql = new Sql();
  $h3 = $sql->get_music('ch_music','published in (0,1)', 'music_date desc',
        $database, $db_host,$username,$password);

  //echo "<pre>H1\n";  print_r($h1);  echo "</pre>\n";
  // echo "<pre>H2\n";  print_r($h2);  echo "</pre>\n";
  //echo "<pre>H3\n";  print_r($h3);  echo "</pre>\n";

  $hm = array();
  foreach ($h1 as $y4=>$a1) {
    if (!array_key_exists($y4, $hm)) { $hm[$y4] = array(); }
    foreach ($a1 as $ymd=>$fn) {
      if (!array_key_exists($ymd, $hm[$y4])) { $hm[$y4][$ymd] = array(); }
      //$hm[$y4][$ymd]['file'] = $fn;
      $hm[$y4][$ymd]['file'] = $h1[$y4][$ymd];
      if (array_key_exists($y4, $h2) && array_key_exists($ymd, $h2[$y4])) {
        $hm[$y4][$ymd]['fn2'] = $h2[$y4][$ymd];
      }
      if (array_key_exists($y4, $h3) && array_key_exists($ymd, $h3[$y4])) {
        $hm[$y4][$ymd]['title_cn'] = $h3[$y4][$ymd]['title_cn'];
        $hm[$y4][$ymd]['title_en'] = $h3[$y4][$ymd]['title_en'];
      }
    }
  }
  foreach ($h2 as $y4=>$a1) {
    if (!array_key_exists($y4, $hm)) { $hm[$y4] = array(); }
    foreach ($a1 as $ymd=>$fn) {
      if (!array_key_exists($ymd, $hm[$y4])) { $hm[$y4][$ymd] = array(); }
      //if (array_key_exists($y4, $h1) && array_key_exists($ymd, $h1[$y4])) { continue; }
      //if (!array_key_exists('file', $hm[$y4][$ymd])) { $hm[$y4][$ymd]['file'] = array(); }
      $hm[$y4][$ymd]['fn2'] = $h2[$y4][$ymd];
      if (array_key_exists($y4, $h3) && array_key_exists($ymd, $h3[$y4])) {
        $hm[$y4][$ymd]['title_cn'] = $h3[$y4][$ymd]['title_cn'];
        $hm[$y4][$ymd]['title_en'] = $h3[$y4][$ymd]['title_en'];
      }
    }
  }

  //echo "<pre>\n";  print_r($_SERVER);  echo "</pre>\n";
  // echo "<pre>H2\n";  print_r($hm);  echo "</pre>\n";

  $language = LanguageUtil::getCurrentLanguage();

  krsort($hm);
  // echo "<pre>\n";  print_r($hm['2014']); echo "</pre>\n";
  foreach ($hm as $y4=>$a1) {
    ksort($a1);
    echo "<tr><td colspan=2 style='background-color:#00FF00'>$y4</td></tr>\n";
    foreach ($a1 as $ymd=>$a2) {
      $title_cn = (array_key_exists('title_cn', $a2)) ? $a2['title_cn'] : '';
      $title_en = (array_key_exists('title_en', $a2)) ? $a2['title_en'] : '';
      $dt = substr($ymd,0,4) . '-' . substr($ymd,4,2) . '-' . substr($ymd, 6,2);
      if (array_key_exists('file', $a2)) {
        echo get_html($a2, 'file', $language, $dt, $title_cn, $title_en, $csm_url, $choir_url);
      } elseif (array_key_exists('fn2', $a2)) {
        echo get_html($a2, 'fn2', $language, $dt, $title_cn, $title_en, $csm_url, $choir_url);
      } else {
        echo "<tr><td>$dt</td>" .
            "<td>$title_cn/$title_en</td></tr>\n";
      }
    }
  }

  function get_html ($ar, $k, $language, $dt, $title_cn, $title_en, $csm_url, $choir_url) {
    $n = count($ar[$k]);
    if ($n < 1) { return; }
    $url = ($k == 'file') ? "$choir_url" : $csm_url;
    $ur2 = "/common/content/file_mgr.php?file_name=";
    $fn = $ar[$k][0];
    // yyyy/myyyymmdd.[mp3|wma]   m{mm}{dd}{yy}.[mp3|wma]
    $ext = ($k == 'file') ? substr($fn,5) : substr($fn,1);
    $cn = (!isset($title_cn) || trim($title_cn)==='') ? $ext : $title_cn;
    $en = (!isset($title_en) || trim($title_en)==='') ? $ext : $title_en;
    $tit = ($language == 'en') ? $cn : $en;
    $txt = ($language == 'en') ? $en : $cn;
    $fmt = "<tr><td>%s</td>\n     <td><a href='%s' title='%s' target=_blank>%s</a></td>\n</tr>\n" ;
    $ftr = "<tr><td>%s</td>\n     <td>%s</td>\n</tr>\n" ;
    $ft2 = "<tr><td>%s</td>\n     <td>%s" ;
    $f_a = "<a href='%s' title='%s' target=_blank>%s</a>";
    $r = '';
    if ($n == 1) {
      if ($k == 'file' && array_key_exists('fn2', $ar)) {
        $t = sprintf($f_a, "$url/$fn", $tit, $txt);
        foreach ($ar['fn2'] as $i=>$fn) {
          if ($i > 0) { $t .= ","; }
          //$t .= '|' . sprintf($f_a, "$csm_url/$fn", $tit, "D:$txt");
          $t .= '|' . sprintf($f_a, "$ur2$fn", $tit, "D:$txt");
        }
        $r .= sprintf($ft2, $dt, $t);
      } else {
        // $r .= sprintf($fmt, $dt, "$url/$fn", $tit, $txt);
        $r .= "<tr><td>$dt</td>\n     <td>" . sprintf($f_a,"$url/$fn", $tit, $txt); 
        if (!array_key_exists('file', $ar)) {
          $tit = "Move $csm_url/$fn to $choir_url";
          //$r .= "[" . sprintf($f_a, "$csm_url/$fn", $tit, "M:$txt") . "]";
          $r .= "[" . sprintf($f_a, "$ur2$fn", $tit, "M:$txt") . "]";
        }
      }

    } else {
      $r .= "<tr><td>$dt</td>\n    <td>$txt [";
      foreach ($ar[$k] as $i=>$fn) {
        // yyyy/myyyymmdd.[mp3|wma]  m{mm}{dd}{yy}.[mp3|wma]
        $ext = ($k == 'file') ? substr($fn,15) : substr($fn,8);
        //$tit = (!isset($en) || trim($en)==='') ? $en : $fn;
        if ($i > 0) { $r .= ","; }
        $r .= "<a href='$url/$fn' title='$tit:$txt' target=_blank>$ext</a>" ;
      }
      if ($k == 'file' && array_key_exists('fn2', $ar)) {
        //$t = '|' . sprintf($f_a, "$url/$fn", $tit, $txt);
        $t = '|';
        foreach ($ar['fn2'] as $i=>$fn) {
          if ($i > 0) { $t .= ","; }
         // $t .= sprintf($f_a, "$csm_url/$fn", $tit, "D:$txt");
          $t .= sprintf($f_a, "$ur2$fn", $tit, "D:$txt");
        }
        $r .= $t;
      }
      if (!array_key_exists('file', $ar)) {
        $r .= "|"; 
        foreach ($ar['fn2'] as $i=>$fn) {
          $tit = "Move $csm_url/$fn to $choir_url";
          if ($i > 0) { $t .= ","; }
         //  $r .= sprintf($f_a, "$csm_url/$fn", $tit, "M:$txt");
          $r .= sprintf($f_a, "$ur2/$fn", $tit, "M:$txt");
        }
      }
      $r .= "]";
    }
    if ((!isset($title_cn) || trim($title_cn)==='') 
      && (!isset($title_en) || trim($title_en)==='')) {
      $r .= "(Add Title)\n";
    }
    $r .= "</td>\n</tr>\n";    
    return $r;
  }

?>
</table>
    </div>
	<?php include "$_SERVER[DOCUMENT_ROOT]/zh/common/footer.php"; ?>
  </div>
  <p>&nbsp;</p>
 <?php include "$_SERVER[DOCUMENT_ROOT]/common/bottom.php"; ?>
</body>
</html> 

