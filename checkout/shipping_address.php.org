<?

// shipping fields defined in inc/configuration.php
$fields = explode(",",SHIPPING);
$required = explode(",",SHIPPING_REQUIRED);

?>
<form action="actions/checkout.php" method="post">
<input type="hidden" name="step" value="shipping_address" />
<table cellspacing="0" cellpadding="0">
<?
	foreach($fields as $key => $val){
		$value = '';
		if(isset($_SESSION['checkout']['shipping_address'][$val])){
			$value = f($_SESSION['checkout']['shipping_address'][$val]);
		}
		
		echo '<tr>';
		echo '<td class="formLabel">'.(in_array($val,$required) ? '*':'').varf($val).'</td>';
		echo '<td class="formField">';
		if($val == 'state'){
			echo selectBox($val,$value,0,selectStates());
		} else {
			echo '<input type="text" name="'.$val.'" value="'.$value.'" />';
		}
		echo '</td>';
		echo '</tr>';
	}
?>
	<tr>
		<td>&nbsp;</td>
		<td><br />
			<input type="image" src="images/buttons/continue_ini.gif" alt="Continue" value="submit" onmouseover="this.src='images/buttons/continue_ro.gif';" onmouseout="this.src='images/buttons/continue_ini.gif';" />
		</td>
	</tr>
</table>
</form>