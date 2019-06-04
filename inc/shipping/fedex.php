<?php

function shippingOptions($orderData, $totalWeight){
	$rateTypes = array('1DY','2DY','3DY','GND');
	$rates = array();
	
	$fedexServices = array(	'FGD' => 'FedEx Ground',
							'FES' => 'FedEx Express Saver',
							'F2D' => 'FedEx 2-Day Standard',
							'FSO' => 'FedEx Standard Overnight'
							);
	
	foreach($fedexServices as $serviceKey => $serviceName){
		$myobj = new Fedex();
		$myobj->Set_CarrierCode1("FDX");
		$myobj->Set_CarrierAccount1(SHIPPING_ACCOUNTNUMBER);
		$myobj->Set_TotalClasses(1);
		$myobj->Set_ClassCode1('GND');
			
		$myobj->Set_DeliveryType("RES");
		
		$myobj->Set_ShipMethod("DRP");
		$myobj->Set_lShipService($serviceKey);
		
		$myobj->Set_OriginationName("");
		$myobj->Set_OriginationAddress1("");
		$myobj->Set_OriginationCity("");
		$myobj->Set_OriginationState(SHIPPING_ORIGINSTATE);
		$myobj->Set_OriginationPostal(SHIPPING_ORIGINPOSTALCODE);
		$myobj->Set_OriginationCountry("US");
		$myobj->Set_DestinationName("");
		$myobj->Set_DestinationAddress1($orderData['address']);
		$myobj->Set_DestinationCity($orderData['city']);
		$myobj->Set_DestinationState($orderData['state']);
		$myobj->Set_DestinationPostal($orderData['zip']);
		$myobj->Set_DestinationCountry("US");
		$myobj->Set_Currency("USD");
		$myobj->Set_TotalPackages(1);
		$myobj->Set_BoxID1(1);
		$myobj->Set_Weight1($totalWeight);
		$myobj->Set_WeightUnit1("LB");
		
		$myobj->Set_Length1(24);
		$myobj->Set_Width1(4);
		$myobj->Set_Height1(4);
		
		$myobj->Set_DimensionalUnit1("IN");
		$myobj->Set_Packaging1("BOX");
		
		$rate = $myobj->GetQuote();
		
		if($rate && $rate > 0){
			//$method = $myobj->GetMethod();
			$rates[] = array(	
						'code' 	=> $serviceKey,
						'name' 	=> $serviceName,
						'price'	=> number_format($rate, 2, '.', '')
					  );
		}
	}
	
	if(count($rates) == 0){
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
	
	return $rates;
}

class Fedex {
	var $Uri;
	var $Url;
	var $Username;
	var $Password;
	var $Version;
	var $ShipmentID;
	var $QueryID;
	var $TotalCarriers;
	var $CarrierCode1;
	var $CarrierAccount1;
	var $CarrierInvoiced1;
	var $TotalClasses;
	var $ClassCode1;
	var $DeliveryType;
	var $PrevDeliveryType;
	var $ShipMethod;
	var $OriginationName;
	var $OriginationAddress1;
	var $OriginationCity;
	var $OriginationState;
	var $OriginationPostal;
	var $OriginationCountry;
	var $DestinationName;
	var $DestinationAddress1;
	var $DestinationCity;
	var $DestinationState;
	var $DestinationPostal;
	var $DestinationCountry;
	var $Currency;
	var $TotalPackages;
	var $BoxID1;
	var $Weight1;
	var $WeightUnit1;
	var $Length1;
	var $Width1;
	var $Height1;
	var $DimensionalUnit1;
	var $Packaging1;
	var $Contents1;
	var $Cod1;
	var $Insurance1;
	var $TotalOptions;
	var $OptionCode1;

	var $quote =array();
	var $state = array();
	var $quotes = array();
	var $package_id;
	var $boxID;
	var $newdata;
	var $l_shipservice;

	//Bellow all these variables are created against Feature #433 for direct fedex api
	var $accountNumber;
	var $meterNumber;
	var $server = SHIPPINGAPIURL;
	var $service;
	var $dropoffType = "REGULARPICKUP";
	var $packaging = "YOURPACKAGING";
	var $payorType = "SENDER";
	var $price = "0";

	//var $state = array();
	//var $quote = array();

	/*************************************************************************
			Set the values here
	*************************************************************************/

	function Set_TotalCarriers($val="") {
		$this->TotalCarriers = $val;
	}

	function Set_CarrierCode1($val="") {
		$this->CarrierCode1 = $val;
	}
	
	function Set_CarrierAccount1($val="") {
		$this->CarrierAccount1 = $val;
	}

	function Set_CarrierInvoiced1($val="") {
		$this->CarrierInvoiced1 = $val;
	}

	function Set_TotalClasses($val="") {
		$this->TotalClasses =  $val;
	}

	function Set_ClassCode1($val="") {
		$this->ClassCode1 = $val;
	}

	function Set_ClassCode2($val="") {
		$this->ClassCode2 = $val;
	}

	function Set_ClassCode3($val="") {
		$this->ClassCode3 = $val;
	}

	function Set_ClassCode4($val="") {
		$this->ClassCode4 = $val;
	}

	function Set_DeliveryType($val="") {
		$this->DeliveryType = $val;
	}

	function Set_PreviousDeliveryType($val="") {
		$this->PrevDeliveryType = $val;
	}

	function Set_ShipMethod($val="") {
		$this->ShipMethod = $val;
	}

	function Set_OriginationName($val="") {
		$this->OriginationName = $val;
	}

	function Set_OriginationAddress1($val="") {
		$this->OriginationAddress1 = $val;
	}

	function Set_OriginationCity($val="") {
		$this->OriginationCity = $val;
	}

	function Set_OriginationState($val="") {
		$this->OriginationState = $val;
	}

	function Set_OriginationPostal($val="") {
		$this->OriginationPostal = $val;
	}

	function Set_OriginationCountry($val="") {
		$this->OriginationCountry = $val;
	}

	function Set_DestinationName($val="") {
		$this->DestinationName = $val;
	}

	function Set_DestinationAddress1($val="") {
		$this->DestinationAddress1 = $val;
	}

	function Set_DestinationCity($val="") {
		$this->DestinationCity = $val;
	}

	function Set_DestinationState($val="") {
		$this-> DestinationState = $val;
	}

	function Set_DestinationPostal($val="") {
		$this->DestinationPostal = $val;
	}

	function Set_DestinationCountry($val="") {
		$this->DestinationCountry = $val;
	}

	function Set_Currency($val="") {
		$this->Currency = $val;
	}

	function Set_TotalPackages($val="") {
		$this->TotalPackages = $val;
	}

	function Set_BoxID1($val="") {
		$this->BoxID1 = $val;
	}

	function Set_Weight1($val="") {
		// if($val > 150){
		// $val = 150;
		// }
		$this->Weight1 = $val;
	}

	function Set_WeightUnit1($val="") {
		$this->WeightUnit1 = $val;
	}

	function Set_Length1($val="") {
		$this->Length1 = $val;
	}

	function Set_Width1($val="") {
		$this->Width1 = $val;
	}

	function Set_Height1($val="") {
		$this->Height1 = $val;
	}

	function Set_DimensionalUnit1($val="") {
		$this->DimensionalUnit1 = $val;
	}

	function Set_Packaging1($val="") {
		$this->Packaging1 = $val;
	}

	function Set_Contents1($val="") {
		$this->Contents1 = $val;
	}

	function Set_Cod1($val="") {
		$this->Cod1 = $val;
	}

	function Set_Insurance1($val="") {
		$this->Insurance1 = $val;
	}

	function Set_TotalOptions($val="") {
		$this->TotalOptions = $val;
	}

	function Set_OptionCode1($val="") {
		$this->OptionCode1 = $val;
	}

	function Set_lshipservice($val = '') {
		$this->l_shipservice= $val;
	}

	//Bellow function created against Feature #433 for direct fedex api
	function getPrice() {
		require_once "xmlparser.php";
		//$header[] = "Host: www.smart-shop.com";
		$header[] = "MIME-Version: 1.0";
		$header[] = "Content-type: multipart/mixed; boundary=----doc";
		$header[] = "Accept: text/xml";
		$header[] = "Content-length: ".strlen($this->Uri);
		$header[] = "Cache-Control: no-cache";
		$header[] = "Connection: close \r\n";
		$header[] = $this->Uri;

		$ch = curl_init();
		//Disable certificate check.
		// uncomment the next line if you get curl error 60: error setting certificate verify locations
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		// uncommenting the next line is most likely not necessary in case of error 60
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		//-------------------------
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		//curl_setopt($ch, CURLOPT_CAINFO, "c:/ca-bundle.crt");
		//-------------------------
		curl_setopt($ch, CURLOPT_URL, $this->server);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 4);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

		$data = curl_exec($ch);
		
		if (curl_errno($ch)) {
			$this->getPrice();
		} else {
			// close curl resource, and free up system resources
			curl_close($ch);
			$array = GetXMLTree($data);
			
			//echo "<pre />"; print_r($array);
			
			if (isset($array['FDXRateReply']['Error']) && count($array['FDXRateReply']['Error'])) { // If it is error
				// $FDXerror = "Error Code =".$array['FDXRateReply']['Error']['Code'] ."Error Message =";
				$FDXerror = $array['FDXRateReply']['Error']['Message'];
				if (stristr($FDXerror, "Unknown Error.")) {
					$this->error = "<nobr>Please select local delivery</nobr><nobr> options at the left.</nobr>";
				}
				else
					$this->error = $FDXerror;
			}
			else if ($array['FDXRateReply']['EstimatedCharges']['DiscountedCharges']['NetCharge']>0) {
					$this->methodName = $array['FDXRateReply']['ReplyHeader']['CustomerTransactionIdentifier'];
					$this->price = $array['FDXRateReply']['EstimatedCharges']['DiscountedCharges']['NetCharge'];
				}
		}
	}


	//Bellow function created against Feature #433 for direct fedex api
	function Set_Uri_Direct_Fedex() {
		$fedexService['FPO']     = 'PRIORITYOVERNIGHT';//FedEx Priority Overnight
		$fedexService['FSO']     = 'STANDARDOVERNIGHT';//FedEx Standard Overnight
		$fedexService['FFO']     = 'FIRSTOVERNIGHT';//FedEx First Overnight
		$fedexService['F2D']     = 'FEDEX2DAY';//FedEx 2-Day Standard
		$fedexService['FES']     = 'FEDEXEXPRESSSAVER';//FedEx Express Saver
		$fedexService['FIP']     = 'INTERNATIONALPRIORITY';//FedEx International Priority
		$fedexService['FIE']     = 'INTERNATIONALECONOMY';//FedEx International Economy
		$fedexService['FGD']     = 'FEDEXGROUND';//FedEx Ground

		$this->accountNumber = SHIPPING_ACCOUNTNUMBER;
		$this->meterNumber = SHIPPING_METERNUMBER;
		$this->server = SHIPPINGAPIURL;
		$this->service = $fedexService[$this->l_shipservice];//"FedEx Ground";//
		$this->dropoffType = "REGULARPICKUP";
		$this->packaging = "YOURPACKAGING";
		$this->payorType = "SENDER";

		if ($this->service == 'FEDEXGROUND') {
			$this->CarrierCode1="FDXG";
		}
		else {
			$this->CarrierCode1="FDXE";
		}

		$weight = ceil($this->Weight1);
		$dimensions = ($this->Length1)+(2*($this->Width1))+(2*($this->Height1));

		if ($weight > 150 || $dimensions > 175) {
			$this->CarrierCode1="FDXE";
		}

		if ($this->DeliveryType == 'RES') {
			$deliveryType = 'true';
		}
		else {
			$deliveryType = 'false';
		}


		$this->WeightUnit1="LBS";

		$this->Uri = '<?xml version="1.0" encoding="UTF-8" ?>';
		$this->Uri .= '<FDXRateRequest xmlns:api="http://www.fedex.com/fsmapi" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
					xsi:noNamespaceSchemaLocation="FDXRateRequest.xsd">';
		$this->Uri .= '        <RequestHeader>';
		$this->Uri .= '            <CustomerTransactionIdentifier>Express Rate</CustomerTransactionIdentifier>';
		$this->Uri .= '            <AccountNumber>'.$this->accountNumber.'</AccountNumber>';
		$this->Uri .= '            <MeterNumber>'.$this->meterNumber.'</MeterNumber>';
		$this->Uri .= '            <CarrierCode>'.urlencode($this->CarrierCode1).'</CarrierCode>';
		$this->Uri .= '        </RequestHeader>';




		$this->Uri .= '        <DropoffType>'.$this->dropoffType.'</DropoffType>';
		$this->Uri .= '        <Service>'.$this->service.'</Service>';
		$this->Uri .= '        <Packaging>'.$this->packaging.'</Packaging>';
		$this->Uri .= '        <WeightUnits>'.urlencode($this->WeightUnit1).'</WeightUnits>';
		$this->Uri .= '        <Weight>'.$weight.'.0</Weight>';


		$this->Uri .= '        <OriginAddress>';
		//$this->Uri .= '            <StateOrProvinceCode>CA</StateOrProvinceCode>';
		$this->Uri .= '            <PostalCode>'.$this->OriginationPostal.'</PostalCode>';
		$this->Uri .= '            <CountryCode>'.urlencode($this->OriginationCountry).'</CountryCode>';
		$this->Uri .= '        </OriginAddress>';

		$this->Uri .= '        <DestinationAddress>';
		//$this->Uri .= '            <StateOrProvinceCode>CA</StateOrProvinceCode>';
		$this->Uri .= '            <PostalCode>'.urlencode($this->DestinationPostal).'</PostalCode>';
		$this->Uri .= '            <CountryCode>'.urlencode($this->DestinationCountry).'</CountryCode>';
		$this->Uri .= '        </DestinationAddress>';

		$this->Uri .= '        <Payment>';
		$this->Uri .= '            <PayorType>'.$this->payorType.'</PayorType>';
		$this->Uri .= '        </Payment>';

		$this->Uri .= '        <Dimensions>';
		$this->Uri .= '            <Length>'.urlencode($this->Length1).'</Length>';
		$this->Uri .= '            <Width>'.urlencode($this->Width1).'</Width>';
		$this->Uri .= '            <Height>'.urlencode($this->Height1).'</Height>';
		$this->Uri .= '            <Units>'.urlencode($this->DimensionalUnit1).'</Units>';
		$this->Uri .= '        </Dimensions>';


		$this->Uri .= '		  <SpecialServices>';
		$this->Uri .= '		  <ResidentialDelivery>'.$deliveryType.'</ResidentialDelivery>';
		$this->Uri .= '		  </SpecialServices>';

		$this->Uri .= '        <PackageCount>1</PackageCount>';

		$this->Uri .= '    </FDXRateRequest>';
		//echo htmlentities($this->Uri);

	}


	function startElement(&$Parser, &$Elem, $Attr) {

		array_push($this->state, $Elem);
		$states = join(' ', $this->state);
		//check what state we are in
		if ($states == "SHIPMENT PACKAGE") {

			$this->package_id = $Attr['ID'];
		}
		//check what state we are in
		elseif ($states == "SHIPMENT PACKAGE QUOTE") {


			$this->quote = array ( package_id => $package_id, id => $Attr['ID']);
		}
	}


	//funtion to parse the XML data. The routine does a series of conditional
	//checks on the data to determine where in the XML stack "we" are.
	function characterData($Parser, $Line) {

		$states = join(' ', $this->state);
		if ($states == "SHIPPMENT ERROR") {
			$error = $Line;
		}
		elseif ($states == "SHIPMENT PACKAGE BOXID") {

			$this->boxID = $Line;
		}
		elseif ($states == "SHIPMENT PACKAGE QUOTE CARRIER NAME") {

			$this->quote{carrier_name} = $Line;
		}
		elseif ($states == "SHIPMENT PACKAGE QUOTE CARRIER CODE") {

			$this->quote{carrier_code} = $Line;
		}
		elseif ($states == "SHIPMENT PACKAGE QUOTE CLASS NAME") {

			$this->quote{class_name} = $Line;
		}
		elseif ($states == "SHIPMENT PACKAGE QUOTE CLASS CODE") {

			$this->quote{class_code} = $Line;
		}
		elseif ($states == "SHIPMENT PACKAGE QUOTE SERVICE NAME") {

			$this->quote{service_name} = $Line;
		}
		elseif ($states == "SHIPMENT PACKAGE QUOTE SERVICE CODE") {

			$this->quote{service_code} = $Line;
		}
		elseif ($states == "SHIPMENT PACKAGE QUOTE RATE AMOUNT") {

			$this->quote['amount'] = $Line;
		}
	}


	// this function handles the end elements.
	// once encountered it sticks the quote into the hash $quotes
	// for easy access later
	function endElement($Parser, $Elem) {

		$states = join(' ', $this->state);
		if ($states == "SHIPMENT PACKAGE QUOTE") {
			unset ($this->quote['id']);
			unset ($this->quote['package_id']);
			// the $key is a combo of the carrier_code and service_code
			// this is the logical way to key each quote returned
			$key = $this->quote['carrier_code'] . ' ' . $this->quote['service_code'];
			$this->quotes[$this->boxID][$key] = $this->quote;
		}
		array_pop($this->state);
	}

	function GetData() {
		//Start printing the demo HTML page

		//Send the socket request with the uri/url
		//Start printing the demo HTML page
		//Send the socket request with the uri/url

		$fp = fsockopen($this->Url, 80, $errno, $errstr, 30);
		if (!$fp) {
			echo "Error: $errstr ($errno)<br>\n";
		}
		else {
			$depth = array();
			fputs($fp, "GET $this->Uri HTTP/1.0\r\nHost: $this->Url\r\n\r\n");
			//define the XML parsing routines/functions to call
			//based on the handler state
			$this->xml_parser = xml_parser_create();
			xml_set_object($this->xml_parser, $this);
			xml_set_element_handler($this->xml_parser, "startElement", "endElement");
			xml_set_character_data_handler($this->xml_parser, "characterData");
			//now lets roll through the data
			$dt = '';$dt1 = '';
			while ($data = fread($fp, 4096)) {
				//$dt .=  $data;
				$newdata = $data;
				/*fsockopen returns more infomation than we'd like. here we
 				remove the excess data.
	 		*/
				$newdata=trim($newdata);
				$newdata = preg_replace('/\r\n\r\n/', "", $newdata);
				$newdata = preg_replace('/HTTP.*\r\n/', "", $newdata);
				$newdata = preg_replace('/Server.*\r\n/', "", $newdata);
				$newdata = preg_replace('/Set.*/', "", $newdata);
				$newdata = preg_replace('/Con.*/', "", $newdata);
				$newdata = preg_replace('/Date.*\r\n/', "", $newdata);
				$newdata = preg_replace('/\r/', "", $newdata);
				$newdata = preg_replace('/\n/', "", $newdata);

				$dt1 .=  $newdata .'\n';
				/* if we properly cleaned up the XML stream/data we can now hand it off
				   to an XML parser without error
				*/

				if (!xml_parse($this->xml_parser, $newdata, feof($fp))) {
					die(sprintf("XML error: %s at line %d",
							xml_error_string(xml_get_error_code($this->xml_parser)),
							xml_get_current_line_number($this->xml_parser)));
				}

			}
			xml_parser_free($this->xml_parser);

			if (preg_match("/<error>(.*)<\/error>/", $newdata, $matches)) {
				$this->error = $matches[1];
			}
			//clean up the parser object
		}
	}//end the function

	function GetQuote() {
		$this->error = "";
		$this->Set_Uri_Direct_Fedex();
		$this->getPrice();
		if ($this->error != "") {
			return false;
			//return  $this->error;
		}
		else {
			return $this->price;
		}

	}//end of Quote_new

}//END OF CLASS


?>