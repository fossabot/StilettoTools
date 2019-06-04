<? // mbcms_login.php
include('../inc/configuration.php');
include('../inc/db_functions.php');

if($_POST['do'] == 'signin'){
	// CHECK DATABASE FOR USERNAME / PASSWORD
	$nameu = $_POST['nameu'];
	$q = mysql_query("SELECT * FROM `mbcms_users` WHERE `nameu`='$nameu'");
	$qd = mysql_fetch_assoc($q);
	
	if($_POST['nameu'] == '' || $_POST['pass'] == '' || ($qd['pass'] != $_POST['pass'])){
		// REDIRECT TO ERROR PAGE
		header("Location: index.html?error=login");
		exit;
		
	} else {
		// SET USER COOKIE WITH LOGIN DATA
		$userid = $qd['id'];
		$name = $qd['name'];
		$authlevel = $qd['level'];
		setcookie("mbcms_id", $userid, 0, "/",'');
		setcookie("mbcms_level", $authlevel, 0, "/",'');
		setcookie("mbcms_name", $name, 0, "/",'');
		$pg = $_POST['pg'];
	}
	
} else if($_GET['do'] == 'logout'){
	// DELETE SESSION COOKIES
	setcookie("mbcms_id", "", time()-36000, "/");
	setcookie("mbcms_level", "", time()-36000, "/");
	setcookie("mbcms_name", "", time()-36000, "/");
	header("Location: index.html");
	exit;
}

// REDIRECT USER TO MBCMS HOMEPAGE
header("Location: index.html");
exit;

?>