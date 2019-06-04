<?
/**
 * actions/personalize.php
 * collects personalization options
 * Code and Markup Copyright (c) Montana Banana
 */

session_start();

# DB AND PAGE FUNCTIONS:
include("../inc/common.php");


if(isset($_GET['step']) && $_GET['step'] == 1){
	// start, or reset a personalization
	if(isset($_SESSION['personalize'])){
		unset($_SESSION['personalize']);
	}
	
	$_SESSION['personalize'] = array();
	$_SESSION['personalize']['type'] = $_GET['type'];
	$_SESSION['personalize']['price'] = PERSONALIZATIONCOST;
	
	$nextStep = "disclaimer";
	
} else if(isset($_POST['step']) && $_POST['step'] == 2){
	// agreed to the disclaimer
	$_SESSION['personalize']['agree'] = $_POST['agree'];
	$nextStep = "tool_selection";
	
} else if(isset($_POST['step']) && $_POST['step'] == 3){
	// selected product/product_option id
	$_SESSION['personalize']['product'] = array('productId'			=> $_POST['productId'],
												'productOptionsId'	=> $_POST['productOptionsId'],
												'price'				=> getField($_POST['productOptionsId'],'product_options','price')
												);
	$nextStep = "location_selection";
	
	// auto-select and skip next step if there's only one available locations
	$locations = getField($_POST['productOptionsId'],'product_options','locations');
	$locationIds = explode(",",$locations);
	foreach($locationIds as $key => $val){
		if(trim($val) == ''){
			unset($locationIds[$key]);
		}
	}
	
	if(count($locationIds) == 1){
		$_SESSION['personalize']['location'] = $locationIds[0];
		$nextStep = "text_entry";
	}
	
} else if(isset($_POST['step']) && $_POST['step'] == 4){
	// location on product
	$_SESSION['personalize']['location'] = $_POST['locationId'];
	$nextStep = "text_entry";
	
} else if(isset($_POST['step']) && $_POST['step'] == 5){
	// from Flash, personalized message data
	$_SESSION['personalize']['text_entry'] = array(	'message'	=> $_POST['message'],
													'font'		=> $_POST['font'],
													'size'		=> $_POST['size']
													);
	$nextStep = "text_entry";
	
	echo '&nextStep='.$nextStep;
	exit;
}


header("Location: ../personalize_".$nextStep.".html");
exit;
	
?>