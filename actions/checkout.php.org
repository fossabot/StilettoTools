<?
/**
 * actions/cart.php
 * collects checkout data
 * Code and Markup Copyright (c) Montana Banana
 */

session_start();

# DB AND PAGE FUNCTIONS:
include("../inc/common.php");

$checkoutSteps = checkoutSteps();

if(isset($_POST['step'])){
	$step = $_POST['step'];
	$formData = $_POST;
	
} else if(isset($_GET['step'])){
	$step = $_GET['step'];
	$formData = $_GET;
}

foreach($checkoutSteps as $key => $val){
	if($step == $val){
		$nextStep = $checkoutSteps[$key+1];
	}
}

// form fields defined in inc/configuration.php
$formFields = array('shipping_address' 		=> array(SHIPPING, SHIPPING_REQUIRED),
					'shipping_method' 		=> array(METHOD, METHOD_REQUIRED),
					'billing_information'	=> array(BILLING, BILLING_REQUIRED)
					);

$errors = false;
if(isset($formFields[$step])){
	$fields = explode(",",$formFields[$step][0]);
	$required = explode(",",$formFields[$step][1]);
	
	// error check form
	foreach($fields as $key => $val){
		$value = trim($formData[$val]);
		$_SESSION['checkout'][$step][$val] = $value;
		
		if(in_array($val,$required) && $value == ""){
			$errors = true;
			
		} else if($val == 'email' && (trim($formData['confirm_email']) != $value || !validate_email($value))){
			$errors = true;
			
		} else if($val == 'expiration_date'){
			if($formData['expiration_month'] == "" || $formData['expiration_year'] == ""){
				$errors = true;
			
			} else {
				// concat fields into 'expiration_date'
				$_SESSION['checkout'][$step][$val] = $formData['expiration_month'].'/'.substr($formData['expiration_year'],2,2);
			}
			
		} else if($val == 'credit_card_number'){
			// validate credit card number
			if(!validateCreditCard($value)){
				$errors = true;
			}
		}
		
		if($val == 'credit_card_number'){
			$_SESSION['checkout'][$step][$val] = encryptMe($value);
		}
	}
}

// to complete checkout w/o fedex integration. REMOVE THIS BEFORE LAUNCH
if($step == 'shipping_method' && !isset($_POST['shippingId'])){
	$_SESSION['checkout'][$step]['shippingId'] = 0;
	$_SESSION['checkout'][$step]['method'] = 'Sample Method';
	$_SESSION['checkout'][$step]['price'] = 2.99;
	$errors = false;
}

if($errors){
	javascriptErrorMsg("Please fill in all required fields to continue.\\nRequired fields are marked with a *");
	exit;
}

## FORM LOOKS OK ##

if($step == 'order_confirmation'){
	// save the order, send emails, etc
	$receipt = receipt();
	$query = "INSERT INTO `orders` (`receipt`,`personalize`,`checkout`,`total`,`category`,`date`) VALUES('$receipt','".addslashes(serialize($_SESSION['personalize']))."','".addslashes(serialize($_SESSION['checkout']))."','".$_SESSION['checkout']['total']."','9','".date('Y-m-d')."')";
	if(!mysql_query($query)){
		javascriptErrorMsg("There was an unexpected error with your order. Please try again.");
		exit;
	}
	
	$orderId = mysql_insert_id();
	
	$subject = 'Order Confirmation: '.SITENAME;
	$customerName = f($_SESSION['checkout']['shipping_address']['first_name'].' '.$_SESSION['checkout']['shipping_address']['last_name']);
	$customerEmail = $_SESSION['checkout']['shipping_address']['email'];
	
	$orderDetail = personalizationOrderDetail($_SESSION['personalize'],$_SESSION['checkout'],false);
	
	// email to the customer:
	sendHTMLemail($customerEmail,$subject,emailToCustomer($orderDetail,$_SESSION['personalize']['type']),GENERALEMAIL,GENERALEMAILNAME);
	
	// email to the site admin:
	sendHTMLemail(GENERALEMAIL,$subject,emailToAdmin($orderDetail),$customerEmail,$customerName);
	
	session_destroy();
	
	header("Location: ../checkout_".$nextStep.".html?order=".$orderId);
	exit;
}


header("Location: ../checkout_".$nextStep.".html");
exit;


// construct emails to go to admin/customer, used on line 90 and 93 above
function emailToCustomer($orderDetail,$type){
	return getContent('emailToCustomer_'.$type,'return')."<p />".$orderDetail;
}

function emailToAdmin($orderDetail){
	return 'An order has been placed for Personalization. Please log in to view it <a href="http://www.stilettotools.com/mbcms/">here</a> [http://www.stilettotools.com/mbcms/]<p />'.$orderDetail;
}

?>