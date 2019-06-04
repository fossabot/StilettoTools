<?php
/**
 * define the FLATRATEGROUNDSHIPPING in inc/configuration.php
 */
 
function shippingOptions($orderData){
    $fixedPrice = FLATRATEGROUNDSHIPPING;
    $numberOfProducts = 1;
    
	$rates = array(	'code' 	=> 'Ground Shipping',
					'name' 	=> 'Ground Shipping',
					'price'	=> str_replace(',','',number_format(($fixedPrice * $numberOfProducts),2))
				  );

	return array($rates);
}

?>