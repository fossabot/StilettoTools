<?php

getContent('disclaimer');

?><p />
<input type="checkbox" name="agreeCheckbox" id="agreeCheckbox" value="true" onclick="agreeToTerms();" /> Yes, I agree to these conditions

<div class="continueButton" id="continueButton" style="visibility:hidden;">
	<form action="actions/personalize.php" method="post">
	<input type="hidden" name="step" value="2" />
	<input type="hidden" name="agree" id="agree" value="false" />
	<input type="image" src="images/buttons/continue_ini.gif" alt="Continue" value="submit" onmouseover="this.src='images/buttons/continue_ro.gif';" onmouseout="this.src='images/buttons/continue_ini.gif';" />
	</form>
</div>