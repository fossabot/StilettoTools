<? // DB_UPDATE
include('../inc/configuration.php');
include('../inc/db_functions.php');
include('../inc/global_functions.php');
include('inc/class.cropcanvas.php');

if(isset($_POST['id']) && ($_POST['do'] != 'add')) $id = $_POST['id'];

if(isset($_POST['category'])){
	$originalCategory = mysql_result(mysql_query("SELECT `category` FROM `".$_POST['db']."` WHERE `id`='$id' "),0);
}

// SET UP THE POST VARS INTO QUERY FORM
foreach($_POST as $key => $value) {
	if($key != 'MAX_FILE_SIZE' && $key != 'db' &&  $key != 'do' && $key != 'Submit' && $key != '' && $key != 'date' && $key != 'filelocation'  && $key != 'file' && $key != 'pdf_file' && $key != 'imageproperties'){
		if($_POST['do'] == 'edit' && $key != 'id'){
			if($key == 'description'){
				$content = str_replace("\r"," ",str_replace("\n"," ",addslashes($value))); // SKIP THE NL2BR SINCE USER USES HTML
			} else if(is_array($value)){
				foreach($value AS $k => $v) $content .= "".$v.",";
			} else {
				$content = nl2br(addslashes($value));
			}
			$qstring .= "`".$key."`='".$content."', ";
		} else if($_POST['do'] == 'add' && $key != 'id'){
			if(is_array($value)){
				foreach($value AS $k => $v) $values .= "".$v.",";
				$qkeys .= "`".$key."`,";
				$qvals .= "'".nl2br(addslashes($values))."',";
			} else {
				$qkeys .= "`".$key."`,";
				$qvals .= "'".nl2br(addslashes($value))."',";
			}
		} else if($_POST['do'] == 'delete'){
			if(is_array($value)){
				foreach($value AS $k => $v){
					$qstring .= "`id`='".$v."' OR ";
				}
			} else {
				$qstring .= "`id`='".$value."' OR ";
			}
		}
	}
	unset($content,$value,$values);
}

if(isset($_FILES['file']) && $_FILES['file']["error"] == '0'){
	if($_POST['do'] == 'edit'){
		$qstring .= "`file`='".filenameFormat($_FILES['file']['name'])."', ";
	} else if($_POST['do'] == 'add'){
		$qkeys .= "`file`,";
		$qvals .= "'".filenameFormat($_FILES['file']['name'])."',";
	}
}

// ** POST VARIABLES ARE CORRECTLY FORMATTED **
if(!isset($_POST['date'])) $date = date("Y-m-d");	// FORMAT: '2003-01-31'
else $date = $_POST['date'];						// OVERRIDE 'today' SETTING WITH VAR PASSED

if($_POST['do'] == 'edit'){
	$q = "UPDATE `".$_POST['db']."` SET ".$qstring."`date`='".$date."' WHERE `id`='".$id."'";
} else if($_POST['do'] == 'add'){
	$q = "INSERT INTO `".$_POST['db']."` (".$qkeys."`date`) VALUES (".$qvals."'".$date."')";
} else if($_POST['do'] == 'delete'){
	$q = "DELETE FROM `".$_POST['db']."` WHERE ".substr($qstring,0,(strlen($qstring)-4))."";
} else if($_GET['do'] == 'delete'){
	if(isset($_GET['category'])) $db = 'category';
	else $db = $_GET['db'];
	$q = "DELETE FROM `".$db."` WHERE `id`='".$_GET['id']."'";
}


/* FOR TESTING... VIEW POST DATA
echo "Montana Banana is bug testing this form. This message will be removed when it's confirmed working.<pre>";
echo $q."<p>";
print_r($_POST);
print_r($_FILES);
echo "</pre>";
exit;
//*****************************/

// EXECUTE QUERY
$queryForDebug = $q;
$result = mysql_query($q);

// GET THE ID OF WHATEVER WAS JUST POSTED IF THIS ISN'T AN UPDATE
if($_POST['do'] == 'add'){
	$id = mysql_insert_id();
}

// IF FILE IS BEING UPLOADED AND IT'S NOT image
if(isset($_FILES['file']) && $_FILES['file']['error'] == '0'){
	$destination = "../uploads/".filenameFormat(getField($_POST['users'],'users','title'));
	// IF DIRECTORY DOESN'T EXIST, MAKE IT. FULL READ/WRITE/EXECUTE ACCESS
	if(!is_dir($destination)){
		mkdir($destination, 0777);
		chmod($destination, 0777);
	}
	$dest = $destination."/".filenameFormat($_FILES['file']['name']);
	copy($_FILES['file']['tmp_name'], $dest);
	chmod($dest, 0777);
}

