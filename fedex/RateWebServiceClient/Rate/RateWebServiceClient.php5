<?php
// Copyright 2009, FedEx Corporation. All rights reserved.
// Version 12.0.0

require_once('fedex/library/fedex-common.php5');

$newline = "<br />";
//The WSDL is not included with the sample code.
//Please include and reference in $path_to_wsdl variable.
$path_to_wsdl = 'fedex/wsdl/RateService_v14.wsdl';

ini_set("soap.wsdl_cache_enabled", "0");
 
$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

$request['WebAuthenticationDetail'] = array(
	'UserCredential' =>array(
		'Key' => getProperty('key'), 
		'Password' => getProperty('password')
	)
); 
$request['ClientDetail'] = array(
	'AccountNumber' => getProperty('shipaccount'), 
	'MeterNumber' => getProperty('meter')
);
$request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Rate Request v14 using PHP ***');
$request['Version'] = array(
	'ServiceId' => 'crs', 
	'Major' => '14', 
	'Intermediate' => '0', 
	'Minor' => '0'
);
$request['ReturnTransitAndCommit'] = true;
$request['RequestedShipment']['DropoffType'] = 'REGULAR_PICKUP'; // valid values REGULAR_PICKUP, REQUEST_COURIER, ...
$request['RequestedShipment']['ShipTimestamp'] = date('c');
//$request['RequestedShipment']['ServiceType'] = 'FEDEX_GROUND'; // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, INTERNATIONAL_PRIORITY ...
$request['RequestedShipment']['PackagingType'] = 'YOUR_PACKAGING'; // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
$request['RequestedShipment']['TotalInsuredValue']=array(
	'Ammount'=>100,
	'Currency'=>'USD'
);
$request['RequestedShipment']['Shipper'] = addShipper();
$request['RequestedShipment']['Recipient'] = addRecipient();
//$request['RequestedShipment']['ShippingChargesPayment'] = addShippingChargesPayment();
$request['RequestedShipment']['RateRequestTypes'] = 'ACCOUNT'; 
$request['RequestedShipment']['RateRequestTypes'] = 'LIST'; 
$request['RequestedShipment']['PackageCount'] = '1';
$request['RequestedShipment']['RequestedPackageLineItems'] = addPackageLineItem1($totalWeight);

$supportedServiceTypes = array(
	'GROUND_HOME_DELIVERY',
	'FEDEX_EXPRESS_SAVER',
	'FEDEX_2_DAY',
	//'FEDEX_2_DAY_AM',
	'STANDARD_OVERNIGHT',
	'PRIORITY_OVERNIGHT',
	//'FIRST_OVERNIGHT'
);

try {
	if(setEndpoint('changeEndpoint')){
		$newLocation = $client->__setLocation(setEndpoint('endpoint'));
	}
	
	$response = $client->getRates($request);
	//die('<pre>'.print_r($response,true));
    
    //* mb version
    if($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR'){ 
    	// store rate options and prices array('name' => '', 'price' => '')
    	$shippingOptions = array();
    	
    	foreach($response->RateReplyDetails as $rateReply){
    		$serviceType = $rateReply->ServiceType;
	    	
	    	// check that option is supported, see list above
	    	if(in_array($serviceType, $supportedServiceTypes)){
	    		$price = $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;
				$shippingOptions[] = array('name' => $serviceType, 'price' => $price);
			}
    	}
    	
    	// options are given in expensive to cheapest, reverse it
    	$shippingOptions = array_reverse($shippingOptions);
	}
	//*/
    
    /* original fedex code  
    if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR'){  	
    	$rateReply = $response->RateReplyDetails;
    	echo '<table border="1">';
        echo '<tr><td>Service Type</td><td>Amount</td><td>Delivery Date</td></tr><tr>';
    	$serviceType = '<td>'.$rateReply->ServiceType . '</td>';
        $amount = '<td>$' . number_format($rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",") . '</td>';
        if(array_key_exists('DeliveryTimestamp',$rateReply)){
        	$deliveryDate= '<td>' . $rateReply->DeliveryTimestamp . '</td>';
        }else if(array_key_exists('TransitTime',$rateReply)){
        	$deliveryDate= '<td>' . $rateReply->TransitTime . '</td>';
        }else {
        	$deliveryDate='<td>&nbsp;</td>';
        }
        echo $serviceType . $amount. $deliveryDate;
        echo '</tr>';
        echo '</table>';
        
        printSuccess($client, $response);
    }else{
        printError($client, $response);
    }
    //*/
    
    //writeToLog($client);    // Write to log file 
    
} catch (SoapFault $exception) {
	//printFault($exception, $client);        
}

// set default pricing if nothing is returned from FedEx
if(!isset($shippingOptions) || count($shippingOptions) == 0){
	$fixedPrice = FLATRATEGROUNDSHIPPING;
    $numberOfProducts = 1;
    
    // send an email to MB saying no rates were returned
    $body = 'FedEx shipping calculator could not return any rates for zip code '.$orderData['zip'].', though the flat rate of $'.$fixedPrice.' was provided for this customer.';
    sendHTMLemail(MBNOTIFICATIONEMAIL, 'StilettoTools.com Notice', $body, 'info@stilettotools.com', 'Stiletto Tools');
    
	$rates[] = array(	
					'code' 	=> 'Ground Shipping',
					'name' 	=> 'Ground Shipping',
					'price'	=> str_replace(',','',number_format(($fixedPrice * $numberOfProducts),2))
				  );
}

function addShipper(){
	$shipper = getProperty('shipper');
	return $shipper;
}
function addRecipient(){
	$recipient = getProperty('recipient');
	return $recipient;	                                    
}
function addShippingChargesPayment(){
	$shippingChargesPayment = array(
		'PaymentType' => 'SENDER', // valid values RECIPIENT, SENDER and THIRD_PARTY
		'Payor' => array(
			'ResponsibleParty' => array(
				'AccountNumber' => getProperty('billaccount'),
				'CountryCode' => 'US'
			)
		)
	);
	return $shippingChargesPayment;
}
function addLabelSpecification(){
	$labelSpecification = array(
		'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
		'ImageType' => 'PDF',  // valid values DPL, EPL2, PDF, ZPLII and PNG
		'LabelStockType' => 'PAPER_7X4.75'
	);
	return $labelSpecification;
}
function addSpecialServices(){
	$specialServices = array(
		'SpecialServiceTypes' => array('COD'),
		'CodDetail' => array(
			'CodCollectionAmount' => array(
				'Currency' => 'USD', 
				'Amount' => 150
			),
			'CollectionType' => 'ANY' // ANY, GUARANTEED_FUNDS
		)
	);
	return $specialServices; 
}
function addPackageLineItem1($totalWeight){
	$packageLineItem = array(
		'SequenceNumber'=>1,
		'GroupPackageCount'=>1,
		'Weight' => array(
			'Value' => $totalWeight,
			'Units' => 'LB'
		),
		'Dimensions' => array(
			'Length' => 20,
			'Width' => 4,
			'Height' => 4,
			'Units' => 'IN'
		)
	);
	return $packageLineItem;
}
?>