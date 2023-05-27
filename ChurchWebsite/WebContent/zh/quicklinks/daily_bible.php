<?php
	/*
	 * following code will try to redirect to the M-d.htm(Feb-08.htm) in http://cbible.net/bi/daily-bi/
	 * if the url exists, the redirect will be performed. otherwise the redirect 
	 * url is http://cbible.net/bi/daily-bi/daily-bi.htm
	 */
	$daily_bible_url="http://cbible.net/bi/daily-bi/";
	$today=date("M-d").".htm";
	$daily_bible_url=$daily_bible_url.$today;
	$file_headers = @get_headers($daily_bible_url);
	if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
	    $daily_bible_url = "http://cbible.net/bi/daily-bi/daily-bi.htm";
	}
	
	header("Location: $daily_bible_url");
	exit;
?>