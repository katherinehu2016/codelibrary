<?php
	function url_exists($url){
		$file_headers=@get_headers($url);
		$result=true;
		if($file_headers[0]=='HTTP/1.1 404 Not Found'){
			$result=false;
		}
		return $result;
		
	}
?>