<? // DB_DELETE
include('../inc/configuration.php');
include('../inc/db_functions.php');

$query = "UPDATE `".$_GET['db']."` SET `".$_GET['field']."`='' WHERE `id`='".$_GET['id']."'";
if($_GET['type'] == 'file'){
	$filenameAndPath = "../uploads/files/".$_GET['filename'];
	unlink($filenameAndPath);
	$result = mysql_query($query);
} else if($_GET['type'] == 'image'){
	$filenameAndPath = "../".$_GET['db']."/".$_GET['filename'];
	unlink($filenameAndPath);
	$result = 1; // NO QUERY FOR DELETING AN IMAGE
}



/******************************************************************
NOTIFY OF SUCCESS OR FAILURE. DIRECT TO EITHER HOME OR LAST PG   */
if(!$result){
?>
  <script language="JavaScript" type="text/javascript">
		function go_back(){
			history.back();
		}
		var msg = "Update Unsuccessful. Please Try Again.\n<?=sql_error()?>";
		alert(msg);
		go_back();
	</script>
<? } else { ?>
  <script language="JavaScript" type="text/javascript">
		var msg = "<?=strtoupper($_POST['db'])?> <?=ucfirst($_REQUEST['do'])?> Successful\n";
		alert(msg);
		location.replace("<? if(isset($_POST['db'])) echo "index.html?do=view&pg=".($_POST['db']=='category' ? $_POST['type'] : $_POST['db'])."";
							 else  echo "index.html?do=view&pg=".($_GET['db']=='category' ? $_GET['type'] : $_GET['db']).""; ?>");
	</script>
<? } ?>