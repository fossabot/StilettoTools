<?	// ACTION: SEND MAILER
	// BANANA_MAILER INSIDE MB:CMS.
	include('../inc/db_functions.php');
	
	# SEND HTML MAIL FUNCTION - 8/06/04
	function sendHTMLemail($to,$subject,$body,$femail,$fname) {
		$headers = "From: $fname <$femail>\n";
		$headersÊ.= "MIME-Version: 1.0\n";
		$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
		//$headers .= "Content-Transfer-Encoding:Êbase64\r\n\r\n";

		$tbody = trim($body);
		mail($to,$subject,$tbody,stripslashes($headers));
	}
	
	$body = str_replace("\n","",$_POST['description']);
	$subject = $_POST['subject'];
	$femail = $_POST['femail'];
	$fname = $_POST['fname'];
	
	$i=0; $n=0;
	$query = mysql_query("SELECT `email` FROM `users` WHERE `active`='0' AND `mailer`='0'");
	while ($query_data = mysql_fetch_assoc($query)) {
		$to = $query_data['email'];
		sendHTMLemail($to,$subject,stripslashes($body),$femail,$fname);
		$i++;
	}
	
	header("Location: index.html?pg=mailer&do=sent&num=$i");
	exit;
	
?>