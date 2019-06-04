<?

// shipping fields defined in inc/configuration.php
$fields = explode(",",BILLING);
$required = explode(",",BILLING_REQUIRED);

?>
<form action="actions/checkout.php" method="post">
<input type="hidden" name="step" value="billing_information" />
<table cellspacing="0" cellpadding="0">
<?
	foreach($fields as $key => $val){
		$value = '';
		if(isset($_SESSION['checkout']['billing_information'][$val]) && $val != 'credit_card_number'){
			$value = f($_SESSION['checkout']['billing_information'][$val]);
		}
		
		$label = $val;
		if($val == 'credit_card_images') $label = '&nbsp;';
		else if($val == 'cvv2') $label = strtoupper(varf($val));
		else $label = varf($val);
		
		echo '<tr>';
		echo '	<td class="formLabel">'.(in_array($val,$required) || $label == 'Expiration Date' ? '*':'').$label.'</td>';
		echo '	<td class="formField">';
		if($val == 'state'){
			echo selectBox($val,$value,0,selectStates());
			
		} else if($val == 'expiration_date'){
			$month = '';
			$year = '';
			if(eregi("/",$value)){
				$tmp = explode("/",$value);
				$month = $tmp[0];
				$year = '20'.$tmp[1];
			}
			echo selectBox('expiration_month',$month,'shortFormElement',selectMonth(),'Month').'&nbsp;';
			echo selectBox('expiration_year',$year,'shortFormElement',selectYear(),'Year');
		
		} else if($val == 'credit_card_images'){
			echo '&nbsp;<br /><img src="images/cart_ccimages.gif" alt="" width="138" height="19" />';
		
		} else if($val == 'cvv2'){
			echo '<input type="text" name="'.$val.'" class="shortFormElement" value="'.$value.'" /> ';
			echo '<small><a href="javascript:launchwin(\'images/cvv2_example.gif\',\''.$label.'\',\'width=340,height=175,scrollbars=no\');" style="color:#fff;">What\'s This?</a></small>';
			
		} else {
			echo '<input type="text" name="'.$val.'" value="'.$value.'" />';
		}
		echo '	</td>';
		echo '</tr>';
	}
?>
	<tr>
		<td>&nbsp;</td>
		<td><br /><input type="image" src="images/buttons/continue_ini.gif" alt="Continue" value="submit" onmouseover="this.src='images/buttons/continue_ro.gif';" onmouseout="this.src='images/buttons/continue_ini.gif';" /></td>
	</tr>
</table>
</form>