// IF FILE IS BEING UPLOADED ALSO, UPLOAD AND ASSOCIATE
$possibleImageUploads = array('image');
foreach($possibleImageUploads AS $key => $imageName){
	if((isset($_FILES[$imageName]) && $_FILES[$imageName]["error"] == '0')){
		$destination = "../uploads/".$_POST['filelocation'];

		// IF DIRECTORY DOESN'T EXIST, MAKE IT. FULL READ/WRITE/EXECUTE ACCESS
		if(!is_dir($destination)){
			mkdir($destination, 0777);
			chmod($destination, 0777);
		}
		
		if(isset($_POST['imageproperties']['width'])){
			$imageproperties_width = $_POST['imageproperties']['width'];
			$imageproperties_height = $_POST['imageproperties']['height'];
			$imageframe = $_POST['imageproperties']['frame'];
			$filename = $_POST['filelocation']."_".$id.".jpg";
		} else if(isset($_POST['imageproperties'][$imageName]['width'])){
			$imageproperties_width = $_POST['imageproperties'][$imageName]['width'];
			$imageproperties_height = $_POST['imageproperties'][$imageName]['height'];
			$imageframe = $_POST['imageproperties'][$imageName]['frame'];
			$filename = $_POST['filelocation']."_".$id."_".$imageName.".jpg";
		}
		
		$dest = $destination."/".$filename;
		copy($_FILES[$imageName]["tmp_name"], $dest);
		chmod($dest, 0777);
		
		// CREATE IMAGE AS PER SPEC
		$size = getimagesize($dest);
		if(isset($imageproperties_width)){
			if( ($imageproperties_height != 'null') && ($size[0] > $imageproperties_width) ){
				resizeimage($dest,($imageproperties_width),($imageproperties_height+2));
				$cc = new canvasCrop();
				$cc->loadImage($dest);
				if($imageproperties_height != 'null' && $imageproperties_height != 'NULL'){
					$cc->cropToSize($imageproperties_width, $imageproperties_height, ccCENTER);
				}
				if($imageframe != 'NULL') $cc->addFrame($imageframe,$imageproperties_width, $imageproperties_height);
				$cc->saveImage($dest, 90);
				$cc->flushImages();
			} else if($size[0] > $imageproperties_width){
				resizeimageMax($dest,$imageproperties_width,0,90);
			}
		}
		
		// CREATE POPUP IMAGE
		if(eregi("image",$filename)){
			$dest = $destination."/".str_replace("_image","_popup",$filename);
			copy($_FILES[$imageName]["tmp_name"], $dest);
			chmod($dest, 0777);
			
			// CREATE IMAGE AS PER SPEC
			resizeimage($dest,(CATALOG_POPUPWIDTH),(CATALOG_POPUPHEIGHT+2));
			$cc = new canvasCrop();
			$cc->loadImage($dest);
			$cc->cropToSize(CATALOG_POPUPWIDTH, CATALOG_POPUPHEIGHT, ccCENTER);
			$cc->saveImage($dest, 90);
			$cc->flushImages();
		}
	}
}

// STL ONLY FUNCTION: remove credit card info from orders if being changed to "Charged"
if($_POST['db'] == 'orders' && $_POST['do'] == 'edit' && isset($originalCategory)){
	$q = mysql_query("SELECT * FROM `orders` WHERE `id`='$id'");
	$qd = mysql_fetch_assoc($q);
	if($originalCategory == 9 && $qd['category'] != 9){
		$checkoutData = unserialize(stripslashes($qd['checkout']));
		if(isset($checkoutData['billing_information']['credit_card_number'])){
			unset($checkoutData['billing_information']['credit_card_number']);
			unset($checkoutData['billing_information']['cvv2']);
			unset($checkoutData['billing_information']['expiration_date']);
			$checkoutData = addslashes(serialize($checkoutData));
			
			mysql_query("UPDATE `orders` SET `checkout`='$checkoutData' WHERE `id`='$id'");
		}
	}
}

/******************************************************************
NOTIFY OF SUCCESS OR FAILURE. DIRECT TO EITHER HOME OR LAST PG   */
if(!$result){
?>
  <script language="JavaScript" type="text/javascript">
		function go_back(){
			history.back();
		}
		var msg = "Update Unsuccessful. Please Try Again.";
		alert(msg);
		go_back();
	</script>
<? } else { 
	$message = strtoupper($_POST['db']).' '.ucfirst($_REQUEST['do']);
	
	if(isset($_POST['db'])){
		$location = "index.html?do=view&pg=".($_POST['db']=='category' ? $_POST['type'] : $_POST['db']);
	} else {
		$location = "index.html?do=view&pg=".($_GET['db']=='category' ? $_GET['type'] : $_GET['db']);
	}
	
	?><script language="JavaScript" type="text/javascript">
		var msg = "<?=$message?> Successful\n";
		alert(msg);
		location.replace("<?=$location?>");
	</script><? 
} 
?>