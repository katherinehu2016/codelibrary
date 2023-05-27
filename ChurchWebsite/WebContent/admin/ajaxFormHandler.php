<?php

//include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php" ;
//require "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php" ;

function handleMessagePdfForm($isEN ){
    // Why can not pass include to the function scope?
    // TODO: db_conn.php variables should declared as 'global'.
    include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php";

    // allow en not to save pdf file.
    if(isset($_FILES) && sizeof($_FILES) == 1 )  {
	$file=$_FILES["messagePdfFile"];
	if(0< $file['error'] ){
	    echo 'Error:' . $file['error'] . '<br>' ;
	}else{
        $userSetName = $_POST["messagePdfFileName"];
	    move_uploaded_file($file['tmp_name'], $_SERVER["DOCUMENT_ROOT"] . ($isEN ? $pdf_library_en : $pdf_library) . basename( $userSetName ) );
	}
	//echo "file info:tmp_name:" . $file['tmp_name'] . $pdf_library . " :name:" . basename($file['name']);
	echo "Saved file OK";
    } else {
        echo " No pdf file field to save?";
    }
    
    $message_date = "";
$message_speaker = "";
$message_title = "";
$message_audioFileName = "";

$message_speaker_en = "";
$message_title_en = "";
$message_pdfFileName = "";
$message_videoFileName = "";

$message_published = "0";
$message_published_checked = "";

$message_isTraining = "0";
$message_isTraining_checked = ""; 

$bible_verse = "";
$bible_verse_en = "";


    // now insert record.
    	$message_date = $_POST["messageDate"];
	$message_speaker = $_POST["messageSpeaker"];
	$message_title = $_POST["messageTitle"];
	$message_audioFileName = $_POST["messageAudioFileName"];
	
	$message_speaker_en = $_POST["messageSpeakerEn"];
	$message_title_en = $_POST["messageTitleEn"];
	$message_pdfFileName = $_POST["messagePdfFileName"];
	$message_videoFileName = $_POST["messageVideoFileName"];
	
	$bible_verse = $_POST["bibleVerse"];
	$bible_verse_en = $_POST["bibleVerseEn"];
   
	if (isset($_POST['published']) ) {
		$message_published = "1";
	}	
	
	if (isset($_POST['isTraining']) ) {
		$message_isTraining = "1";
	}
	echo " no db?" . $db_host . $database . $username . $password ;
	$db = new PDO('mysql:host='.$db_host.';dbname='.$database,
    $username,
    $password,
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    // The en table ch_message_en missing following fields: is_training, speaker_en (changed to speaker_zh and not used),
    // , message_title_en (changed to message_title_zh, not used).
    if (!$isEN){
    
	$db->query("INSERT INTO ch_message " .
				"	(message_date, speaker, message_title, message_audio_File_Name, speaker_en, message_title_en, message_pdf_file_name, message_video_file_name, bible_verses, bible_verses_en,published, is_training) " .
				"	VALUES " .
				"	('$message_date', '$message_speaker', '$message_title', '$message_audioFileName', '$message_speaker_en', '$message_title_en', '$message_pdfFileName', '$message_videoFileName', " .
				"	'$bible_verse', '$bible_verse_en',$message_published, $message_isTraining)");	
				
    echo "创建成功:" ;
    }else { // English table service.
        $insertResult=	$db->query("INSERT INTO ch_message_en " .
				"	(message_date, speaker, message_title, message_audio_File_Name,  message_pdf_file_name, message_video_file_name, bible_verses, published) " .
				"	VALUES " .
				"	('$message_date', '$message_speaker', '$message_title', '$message_audioFileName', '$message_pdfFileName', '$message_videoFileName', " .
				"	'$bible_verse' ,$message_published)");	
				
        if ($insertResult) {
            echo "创建成功(English):" ;
        }else {
            echo "failed en insert:" . $db -> errorInfo() ;
            var_dump( $db -> errorInfo() );
        }
    }


}

// This may called from mobile webkit and jump to another page,
// use mobile friendly html for output.
function handleWelcomeForm(){
    include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php";
    // echo json_encode($_POST["newGuests"]);
    // The basic idea is to copy the .pptx (zipped xml files, has fixed number of slide pages) template
    // to the new location with a random name, replace the existing string with
    // the passed guest name for each slide xml file. At last change name to
    // predefined pptx name for download.
    // admin page should check  it peridically to update UI for downloading.
    $welcomeFileName = $_POST["welcomeFileName"];
    
    $pptxTemplate= "welcomeTemplate.pptx" ;// in the same dir as this file.
    $tmpZip = tempnam($_SERVER["DOCUMENT_ROOT"] . $pdf_library , "wel");
    $newNamePptx = $_SERVER["DOCUMENT_ROOT"] . $pdf_library . $welcomeFileName ;
    
    
    if( !copy($pptxTemplate, $tmpZip) ){
	echo "Can not copy file:" . $pptxTemplate . " to:" . $tmpZip ;
	return;
    }
    // slides are single xml files named by  "ppt/slides/slide{pageNumber}.xml
    // slide1.xml will always be empty as the title page.
    // start from slide2.xml; "......"
    $predefinedPages = 20 ; // only support 20 slides.
    $needReplaced = "......" ; // we use that to hold the place in each page.
    //clean guests list.
    $guests=array();
    foreach($_POST["newGuests"] as $guestInput){
	$kk = trim($guestInput);
	if (strlen($kk) > 0 ){
	    array_push($guests, $kk);
	}
    }
    if(sizeof($guests) == 0 ){
	echo "no guests input, NOT write to file!";
	unlink($tmpZip);
	return ;
    }
    echo '<html><head><meta http-equiv="content-type" content="text/html; charset=UTF-8" ><meta name="viewport" content="width=device-width, initial-scale=1" ><style type="text/css"> button {font-size: 24px;}</style></head><body><h2>Guest file generation</h2> ';
    echo "<p> process guests ...</p>";
    
    $zip = new ZipArchive;
    if ( $zip -> open($tmpZip) === TRUE ){
	$i = 2 ;
	foreach($guests as $guestName ){
	    $zipEntryName= "ppt/slides/slide" . $i . ".xml" ;
	    $oldXml = $zip -> getFromName($zipEntryName);
	    if($oldXml){
		$newXml = str_replace($needReplaced, $guestName, $oldXml);
		$zip->deleteName($zipEntryName);
		$zip->addFromString($zipEntryName, $newXml);
		echo "<p> ". $zipEntryName . " => " . $guestName . "</p>";
	    }
	    
	    $i ++ ;
	}
	$zip -> close();
	rename($tmpZip, $newNamePptx);
    }
    echo "Zip to: " . $welcomeFileName ;
    echo "<p>处理完毕，服务器迎新ppt文件已写好。 Done output file! </p>";
    echo "<p>请点击按钮返回迎新名单输入界面。</p>";
    echo "<button onclick='window.history.back()' >返回 back</back>";
    echo "</body></html>";
}
function handleCheckWelcomeFile(){
     include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php";
   // echo "fn:" . $_POST["welcomeFileName"] . " is what?" ;
    $newPptx = $_SERVER["DOCUMENT_ROOT"] . $pdf_library .  $_POST["welcomeFileName"];
    // check the existance of file and return creation time for refresh.
    
    if ( file_exists($newPptx ) ){
	echo json_encode(array('mtime' => filemtime($newPptx) , 'href' => $pdf_library .  $_POST["welcomeFileName"]) );
    }else{
	echo json_encode(array('fileExists' => FALSE, 'fileName' => $_POST["welcomeFileName"] ));
    }
}

// Only handle insert record of 诗歌
function handleHymnForm(){
    include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php";
    
    //create record and save the pdf file uploaded.
  $music_date = "";
$music_title = "";
$music_audioFileName = "";
$music_published = "0";

    $music_date = $_POST["musicDate"];
    $music_title = $_POST["musicTitle"];
	$music_audioFileName = $_POST["musicAudioFileName"];
    if (isset($_POST['musicPublished'])) {
		$music_published = "1";
	}	

    if(isset($_FILES) && sizeof($_FILES) == 1 )  {
	$file=$_FILES["musicAudioMp3File"];
	if(0< $file['error'] ){
	    echo 'Error:' . $file['error'] . '<br>' ;
	}else{
        $userSetFileName = 	$music_audioFileName;
	    move_uploaded_file($file['tmp_name'], $_SERVER["DOCUMENT_ROOT"] .  $pdf_library . "../". basename( $userSetFileName	) );
	}


  	$db = new PDO('mysql:host='.$db_host.';dbname='.$database,
    $username,
    $password,
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    $db->query("INSERT INTO ch_music " .
				"	(music_date, music_name, music_audio_file_name, published) " .
				"	VALUES " .
				"	('$music_date', '$music_title', '$music_audioFileName', $music_published)");	
				
    echo "创建成功";
    }else {
        echo 'Error:' . " no uploaded file found!" ;
    }
}

function handleAudioMessageForm( $fileName, $isEN){
     include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php";

     if(!isset($fileName)){
         $fileName = $_POST["messageAudioFileName"];
     }

       if(isset($_FILES) && sizeof($_FILES) == 1 )  {

	        $file=$_FILES["messageAudioFile"];
    
	        if(0< $file['error'] ){
	            echo 'handle AudioMessageForm post file handling Error:' . $file['error'] . '<br>' ;
	        }else{
                $userSetFileName = $_POST["messageAudioFileName"];
                move_uploaded_file($file['tmp_name'], $_SERVER["DOCUMENT_ROOT"] . ($isEN? $pdf_library_en : $pdf_library) . "../". basename($userSetFileName) );
                echo " moved uploaded  file to:" . $userSetFileName ;
	        }
       }else {
        echo " ~~~~~~~~~~~~~~~~ handleAudioMessage Form! passed fileName:" . $fileName;
        //var_dump($_POST);
        // When we run into this part, we have list of file names that should merge into new file.
        //array(3) { ["formType"]=> string(16) "messageAudioForm" ["messageAudioFileName"]=> string(21) "sermon-2019-04-30.mp3" 
         //   ["messageAudioFile"]=> string(120) "["chunk-qynp8z-0","chunk-qynp8z-1","chunk-qynp8z-2",
         //"chunk-qynp8z-3","chunk-qynp8z-4","chunk-qynp8z-5","chunk-qynp8z-6"]" }

         // Yahoo json library can NOT decode simple stringified array!
        //  $chunkString = $_POST["messageAudioFile"];
        //  echo "-- $chunkString -";
        //  var_dump($chunkString);
        //  echo "-----end ---";
        // $chunkNameArray = json_decode( $_POST["messageAudioFile"]);
        // echo "is array?" . is_array($chunkNameArray);

        $chunkNameArray = $_POST["messageAudioFile"];

        var_dump($chunkNameArray);

        $saveTo = fopen($_SERVER["DOCUMENT_ROOT"] . ($isEN? $pdf_library_en :  $pdf_library ) . "../". basename($fileName), "w" );
        foreach ($chunkNameArray as $sub) {
            $subName = $_SERVER["DOCUMENT_ROOT"] . ($isEN? $pdf_library_en :  $pdf_library ) . "../". basename($sub);
            $subStream = fopen($subName, 'r');
            $copiedBytes = stream_copy_to_stream($subStream, $saveTo);
            echo " -------       copied " . $copiedBytes . " bytes from ". $sub . " to " . $fileName ;
            fclose($subStream);
            // Delete the already copied file.
            unlink($subName);
        }
        fclose($saveTo);
        // use stream interface to save the file.
        //$streamFile = fopen("php://input", 'rb'); //manual not mention 'b' flag.
        // php://input got big memory problem. Try to split and merge file option. 
        // test merge with multiple files.
        // $saveTo = fopen($_SERVER["DOCUMENT_ROOT"] . ($isEN? $pdf_library_en :  $pdf_library ) . "../". basename($fileName), 'w');
        // $subFiles = array("sermon-2019-03-24.mp3", "sermon-2019-03-31.mp3", "sermon-2019-04-07.mp3");
        // foreach ($subFiles as $sub){
        //     $subStream = fopen($_SERVER["DOCUMENT_ROOT"] . ($isEN? $pdf_library_en :  $pdf_library ) . "../". basename($sub), 'r');
        //     $copiedBytes = stream_copy_to_stream($subStream, $saveTo);
        //     echo "copied " . $copiedBytes . " bytes from ". $sub . " to " . $fileName ;
        //     fclose($subStream);
        // }
        // fclose($saveTo);
        echo " merge copy done!";
        //var_dump($_POST);

    // stream open php://input only works for 2 weeks.  It seems that system will load php://input into memory as one giant chunk and exhaust memory.
    //      $streamFile = fopen("php://input", 'r');
    //     //$saveTo = fopen($_SERVER["DOCUMENT_ROOT"] . ($isEN? $pdf_library_en :  $pdf_library ) . "../". basename($fileName), 'wb');
    //     $saveTo = fopen($_SERVER["DOCUMENT_ROOT"] . ($isEN? $pdf_library_en :  $pdf_library ) . "../". basename($fileName), 'w');

    // It's no use to set the buffer.
    //     stream_set_read_buffer($streamFile, 4096);
    //     stream_set_write_buffer($saveTo, 4096);

    //     stream_copy_to_stream($streamFile, $saveTo);
    //     // It seems that yahoo put a new limit for stream copy. try another way.
    //     // Or it caused by stream buffer too big?

    // Use directly open file and write to stream got the same problem.
    //  /*    while( !feof($streamFile)){
    //         fwrite( $saveTo, fread($streamFile, 1*1024*1024));// each time read 1m.
    //         echo "write 1m chunk!" ;
    //     } */
        
    //     fclose($streamFile);
    //     fclose($saveTo);
    //     echo "----stream_copy_to_stream handle file:" . $fileName;

    
       }
}
function handleChunkPost( $isEN){
    include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php";
    //echo "!!!!! dump $_POST" . sizeof($_FILES) . " <- file ";
    // array(2) { ["saveName"]=> string(14) "chunk-qynp8z-2" ["formType"]=> string(13) "chunkPostForm" }
    if(isset($_FILES) && sizeof($_FILES) == 1){
        $file=$_FILES["fileData"];
        if(0< $file['error'] ){
	    echo 'handle chunkPost  handling Error:' . $file['error'] . '<br>' ;
	}else{
        $userSetFileName = $_POST["saveName"];
        $fullPath = $_SERVER["DOCUMENT_ROOT"] . ($isEN? $pdf_library_en : $pdf_library) . "../". basename($userSetFileName) ;
        move_uploaded_file($file['tmp_name'], $fullPath );
        echo " moved upload chunk  to:" . $fullPath ;
	}
    }else{
        echo "no file uploaded for chunk Post ??";
        var_dump($_POST);
    }
    
    
}
function handleDeleteTodayForm($isEN){
    include "$_SERVER[DOCUMENT_ROOT]/common/db_conn.php";
    $sdate = $_POST["todayDate"];
    $use_pdf_library = $isEN ? $pdf_library_en : $pdf_library ;
    $hymnMp3 =$_SERVER["DOCUMENT_ROOT"] . $use_pdf_library . "../". $_POST["hymnMp3"];
    $messagePdf = $_SERVER["DOCUMENT_ROOT"] . $use_pdf_library . $_POST["messagePdf"];
    $messageMp3 =$_SERVER["DOCUMENT_ROOT"] . $use_pdf_library . "../".  $_POST["messageMp3"];
    $welcomeFile =$_SERVER["DOCUMENT_ROOT"] . $use_pdf_library . $_POST["welcomeFile"];
    foreach(array( $hymnMp3 ,$messagePdf, $messageMp3,$welcomeFile) as $nfile){
        echo $nfile . ": " . (file_exists($nfile) ? "✓" : "✘"), "<br/>";
    }
    echo "get delete values:" . json_encode($_POST);

    mysql_connect($db_host,$username,$password);
    @mysql_select_db($database) or die( "Unable to select database");
    mysql_query ('SET NAMES utf8');

    $message_query="SELECT * FROM ". ($isEN ? "ch_message_en " : "ch_message ") . " where message_date = '$sdate' ";
    $message_result=mysql_query($message_query);

    $message_num=mysql_numrows($message_result);
    echo " query message of $sdate has $message_num records. ", "<br/>";

    // no music for en right now.
    if(!$isEN){
        $hymn_query="SELECT * FROM ch_music where music_date = '$sdate' ";
    $hymn_result=mysql_query($hymn_query);
    $hymn_num=mysql_numrows($hymn_result);
    echo " query hymn has $hymn_num records. ", "<br/>";

    if ( isset($_POST["reallyDelete"]) && $_POST["reallyDelete"] == "on" ){
    $hymn_delete="delete FROM ch_music where music_date = '$sdate' ";
	mysql_query($hymn_delete);
	$numDeleteHymn = mysql_affected_rows();
	echo "hymn deleted $numDeleteHymn rows for $sdate ", "<br/>";
    }
    }
    
    if ( isset($_POST["reallyDelete"]) && $_POST["reallyDelete"] == "on" ){
	
        $message_delete ="delete FROM ". ($isEN? "ch_message_en" : "ch_message ") . " where message_date = '$sdate' ";
	mysql_query($message_delete);
	$numDeleteMessage = mysql_affected_rows();

	echo " message deleted $numDeleteMessage rows for $sdate ", "<br/>";
	foreach(array( $hymnMp3 ,$messagePdf, $messageMp3,$welcomeFile) as $nfile){
	    if (file_exists($nfile) ){
		unlink($nfile);
		echo $nfile . " deleted !", "<br/>" ;
	    }
	}
	
    }
    echo "------------- Done check/delete operation --------------";
    mysql_close();
}
$formType = $_POST["formType"];
if ( !isset($formType)){
    $formType = $_SERVER["HTTP_". "MYFORMTYPE"];
}

switch($formType){
    case "messagePdfForm":
	handleMessagePdfForm(FALSE);
	break;
    case "ENMessagePdfForm":
	handleMessagePdfForm(TRUE);
	break;
    case "welcomeForm":
	handleWelcomeForm();
	break;
    case "checkWelcomeFile":
	handleCheckWelcomeFile();
	break;
    case "hymnForm":
	handleHymnForm();
	break;
    case "messageAudioForm":
        handleAudioMessageForm($_SERVER["HTTP_" . "MYSAVEFILENAME"], FALSE);
    break;
    case "ENMessageAudioForm":
        handleAudioMessageForm($_SERVER["HTTP_" . "MYSAVEFILENAME"], TRUE);
    break;
    // TODO: handle English one at different .
    case "chunkPostForm":
        handleChunkPost(FALSE);
    break;
    case "ENChunkPostForm":
          handleChunkPost(TRUE);
    break;
case "deleteTodayForm":
    handleDeleteTodayForm(FALSE);//may only check info.
    break;
case "ENDeleteTodayForm":
    handleDeleteTodayForm(TRUE);//may only check info.
    break;
    
    default:
    echo $formType . " :Don't call it directly, use it as ajax form handler." . $_POST["saveFileName"] . " :req:" . $_REQUEST["saveFileName"];
    var_dump($_SERVER);
    echo "dump ---------- $_POST:";
    var_dump($_POST);
    echo "dump ############## $_REQUEST";
    var_dump($_REQUEST);
	
};


?>
 
