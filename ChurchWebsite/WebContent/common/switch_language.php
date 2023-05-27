<?php

/*
 * Created on Mar 9, 2013
 *
 * this method will take the $target which is the target language and return
 * the target url this is corresponding to the current url
 */
 function switchLanguage($target){	
	$uri=$_SERVER["REQUEST_URI"];
	$language="en";
	if(preg_match("/\/zh\//",$uri)){
		$language="zh";
	}
	
	if($target!=$language){
	
		$pattern="/\/".$language."\//";
		$replacement="/".$target."/";
		
		$targetUri=preg_replace("/\/".$language."\//","/".$target."/",$uri);
		return $targetUri;
	}else return $uri;
 
}

?>
