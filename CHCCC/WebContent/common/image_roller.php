<?php
$cachefile = "$_SERVER[DOCUMENT_ROOT]/common/content/roller.html";

$cachetime = 5 * 60; // 5 minutes

// Serve from the cache if it is younger than $cachetime

if (file_exists($cachefile) && (time() - $cachetime < filemtime($cachefile))) {

	include ($cachefile);

	echo "<!-- Cached " . date('jS F Y H:i', filemtime($cachefile)) . " 
		         -->";

} else {
	
	
	ob_start();
	
	include ('SimpleImage.php');
	$height = 280;
	if ($handle = opendir("$_SERVER[DOCUMENT_ROOT]/images/roller/")) {
		echo "<div id='makeMeScrollable'>";
	
		/* This is the correct way to loop over the directory. */
		while (false !== ($entry = readdir($handle))) {
			if ("." == $entry || ".." == $entry)
				continue;
			echo "<img src='/images/roller/$entry' />";
			$image_info = getimagesize("$_SERVER[DOCUMENT_ROOT]/images/roller/$entry");
			if ($image_info[1] > $height) {
				$image = new SimpleImage();
				$image->load("$_SERVER[DOCUMENT_ROOT]/images/roller/$entry");
				$image->resizeToHeight($height);
				$image->save("$_SERVER[DOCUMENT_ROOT]/images/roller/$entry");
			}
		}
	
		echo "</div>";
		closedir($handle);
	
	}
	
		// open the cache file "cache/home.html" for writing
	$fp = fopen($cachefile, 'w');
	// save the contents of output buffer to the file
	fwrite($fp, ob_get_contents());
	// close the file
	fclose($fp);
	// Send the output to the browser
	ob_end_flush();
}



function resize($filename) {

}
?>

