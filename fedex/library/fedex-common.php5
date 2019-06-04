<?php
// Copyright 2009, FedEx Corporation. All rights reserved.

define('TRANSACTIONS_LOG_FILE', '../fedextransactions.log');  // Transactions log file

/**
 *  Print SOAP request and response
 */
define('Newline',"<br />");

function printSuccess($client, $response) {
    echo '<h2>Transaction Successful</h2>';  
    echo "\n";
    printRequestResponse($client);
}

function printRequestResponse($client){
	echo '<h2>Request</h2>' . "\n";
	echo '<pre style="white-space:pre-wrap;">' . htmlspecialchars($client->__getLastRequest()). '</pre>';  
	echo "\n";
   
	echo '<h2>Response</h2>'. "\n";
	echo '<pre style="white-space:pre-wrap;">' . htmlspecialchars($client->__getLastResponse()). '</pre>';
	echo "\n";
}

/**
 *  Print SOAP Fault
 */  
function printFault($exception, $client) {
    echo '<h2>Fault</h2>' . "<br>\n";                        
    echo "<b>Code:</b>{$exception->faultcode}<br>\n";
    echo "<b>String:</b>{$exception->faultstring}<br>\n";
    writeToLog($client);
    
    echo '<h2>Request</h2>' . "\n";
	echo '<pre>' . htmlspecialchars($client->__getLastRequest()). '</pre>';  
	echo "\n";
}

/**
 * SOAP request/response logging to a file
 */                                  
function writeToLog($client){  
if (!$logfile = fopen(TRANSACTIONS_LOG_FILE, "a"))
{
   error_func("Cannot open " . TRANSACTIONS_LOG_FILE . " file.\n", 0);
   exit(1);
}

fwrite($logfile, sprintf("\r%s:- %s",date("D M j G:i:s T Y"), $client->__getLastRequest(). "\n\n" . $client->__getLastResponse()));
}

/**
 * This section provides a convenient place to setup many commonly used variables
 * needed for the php sample code to function.
 */
