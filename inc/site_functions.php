<?php
/**
 * inc/site_functions.php
 * functions used in this specific site ONLY. site_functions.php is already included in all MB:CMS, front-end and action/ pages.
 * Code and Markup Copyright (c) Montana Banana
 */

function personalizeBreadCrumb($sessionData=0){
	$breadCrumb = '';
	if(isset($sessionData['type'])){
		$breadCrumb = 'Checkout: Personalizing ';
		if(isset($sessionData['location'])){
			$breadCrumb .= '<a href="personalize_location_selection.html">'.getField($sessionData['location'],'locations','title').'</a> of ';
		}
		$breadCrumb .= 'a'.($sessionData['type']=='existing' ? 'n':'').' <a href="personalize_introduction.html">'.ucwords($sessionData['type']).'</a> ';
		if(isset($sessionData['product']['productId'])){
			$breadCrumb .= '<a href="personalize_tool_selection.html?productId='.$sessionData['product']['productId'].'">'.getField($sessionData['product']['productId'],'products','title').'</a> ';
		} else {
			$breadCrumb .= 'Tool';
		}
	}
	
	return $breadCrumb;
}

function checkoutSteps(){
	$checkoutSteps = array(	1 	=> 'shipping_address',
						2	=> 'shipping_method',
						3	=> 'billing_information',
						4	=> 'order_confirmation',
						5	=> 'order_submitted'
					  );
					  
	return $checkoutSteps;
}

function fullFontName($key){
	$fullFontName = array(	'tahoma' 	=> 'Tahoma Bold',
							'mistral' 	=> 'Mistral Bold',
							'oreos' 	=> 'Oreos Bold',
							'impact' 	=> 'Impact',
							'monotype' 	=> 'Monotype Corsiva Bold'
						);
					
	return $fullFontName[$key];
}

function receipt(){
	$letters = explode(",",",A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z");
	$y = date("Y")-2000;
	$m = date("m");
	$d = date("d");
	$H = date("H");
	$i = date("i");
	$s = date("s");
	$W = date("W");
	
	$receipt = 	$letters[$y].
				$letters[$m].
				($d + $w).
				($H + $i + $s);
				
	return RECEIPTSUFFIX.$receipt;
}

# ENCRYPT/DECRYPT A STRING
# USAGE encryptMe($string); (string must be numeric only)
function cryptKeys($returnWhich){
	$cryptKey = "0,1,2,3,4,5,6,7,8,9,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z";
	$cryptVal = "7,d,o,6,g,T,K,M,r,t,p,Q,z,S,U,9,h,W,e,2,5,j,R,A,O,N,Z,I,B,0,q,y,8,c,b,F,a,k,Y,4,x,i,u,L,f,n,D,s,V,H,C,G,P,w,1,X,3,m,E,l,J,v";
	if($returnWhich == "cryptKey") 			return explode(",",$cryptKey);
	else if($returnWhich == "cryptVal")  	return explode(",",$cryptVal);
}

function encryptMe($string){
	$encryptedString = "";
	$cryptKey = cryptKeys('cryptKey');
	$cryptVal = cryptKeys('cryptVal');
	for($i=0; $i<strlen($string); $i++){
		$char = substr($string,$i,1);
		foreach($cryptKey as $k => $v){
			if($v == $char) $key = $k;
		}
		$char = $cryptVal[$key];
		$encryptedString .= $char;
	}
	
	return $encryptedString;
}

function decryptMe($string){
	$decryptedString = "";
	$cryptKey = cryptKeys('cryptKey');
	$cryptVal = cryptKeys('cryptVal');
	for($i=0; $i<strlen($string); $i++){
		$char = substr($string,$i,1);
		foreach($cryptVal as $k => $v){
			if($v == $char) $key = $k;
		}
		$char = $cryptKey[$key];
		$decryptedString .= $char;
	}
	
	return $decryptedString;
}

