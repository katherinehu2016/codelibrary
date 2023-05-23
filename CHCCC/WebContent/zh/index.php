<!DOCTYPE HTML>
<html>

<head>
  <?php include '../common/head.php'; ?> 
  <link rel="Stylesheet" type="text/css" href="/css/smoothDivScroll.css" /> 
  <script>
function popitup(link) {
  var w = window.open(link.href,
        link.target||"_blank",
        'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=yes,dependent,width=600,height=850,left=0,top=0');
  return w?false:true; // allow the link to work if popup is blocked
 }
</script>
</head>

<body>
<?php include_once("../common/analyticstracking.php") ?>
  <div id="main"><?php include "./common/header.php"; ?>		

    <div id="site_content">
    	<!-- call image_roller -->		    
  		<?php include '../common/image_roller.php'; ?> 
      
      	<?php include '../common/content/home_content.php'; ?> 
    </div>
    
 	<?php include './common/footer.php'; ?>
  </div>
  <p>&nbsp;</p>
   <!-- javascript at the bottom for fast page loading -->
  <!-- <script type="text/javascript" src="/js/jquery.js"></script> -->
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>
   	<script src="/js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
	
	<!-- Latest version of jQuery Mouse Wheel by Brandon Aaron
		 You will find it here: http://brandonaaron.net/code/mousewheel/demos -->
	<script src="/js/jquery.mousewheel.min.js" type="text/javascript"></script>
	

	<!-- jQuery Kinetic - for touch -->
	<script src="/js/jquery.kinetic.js" type="text/javascript"></script>

	<!-- Smooth Div Scroll 1.3 minified -->
	<script src="/js/jquery.smoothdivscroll-1.3-min.js" type="text/javascript"></script>
  <script type="text/javascript" src="/js/jquery.easing-sooper.js"></script>
  <script type="text/javascript" src="/js/jquery.sooperfish.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
     $('ul.sf-menu').sooperfish();
      		$("#makeMeScrollable").smoothDivScroll({
				mousewheelScrolling: "allDirections",
				manualContinuousScrolling: true,
				autoScrollingMode: "onStart",
				autoScrollingInterval: 30
			});
		
    });
  </script>
  <script type="text/javascript" src="http://webplayer.yahooapis.com/player.js"></script>
</body>
</html>