function getProperty($var){
	if($var == 'key') return SHIPPING_KEY; 
	if($var == 'password') return SHIPPING_PASSWORD; 
		
	if($var == 'shipaccount') return SHIPPING_ACCOUNTNUMBER; 
	if($var == 'billaccount') return SHIPPING_BILLTONUMBER; 
	if($var == 'dutyaccount') return 'XXX'; 
	if($var == 'freightaccount') return SHIPPING_FREIGHTNUMBER;  
	if($var == 'trackaccount') return 'XXX'; 

	if($var == 'meter') return SHIPPING_METERNUMBER; 
		
	if($var == 'shiptimestamp') return mktime(10, 0, 0, date("m"), date("d")+1, date("Y"));

	if($var == 'spodshipdate') return '2013-05-21';
	if($var == 'serviceshipdate') return '2013-04-26';

	if($var == 'readydate') return '2010-05-31T08:44:07';
	if($var == 'closedate') return date("Y-m-d");

	if($var == 'pickupdate') return date("Y-m-d", mktime(8, 0, 0, date("m")  , date("d")+1, date("Y")));
	if($var == 'pickuptimestamp') return mktime(8, 0, 0, date("m")  , date("d")+1, date("Y"));
	if($var == 'pickuplocationid') return 'XXX';
	if($var == 'pickupconfirmationnumber') return 'XXX';

	if($var == 'dispatchdate') return date("Y-m-d", mktime(8, 0, 0, date("m")  , date("d")+1, date("Y")));
	if($var == 'dispatchlocationid') return 'XXX';
	if($var == 'dispatchconfirmationnumber') return 'XXX';		
	
	if($var == 'tag_readytimestamp') return mktime(10, 0, 0, date("m"), date("d")+1, date("Y"));
	if($var == 'tag_latesttimestamp') return mktime(20, 0, 0, date("m"), date("d")+1, date("Y"));	

	if($var == 'expirationdate') return '2013-05-24';
	if($var == 'begindate') return '2013-04-22';
	if($var == 'enddate') return '2013-04-25';	

	if($var == 'trackingnumber') return 'XXX';

	if($var == 'hubid') return 'XXX';
	
	if($var == 'jobid') return 'XXX';

	if($var == 'searchlocationphonenumber') return SHIPPING_PHONENUMBER;
			
	if($var == 'shipper') return array(
		'Contact' => array(
			'PersonName' => SHIPPING_SENDERNAME,
			'CompanyName' => SHIPPING_COMPANYNAME,
			'PhoneNumber' => SHIPPING_PHONENUMBER
		),
		'Address' => array(
			'StreetLines' => array(SHIPPING_ORIGINADDRESS),
			'City' => SHIPPING_ORIGINCITY,
			'StateOrProvinceCode' => SHIPPING_ORIGINSTATE,
			'PostalCode' => SHIPPING_ORIGINPOSTALCODE,
			'CountryCode' => SHIPPING_ORIGINCOUNTRY,
			'Residential' => 1
		)
	);
	if($var == 'recipient') return array(
		'Contact' => array(
			'PersonName' => $_SESSION['checkout']['shipping_address']['first_name'].' '.$_SESSION['checkout']['shipping_address']['last_name'],
			'CompanyName' => '',
			'PhoneNumber' => $_SESSION['checkout']['shipping_address']['phone_number']
		),
		'Address' => array(
			'StreetLines' => array($_SESSION['checkout']['shipping_address']['address'], $_SESSION['checkout']['shipping_address']['address_2']),
			'City' => $_SESSION['checkout']['shipping_address']['city'],
			'StateOrProvinceCode' => $_SESSION['checkout']['shipping_address']['state'],
			'PostalCode' => $_SESSION['checkout']['shipping_address']['zip'],
			'CountryCode' => 'US',
			'Residential' => 1
		)
	);	

	if($var == 'address1') return array(
		'StreetLines' => array('10 Fed Ex Pkwy'),
		'City' => 'Memphis',
		'StateOrProvinceCode' => 'TN',
		'PostalCode' => '38115',
		'CountryCode' => 'US'
    );
	if($var == 'address2') return array(
		'StreetLines' => array('13450 Farmcrest Ct'),
		'City' => 'Herndon',
		'StateOrProvinceCode' => 'VA',
		'PostalCode' => '20171',
		'CountryCode' => 'US'
	);					  
	if($var == 'searchlocationsaddress') return array(
		'StreetLines'=> array('240 Central Park S'),
		'City'=>'Austin',
		'StateOrProvinceCode'=>'TX',
		'PostalCode'=>'78701',
		'CountryCode'=>'US'
	);
									  
	if($var == 'shippingchargespayment') return array(
		'PaymentType' => 'SENDER',
		'Payor' => array(
			'ResponsibleParty' => array(
				'AccountNumber' => getProperty('billaccount'),
				'Contact' => null,
				'Address' => array('CountryCode' => 'US')
			)
		)
	);	
	if($var == 'freightbilling') return array(
		'Contact'=>array(
			'ContactId' => 'freight1',
			'PersonName' => 'Big Shipper',
			'Title' => 'Manager',
			'CompanyName' => 'Freight Shipper Co',
			'PhoneNumber' => '1234567890'
		),
		'Address'=>array(
			'StreetLines'=>array(
				'1202 Chalet Ln', 
				'Do Not Delete - Test Account'
			),
			'City' =>'Harrison',
			'StateOrProvinceCode' => 'AR',
			'PostalCode' => '72601-6353',
			'CountryCode' => 'US'
			)
	);
}

function setEndpoint($var){
	if($var == 'changeEndpoint') return false;
}

function printNotifications($notes){
	foreach($notes as $noteKey => $note){
		if(is_string($note)){    
            echo $noteKey . ': ' . $note . Newline;
        }
        else{
        	printNotifications($note);
        }
	}
	echo Newline;
}

function printError($client, $response){
    echo '<h2>Error returned in processing transaction</h2>';
	echo "\n";
	printNotifications($response -> Notifications);
    printRequestResponse($client, $response);
}

function trackDetails($details, $spacer){
	foreach($details as $key => $value){
		if(is_array($value) || is_object($value)){
        	$newSpacer = $spacer. '&nbsp;&nbsp;&nbsp;&nbsp;';
    		echo '<tr><td>'. $spacer . $key.'</td><td>&nbsp;</td></tr>';
    		trackDetails($value, $newSpacer);
    	}elseif(empty($value)){
    		echo '<tr><td>'.$spacer. $key .'</td><td>'.$value.'</td></tr>';
    	}else{
    		echo '<tr><td>'.$spacer. $key .'</td><td>'.$value.'</td></tr>';
    	}
    }
}
?>