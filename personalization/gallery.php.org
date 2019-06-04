Personalized Stiletto Tool Examples:<p />
<?php

define('SHOWPOPUP', true);

$q = mysql_query("SELECT * FROM `gallery` WHERE `active`='0' ORDER BY `precedence` ASC");
if(mysql_num_rows($q) > 0){
	echo '<div class="gallery"><table width="100%" cellspacing="0" cellpadding="0">';
	
	$n=0; 
	$columns=3;
	while($qd = mysql_fetch_assoc($q)){
		$img = 'uploads/gallery/gallery_'.$qd['id'].'_image.jpg';
		if(file_exists($img)){
			$popup = str_replace("_image","_popup",$img);
			if($n == 0){
				echo '<tr>';
			}
			
			echo '<td>';
			if(SHOWPOPUP) echo '<a href="javascript:launchwin(\''.$popup.'\',\'popup\',\'width='.CATALOG_POPUPWIDTH.',height='.CATALOG_POPUPHEIGHT.',scrollbars=no\');">';
			echo '<img src="'.$img.'" alt="'.f($qd['title']).'" width="223" height="168" />';
			if(SHOWPOPUP) echo '</a>';
			echo '</td>';
			
			$n+=1;
			if($n == $columns){
				echo '</tr>';
				$n=0;
			}
		}
	}
		
	echo '</table></div>';
}

if(isset($_GET['previousPage'])){
	echo '<div class="continueButton" id="continueButton">
			<a href="'.$_GET['previousPage'].'.html"><img src="images/buttons/back_ini.gif" alt="Back" onmouseover="this.src=\'images/buttons/back_ro.gif\';" onmouseout="this.src=\'images/buttons/back_ini.gif\';" /></a>
		 </div>';
}

?>