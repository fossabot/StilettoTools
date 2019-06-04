<?php

function showLinks($category) {

	if($category=="hammers") {
		$product[0] = "TBII-15 TiBone";
		$product[1] = "Mini-14 TiBone";
		$product[2] = "10oz Ti Finish";
		$product[3] = "12oz Ti Remodeler";
		$product[4] = "14oz Ti Titan";
		$product[5] = "16oz Ti \"MuscleHead\"";
		$product[6] = "Titanium TiBar 16";
		$product[7] = "Titanium TiBar 12";
		$product[8] = "Titanium Trim Bar";

	} else if ($category=="steelhammers") {
		$product[0] = "19oz Steel Renegade";
		$product[1] = "21oz Steel Renegade";
		$product[2] = "Lather's Axe";
		$product[3] = "Drywall Axe";

	} else if ($category=="specialty") {
		$product[0] = "AirGrip® Cold-Shrink Handle Wrap";
		$product[1] = "10oz Ti Drywall Hammer";
		$product[2] = "Ti Clawbar Nail Puller";
	} else if ($category=="replacement") {
		$product[0] = "TiBone Replacement Faces";
		$product[1] = "Hickory Replacement Handles";
	} else {
		echo "nothing";
	}
	$i=0;
	while ($i < count($product)) {	
		echo "<a href=\"http://store.stilettotools.com/Search.bok?keyword=$product[$i]\">$product[$i]</a><br/>";
		$i++;
	}
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Stiletto Tools</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/code.js" type="text/javascript"></script>

<style type="text/css">
<!--
.style1 {
	color: #CCCCCC;
	font-weight: bold;
	font-size: 14px;
}

#outerDiv 
{
	position: relative;	
	top:-100px;
	left:1px;	
}

-->
</style>

<script src="AC_RunActiveContent.js" language="javascript"></script>
<script src="swapper.js" language="javascript"></script>
<script language="JavaScript1.2" type="text/javascript" src="mm_css_menu.js"></script>
<style type="text/css" media="screen">
	@import url("./menu.css");
</style>
</head>

<body onLoad="MM_preloadImages('images/btn_home_ro.gif','images/btn_store_ro.gif','images/btn_crews_ro.gif','images/btn_whatsnew_ro.gif','images/btn_service_ro.gif','images/btn_distributors_ro.gif','images/btn_about_ro.gif')">
<div id="container"><div id="content"><div id="inner_content">
<div id="header"><?php include("header.htm"); ?></div>
<div id="topnav"><?php include("topnav.htm"); ?></div>




      <table width="914" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top" background="images/bg_hm_left_column.gif">
<div id="hm_column_left">
<script language="javascript">
	if (AC_FL_RunContent == 0) {
		alert("This page requires AC_RunActiveContent.js.");
	} else {
		AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0','width','561','height','269','id','tools','align','middle','src','tools','quality','high','wmode','transparent','bgcolor','#ffffff','name','tools','allowscriptaccess','sameDomain','allowfullscreen','false','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','tools' ); //end AC code
	}
</script>
<noscript>
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="561" height="269" id="tools" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="false" />
	<param name="movie" value="tools.swf" /><param name="quality" value="high" /><param name="wmode" value="transparent" /><param name="bgcolor" value="#ffffff" />	<embed src="tools.swf" quality="high" wmode="transparent" bgcolor="#ffffff" width="561" height="269" name="tools" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
</noscript>
</div>
<img src="images2/coming-soon.jpg" border="0" usemap="#Map">
		  <div id="hm_left_content_back">		
		  		<div id="hm_left_content">
		  	<?php include("cms/front.htm"); ?>
            </div></td>
          <td width="352" valign="top"><div id="hm_column_right">
          <div class="hm_feature_space"></div>
          	<a href="http://stilettotools.com/personalization.html"><img src="images/personalizeYourStilettoTool.jpg" alt="Personalize Your Stiletto Tool" border="0" /></a>
            <div class="hm_feature">
                <div class="hm_feature_pad" style="padding-top: 8px;">
                  <?php include("cms/box6.htm"); ?>
                </div>
		  	</div>
           
             <div class="hm_feature_space"></div>
		  	<div class="hm_feature">
                <div class="hm_feature_pad" style="padding-top: 8px;">
                  <?php include("cms/box5.htm"); ?>
                </div>
		  	</div>
            </div>
            <div class="hm_feature_space"></div>
		  	<div class="hm_feature">
                <div class="hm_feature_pad" style="padding-top: 10px;">
				<?php include("cms/box1.htm"); ?>
                </div>
            </div> 
                <div class="hm_feature_space"></div>
		  	        <div class="hm_feature">
                <div class="hm_feature_pad" style="padding-top: 10px;">
                <?php include("cms/box2.htm"); ?> 
                  </div>
                  </div>   
                  
                   <div class="hm_feature_space"></div>
		  	        <div class="hm_feature">
                <div class="hm_feature_pad" style="padding-top: 10px;">  	  

<?php include("cms/box3.htm"); ?>                   
                  </div>   
                  </div>
                  
                  <div class="hm_feature_space"></div>
		  	<div class="hm_feature">
                <div class="hm_feature_pad">
                 <?php include("cms/box4.htm"); ?>
                </div>
		  	</div></div>   
            </td>
  </tr>
</table>

    <div id="hm_content_bottom"><img src="images/hm_content_bottom.gif" width="914" height="3"></div>
</div><!--end inner content-->
</div><!--end content-->
	  <div id="footer"><?php include("footer.htm"); ?></div>
	  <div id="counter"><img src="http://www.elite.net/cgi-bin/counter?width=5&link=/martinezdomain/index.php&show=NO"></div>
</div><!--end container -->
<?php include("imagemap.htm"); ?>
<map name="mainImage">
  <area shape="rect" coords="272,94,325,145" href="http://store.stilettotools.com/Detail.bok?no=57" alt="Product 1">
  <area shape="rect" coords="331,94,384,144" href="http://store.stilettotools.com/Detail.bok?no=52" alt="Product 2">
  <area shape="rect" coords="389,94,442,144" href="http://store.stilettotools.com/Detail.bok?no=22" alt="Product 3">
  <area shape="rect" coords="447,94,500,145" href="http://store.stilettotools.com/Detail.bok?no=20" alt="Product 4">
</map>

<map name="Map">
  <area shape="rect" coords="31,31,533,255" href="coming-soon.php">
</map></body>
</html>
