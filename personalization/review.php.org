<?php

// flash text entry block
$flashVars = "goToFrame=preview";
$flashVars .= "&locationId=".$_SESSION['personalize']['location'];
$flashVars .= "&selectedMessage=".addslashes(str_replace('"','%22',str_replace("'",'%27',str_replace('&','%26',$_SESSION['personalize']['text_entry']['message']))));
$flashVars .= "&selectedFont=".$_SESSION['personalize']['text_entry']['font'];

// preview vars
$flashVars .= "&selectedFontName=".fullFontName($_SESSION['personalize']['text_entry']['font']);
$flashVars .= "&productTitle=".addslashes(str_replace('"','%22',str_replace("'",'%27',str_replace('&','%26',str_replace('&reg;','',str_replace('&trade;','',getField($_SESSION['personalize']['product']['productId'],'products','title')))))));

$productCost = getField($_SESSION['personalize']['product']['productOptionsId'],'product_options','price');
$flashVars .= "&productCost=".($productCost>0 ? '$'.$productCost:'0 (Existing Tool)');

$flashVars .= "&selectedLocation=".addslashes(getField($_SESSION['personalize']['location'],'locations','title'));
$flashVars .= "&personalizationCost=$".PERSONALIZATIONCOST;
$flashVars .= "&totalCost=$".number_format((PERSONALIZATIONCOST+$productCost),2);

echo 'Confirm your Personalization:<p />';
echo flash('personalization',796,392,'transparent',$flashVars,7);

?>