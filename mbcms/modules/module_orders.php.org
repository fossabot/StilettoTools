<?

echo '<h2>Order Details:</h2>';
echo personalizationOrderDetail(unserialize(stripslashes($qd['personalize'])),unserialize(stripslashes($qd['checkout'])),true,$qd['category']);

echo '<p style="font-size:14px; font-weight:bold;">';
if($qd['category'] == 9){
	echo 'Note: When you change an order to "charged", the customer\'s<br />
		  credit card information will be removed from this page.';
}
echo '</p>';

?>

