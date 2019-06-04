<form action="_test.php" method="post">
	<input type="text" name="var1" value="Montana" /><br />
	<input type="text" name="var2" value="Banana" /><br />
	<input type="hidden" name="hiddenVar1" value="Hiding in the shadows" />
	<br /><input type="submit" value="Test" />
</form>
<?php

if(isset($_POST['var1'])){
	echo 'Submitted Data:<pre />';
	print_r($_POST);
}

?>