function personalizationOrderDetail($personalize, $checkout, $inCms=false, $orderCategory=0){
	$html = '<table width="'.($inCms === true ? '100%':'595').'">
		<tr>
			<td valign="top" width="'.($inCms === true ? '300':'380').'" style="padding-right:15px;">
				<table>
					<tr>
						<td class="formLabel" valign="top" align="right">Product:</td>
						<td valign="top">
							'.getField($personalize['product']['productId'],'products','title').'<br />
							'.getField($personalize['product']['productOptionsId'],'product_options','title').'
						</td>
					</tr>
					<tr>
						<td class="formLabel" valign="top" align="right">Personalization:</td>
						<td valign="top">
							"'.f($personalize['text_entry']['message']).'"<br />
							Type Face: '.fullFontName($personalize['text_entry']['font']).'<br />
							Location: '.getField($personalize['location'],'locations','title').'
						</td>
					</tr>
					<tr>
						<td class="formLabel" valign="top" align="right">Product Cost:</td>
						<td valign="top">'.($personalize['product']['price'] > 0 ? '$'.$personalize['product']['price']:'Existing Tool').'</td>
					</tr>
					<tr>
						<td class="formLabel" valign="top" align="right">Personalization:</td>
						<td valign="top">$'.$personalize['price'].'</td>
					</tr>
					<tr>
						<td class="formLabel" valign="top" align="right">Shipping:</td>
						<td valign="top">
							$'.$checkout['shipping_method']['price'].'<br />
							'.$checkout['shipping_method']['method'].'
						</td>
					</tr>
					<tr>
						<td class="formLabel" style="font-size:16px; padding-top:15px;" align="right">Total Cost:</td>
						<td style="font-size:16px; font-weight:bold; padding-top:15px;">$'.$checkout['total'].'</td>
					</tr>
				</table>
			</td>
			<td valign="top">
				<b>Shipping Address:</b><br />';
				
				$html .= f($checkout['shipping_address']['first_name'].' '.$_SESSION['checkout']['shipping_address']['last_name']).'<br />';
				$html .= f($checkout['shipping_address']['address'].' '.(trim($_SESSION['checkout']['shipping_address']['address2']) != "" ? $_SESSION['checkout']['shipping_address']['address2']:'')).'<br />';
				$html .= f($checkout['shipping_address']['city'].', '.strtoupper($_SESSION['checkout']['shipping_address']['state']).' '.$_SESSION['checkout']['shipping_address']['zip']).'<br />';
				$html .= f($checkout['shipping_address']['email']).'<br />';
				if(trim($checkout['shipping_address']['phone_number']) != ''){
					$html .= formatphone($checkout['shipping_address']['phone_number']).'<br />';		
				}
				
	$html .= '<p /><b>Billing Information:</b><br />';
				
				$html .= f($checkout['billing_information']['first_name'].' '.$checkout['billing_information']['last_name']).'<br />';
				$html .= f($checkout['billing_information']['address'].' '.(trim($checkout['billing_information']['address2']) != "" ? $checkout['billing_information']['address2']:'')).'<br />';
				$html .= f($checkout['billing_information']['city'].', '.strtoupper($checkout['billing_information']['state']).' '.$checkout['billing_information']['zip']).'<br />';
				
				if(!isset($_GET['printView'])){
					$ccNum = decryptMe($checkout['billing_information']['credit_card_number']);
					
					if($inCms === true){
						if($orderCategory == 9){
							$html .= $ccNum.'<br />';
							$html .= 'CVV2: '.$checkout['billing_information']['cvv2'].'<br />';
							$html .= 'Expiration: '.f($checkout['billing_information']['expiration_date']).'<br />';
						}
						
					} else {
						$html .= '**** **** **** '.substr($ccNum,(strlen($ccNum)-4), 4).'<br />';
						$html .= 'Expiration: '.f($checkout['billing_information']['expiration_date']).'<br />';
					}
				}				
				
	$html .= '</td>
		</tr>
	</table>';
	
	return $html;

}

?>