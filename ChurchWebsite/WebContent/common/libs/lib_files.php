<?php

function get_choir_files ($dir) {
  // $dir - directory
  //
  // $dir/yyyy/myyyymmdd.[mp3|wma]
  // 
  $hm = array();
  if ($handle = opendir($dir)) {
    while (false !== ($y4 = readdir($handle))) {
      if ($y4 == "." || $y4 == "..") { continue; }
      $hm[$y4] = array();
      if ($h2 = opendir("$dir/$y4")) {
        while (false !== ($fn = readdir($h2))) {          
          // file name format: myyyymmdd.[mp3|wma]  
          if ($fn == "." || $fn == "..") { continue; }
          $ymd = substr($fn, 1, 8);
          $ext = substr($fn,10, 3);
          if (!array_key_exists($ymd, $hm[$y4])) {
            $hm[$y4][$ymd] = array();
          }
          array_push($hm[$y4][$ymd], "$y4/$fn");              
        }
        closedir($h2);
      }     
    }
    closedir($handle);
  }
  return $hm;
} 


function get_choir_file2 ($dir) {
  // $dir - directory
  // $dir/m{mm}{dd}{yy}.[mp3|wma]
  $hm = array();
  if ($handle = opendir($dir)) {
    while (false !== ($fn = readdir($handle))) {
      if ($fn == "." || $fn == "..") { continue; }
      if (substr($fn, 0, 1) !== 'm') { continue; }
      
      $y4  = '20' . substr($fn, 5, 2);
      $ymd = $y4 . substr($fn, 1, 4);
      if (! array_key_exists($y4, $hm)) {
        $hm[$y4] = array();
      }
      if (! array_key_exists($ymd, $hm[$y4])) {
        $hm[$y4][$ymd] = array();
      }
      array_push($hm[$y4][$ymd], "$fn");              
    }
    closedir($handle);
  }
  return $hm;
} 

function file_mgr ($fn, $dir_k, $dir_d, $type) {
  // $fn    - file name
  // $dir_k - directory where files will be kept
  // $dir_d - directory where files will be deleted
   
  if (empty($fn))    { $fn = htmlspecialchars($_GET["file_name"]); }
  if (empty($fn))    { return "Nothing to be deleted."; }
  if (empty($type))  { $type = htmlspecialchars($_GET["act_type"]); } 
  if (empty($type))  { $type = "music"; } 

  switch (strtolower($type)) {
    case "music": 
      $dir = 'Choir';
      // m{mm}{dd}{yy}.[mp3|wma]
      $y4  = '20' . substr($fn, 5, 2);
      $ymd = $y4 . substr($fn, 1, 4);
      $ext = substr($fn, 8); 
      $f2  = "m$ymd.$ext";
      break; 
    case "message": 
      $dir = 'Message'; 
      //    {mm}{dd}{yy}.[mp3|wma]
      $y4  = '20' . substr($fn, 4, 2);
      $ymd = $y4 . substr($fn, 0, 4);
      $ext = substr($fn, 7);
      $f2  = "$ymd.$ext";
      break;
    default: 
      $dir = 'Message'; 
      //yyyy/{yyyy}{mm}{dd}.[mp3|wma]
      $y4  = substr($fn, 0, 4);
      $ymd = substr($fn, 5, 8);
      $ext = substr($fn, 14);
      $f2  = "$ymd.$ext";
  }
  if (empty($f2)) { return "No file name is composed.";  }
   
  if (empty($dir_k)) { $dir_k="$_SERVER[DOCUMENT_ROOT]$dir"; }
  if (empty($dir_d)) { $dir_d="$_SERVER[DOCUMENT_ROOT]ChineseSundayMessage"; }
  $kdir = "$dir_k/$y4";
  if (!file_exists($kdir)) { mkdir($kdir, 0777, true); } 
  $fk  = "$kdir/$f2";
  $fd  = "$dir_d/$fn";
  $msg = $fd; 
  if (! file_exists($fd)) {
    $msg .= " does not exist.";
    if (file_exists($fk)) { $msg .= " $fk exists."; 
    } else { $msg .= " $fk does not exists."; }
  } elseif (! file_exists($fk)) {
    copy($fd, $fk);
    if (file_exists($fk)) { unlink($fd);  
      $msg .= " is deleted since it is copied to $fk.";
    } else {
      $msg .= " can not be deleted since $fk does not exists."; 
    } 
  } elseif (file_exists($fd)) {
    if (file_exists($fk)) { unlink($fd);
      $msg .= " is deleted since $fk exists."; 
    } else {
      $msg .= " can not be deleted since $fk does not exists."; 
    } 
  } else { 
    $msg = "$fk exists."; 
  }
  return $msg;
} 

?>
 