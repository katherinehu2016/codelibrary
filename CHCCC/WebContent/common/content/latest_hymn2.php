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

  $dt_show = strtotime('-31 days');
  
  $h1 = get_choir_files($choir_dir);
  $h2 = get_choir_file2($csm_dir);
  $sql = new Sql();
  $h3 = $sql->get_music('ch_music','published in (0,1)', 'music_date desc',
        $database, $db_host,$username,$password);

  //echo "<pre>H1\n";  print_r($h1);  echo "</pre>\n";
  //echo "<pre>H2\n";  print_r($h2);  echo "</pre>\n";
  //echo "<pre>H3\n";  print_r($h3);  echo "</pre>\n";

  $hm = array();
  foreach ($h1 as $y4=>$a1) {
    if (!array_key_exists($y4, $hm)) { $hm[$y4] = array(); }
    foreach ($a1 as $ymd=>$fn) {
      if (!array_key_exists($ymd, $hm[$y4])) {
        $hm[$y4][$ymd] = array();
      }
      $hm[$y4][$ymd]['file'] = $fn;
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
    foreach ($a1 as $ymd=>$fn) {
      if (array_key_exists($y4, $h1) && array_key_exists($ymd, $h1[$y4])) { continue; }
      $hm[$y4][$ymd]['file'] = array();
      $hm[$y4][$ymd]['fn2'] = $h2[$y4][$ymd];
      if (array_key_exists($y4, $h3) && array_key_exists($ymd, $h3[$y4])) {
        $hm[$y4][$ymd]['title_cn'] = $h3[$y4][$ymd]['title_cn'];
        $hm[$y4][$ymd]['title_en'] = $h3[$y4][$ymd]['title_en'];
      }
    }
  }

  //echo "<pre>\n";  print_r($_SERVER);  echo "</pre>\n";

  $language = LanguageUtil::getCurrentLanguage();
  krsort($hm);
  // echo "<pre>\n";  print_r($hm); echo "</pre>\n";
  foreach ($hm as $y4=>$a1) {
    ksort($a1);
    // echo "<tr><td colspan=2 style='background-color:#00FF00'>$y4</td></tr>\n";
    foreach ($a1 as $ymd=>$a2) {
      $title_cn = (array_key_exists('title_cn', $a2)) ? $a2['title_cn'] : '';
      $title_en = (array_key_exists('title_en', $a2)) ? $a2['title_en'] : '';
      $dt = substr($ymd,0,4) . '-' . substr($ymd,4,2) . '-' . substr($ymd, 6,2);
      $dt2 = mktime(0,0,0,substr($ymd,4,2), substr($ymd, 6,2), $y4); 
      if ($dt2 < $dt_show) { continue; }
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
    $fn = $ar[$k][0];
    $cn = (!isset($title_cn) || trim($title_cn)==='') ? substr($fn,6) : $title_cn;
    $en = (!isset($title_en) || trim($title_en)==='') ? substr($fn,6) : $title_en;
    $tit = ($language == 'en') ? $cn : $en;
    $txt = ($language == 'en') ? $en : $cn;
    $fmt = "<tr><td>%s</td>\n     <td><a href='%s' title='%s' target=_blank>%s</a></td>\n</tr>\n" ;
    $ftr = "<tr><td>%s</td>\n     <td>%s</td>\n</tr>\n" ;
    $f_a = "<a href='%s' title='%s' target=_blank>%s</a>";
    $r = '';
    if ($n == 1) {
      if ($k == 'file' && array_key_exists('fn2', $ar)) {
        $t = sprintf($f_a, "$url/$fn", $tit, $txt);
        foreach ($ar['fn2'] as $i=>$fn) {
          if ($i > 0) { $t .= ","; }
          $t .= '|' . sprintf($f_a, "$csm_url/$fn", $tit, "D:$txt");
        }
        $r .= sprintf($ftr, $dt, $t);
      } else {
        $r .= sprintf($fmt, $dt, "$url/$fn", $tit, $txt);
      }
    } else {
      $r .= "<tr><td>$dt</td>\n    <td>$cn [";
      foreach ($ar[$k] as $i=>$fn) {
        // yyyy/myyyymmdd.[mp3|wma]  m{mm}{dd}{yy}.[mp3|wma]
        $ext = ($k == 'file') ? substr($fn,15,3) : substr($fn,8,3);
        $tit = (!isset($en) || trim($en)==='') ? $en : $fn;
        if ($i > 0) { $r .= ","; }
        $r .= "<a href='$url/$fn' title='$tit:$txt' target=_blank>$ext</a>" ;
      }
      if ($k == 'file' && array_key_exists('fn2', $ar)) {
        //$t = '|' . sprintf($f_a, "$url/$fn", $tit, $txt);
        $t = '';
        foreach ($ar['fn2'] as $i=>$fn) {
          if ($i > 0) { $t .= ","; }
          $t .= '|' . sprintf($f_a, "$csm_url/$fn", $tit, "D:$txt");
        }
        $r .= $t;
      }
      $r .= "]</td></tr>\n";
    }
    return $r;
  }

?>
</table>

<div id="more_msg" style="margin-top: -20px;margin-bottom: 20px;">
<?php 
  $language = LanguageUtil::getCurrentLanguage();
  if ($language == 'en') {
    echo "<a href='/common/content/list_all_hymns.php' title='更多诗歌'>More</a>\n";
  } else {
    echo "<a href='/common/content/list_all_hymns.php' title='More Hymns'>更多诗歌</a>\n";
  }
?>
</div>

