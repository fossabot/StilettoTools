<?php

// flash text entry block
$flashVars = "goToFrame=text_entry";
$flashVars .= "&locationId=".$_SESSION['personalize']['location'];
if(isset($_SESSION['personalize']['text_entry'])){
	$flashVars .= "&selectedMessage=".addslashes($_SESSION['personalize']['text_entry']['message']);
	$flashVars .= "&selectedFont=".$_SESSION['personalize']['text_entry']['font'];
} else {
	$flashVars .= "&selectedMessage=";
	$flashVars .= "&selectedFont=tahoma";
}

echo 'Choose your personalized message and type face:<p />';
echo flash('personalization',796,392,'transparent',$flashVars,7);

?>