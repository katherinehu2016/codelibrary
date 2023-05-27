<html>
    <head>
	<title>Guests File Generation </title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1" >
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
	<script type="text/javascript">
	 //It'stupid to format date like this!
	 // message pdf file pattern is: 's'mmddyy.pdf;
	 // The file name  format of message audio is mmddyyyy.mp3,
	 // hymn audio file name pattern is 'm'mmddyy.mp3

	 // The welcome file ppt will be welcome-yyyy-mm-dd.pptx (ISO date format).
	 function getFileName(sdate, nameType){
	     var year4 = sdate.getFullYear();
	     var mon = sdate.getMonth() + 1; // Jan is 0!
	     var day = sdate.getDate();
	     mon = mon < 10 ? '0' + mon : mon;
	     day = day < 10 ? '0' + day : day ;
	     var fn;
	     switch( nameType ){
		 case "messagePdf":
		     fn = "s" + mon + day + year4.toString().substring(2) + ".pdf";
		     break;
		 case "messageAudioMp3":
		     fn = "" + mon + day + year4 + ".mp3";
		     break;
		 case "hymnAudioMp3":
		     fn = "m" + mon + day + year4.toString().substring(2) + ".mp3" ;
		     break;
		 case "welcomePptx":
		     fn = "welcome-" + year4 + "-" + mon + "-" + day + ".pptx";
		     break;
		     
	     }
	     return  fn ;
	 }

	</script>
	<style type="text/css">
	 div.header {
	     font-weight: bolder;
	     font-size: 20pt;
	 }
	 td.label {
	     font-size: 13pt;
	     text-align:right;
	     width: 20%;
	 }
	 td.space {
	     width:5%;
	 }
	 label {
	     width: 25%;
	     display: inline-block;
	     text-align: right;
	 }
	 .textBlock{
	     display: inline-block;
	 }
	 label+input, textarea{
	     width: 60%;
	     margin-left: 10px;
	 }
	 #downloadWelcome{
	     display: inline-block;
	 }
	 .downloadPrompt{
	     border: 1px solid black;
	     animation-name: alertUser;
	     animation-duration: 2s;
	     animation-direction: alternate;
	     animation-iteration-count: infinite;
	 }
	 @keyframes alertUser{
	     from {background-color: white;}
	     to { background-color: red;}
	 }
	 .mustFill>label::after {
	     content: "*";
	     color: red;
	 }
	 .mustFill > label {
	     font-weight: bold;
	 }
	 .workSection {
         font-size: 18px;
	     margin: auto;
	 }
     form > div {
         margin-top: 5px;
     }
     button, input {
         font-size: 18px;
     }
	</style>
    </head>
    <body>

	<div class="workSection" >
	    <h2> 在服务器创建迎接新人ppt文件</h2>
	    <div><p>按顺序输入新人名单， 每行会占用一页ppt. 然后按创建按钮，  其他同工在半分钟后就可以在网站下载生成的迎新文件。 </p>
		<p>每次按生成按钮都会覆盖以前生成的文件。</p>
		<p>超过20页可请同工在下载文件后直接打开再添加。</p>
	    </div>
	    <!-- ios safari do NOT support html FormData api. Use direct submit -->
	    <form action="ajaxFormHandler.php"  id="welcomeForm" name="welcomeForm" method="post" >
			<div><input type="reset" name="reset" value="清除输入框" /> <input type="submit" id="welcomeSubmit"  name="welcomeSubmit" value="在服务器创建迎新文件"  onclick="$('#welcomeFileName').attr('value',getFileName(new Date(),'welcomePptx')); return true;"/> </div>
			<input type="hidden" name="formType" value="welcomeForm" />
			<input type="hidden" id="welcomeFileName" name="welcomeFileName" value="" />
		<?php
		for($i = 1; $i <= 20 ; $i ++ ){
		    echo 	"<div><label >名字 页" .$i . '</label><input type="text" name="newGuests[]" /></div>';
		}
		?>
	
		<div><input type="reset" name="reset" value="清除输入框" /> <input type="submit" id="welcomeSubmit"  name="welcomeSubmit" value="在服务器创建迎新文件" onclick="$('#welcomeFileName').attr('value',getFileName(new Date(),'welcomePptx')); return true;" /></div>
	    </form>
	</div>

    </body>
</html>
