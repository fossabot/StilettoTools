<?php
/**
 * inc/configuration.php
 * Sets up EVERYTHING outside of the MB:CMS. Included in inc/db_functions.php
 * Code and Markup Copyright (c) Montana Banana
 */

##############################
# SETUP
# changes default emails, payment gateway, error reporting and shows debug data on front end
define('SITEURL',				'stilettotools.com');				// ie: montanab.com or site.montanab.com
define('SITENAME',				'Stiletto Tools');					// ie: Montana Banana
define('ABSOLUTEPATH',			'C:/www/stiletto/');

define('WEBMASTEREMAIL',		'jasonk@montanab.com');
define('MBNOTIFICATIONEMAIL',	'noah@montanab.com');

##############################
# CONNECTION DATA
if($_SERVER['SERVER_PORT'] == '8888'){
	define('DBHOST',				'localhost');
	define('DBUSER',				'root');
	define('DBPASS',				'root');
	define('DBNAME',				'stilettotools');
	define('SHOWDEVHTML',			 true);
	define('HASSSL',				 false);
	define('DEVMODE',				'debug'); // 'live' OR 'debug'
	
	define('ROOTPATH',				'/MontanaBanana/stilettotools.com/');
	
	// Jason's DEVELOPER fedex shipping info - requires developer keys from http://www.fedex.com/us/developer/web-services/index.html	
	define('SHIPPING_ACCOUNTNUMBER',		'510087100');
	define('SHIPPING_METERNUMBER',			'118636498');
	define('SHIPPING_KEY',					'VqxqldKNUHPocQZq');
	define('SHIPPING_PASSWORD',				'kog3IBugeHxy4DdulcXcGQE3l');
	
	// must match the account address/info
	define('SHIPPING_SENDERNAME',			'Jason Kenison');
	define('SHIPPING_COMPANYNAME',			'Montana Banana');
	define('SHIPPING_PHONENUMBER',			'2065551234');
	define('SHIPPING_ORIGINADDRESS',		'1234 Any St');
	define('SHIPPING_ORIGINCITY',			'Seattle');
	define('SHIPPING_ORIGINSTATE',			'WA');
	define('SHIPPING_ORIGINPOSTALCODE',		'98030');
	define('SHIPPING_ORIGINCOUNTRY',		'US');
	
	// change this by hand in wsdl/RateService_vXX.wsdl at the bottom of the page
	define('SHIPPING_RATEURL',				'https://wsbeta.fedex.com:443/web-services/rate');

} else {
	define('DBHOST',				'127.0.0.1:3306');
	define('DBUSER',				'Temproot');//'stilettotools');
	define('DBPASS',				'qoEblu$hou7#');//'sx9495hr');
	define('DBNAME',				'stilettotools');
	define('SHOWDEVHTML',			 false);
	define('HASSSL',				 true);
	define('DEVMODE',				'live'); // 'live' OR 'debug'
	
	define('ROOTPATH',				'/');

	// LIVE fedex shipping info - requires keys from http://www.fedex.com/us/developer/web-services/index.html	
	define('SHIPPING_ACCOUNTNUMBER',		'053205496');
	define('SHIPPING_METERNUMBER',			'104340599');
	define('SHIPPING_KEY',					'Ur4KaBUPv3RTsRF6');
	define('SHIPPING_PASSWORD',				'Trd8gPDWD8CKfbu0DALNNQKjJ');
	
	// must match the account address/info
	define('SHIPPING_SENDERNAME',			'Milwaukee Tool');
	define('SHIPPING_COMPANYNAME',			'Milwaukee Tool');
	define('SHIPPING_PHONENUMBER',			'18009871849');
	define('SHIPPING_ORIGINADDRESS',		'12385 Crossroads Drive');
	define('SHIPPING_ORIGINCITY',			'Olive Branch');
	define('SHIPPING_ORIGINSTATE',			'MS');
	define('SHIPPING_ORIGINPOSTALCODE',		'38654');
	define('SHIPPING_ORIGINCOUNTRY',		'US');
	
	// change this by hand in wsdl/RateService_vXX.wsdl at the bottom of the page
	define('SHIPPING_RATEURL',				'https://ws.fedex.com:443/web-services/rate');
}

##############################
# SITE OWNER INFORMATION
if(DEVMODE == 'debug'){
	define('GENERALEMAIL',		WEBMASTEREMAIL);
} else {
	define('GENERALEMAIL',		'info@stilettotools.com');
}
define('GENERALEMAILNAME',		 SITENAME);


##############################
# SUBMISSION DATA
define('RECEIPTSUFFIX',			'STL');
define('PAYMENTGTWY',			'none');			// LinkPoint, PayFloPro, Authorize.net or none. 
													// Uses inc/payment_gateway/[PAYMENTGTWY].php in submission

define('SHIPPINGAPI', 'fedex');						// if no rates returned, use flat rate defined below
define('FLATRATEGROUNDSHIPPING', 9.98);

//define('SHIPPINGAPI', 'fedex');					// Uses inc/shipping/[SHIPPINGAPI].php in submission

define('SHIPPINGAPIURL','https://gateway.fedex.com/web-services');
//define('SHIPPINGAPIURL','https://gatewaybeta.fedex.com/GatewayDC');

//if(DEVMODE == 'debug') define('SHIPPINGAPIURL', 'https://gatewaybeta.fedex.com/web-services/');
//else define('SHIPPINGAPIURL',	'https://gateway.fedex.com/web-services/');

define('DEFAULTPRODUCTWEIGHT',	2); // lbs.

define('EMAILFORMAT',			'plaintext');		// plaintext or HTML
define('CONTACT_NOTIFYCUSTOMER', false);

define('PERSONALIZATIONCOST',	29.99);

define('SHIPPING',				'first_name,last_name,address,address_2,city,state,zip,email,confirm_email,phone_number');
define('SHIPPING_REQUIRED',		'first_name,last_name,address,city,state,zip,email,confirm_email');

define('METHOD',				'method,price');
define('METHOD_REQUIRED',		'method,price');

define('BILLING',				'first_name,last_name,address,address_2,city,state,zip,credit_card_images,credit_card_number,expiration_date,cvv2');
define('BILLING_REQUIRED',		'first_name,last_name,address,city,state,zip,credit_card_number,cvv2');


define('CATALOG_POPUPWIDTH', 669);
define('CATALOG_POPUPHEIGHT', 504);

##############################
# SET ERROR REPORTING
if(DEVMODE == 'debug') 			error_reporting(E_ALL^E_DEPRECATED);
else 							error_reporting(0);

// eof
?>